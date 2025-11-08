<?php
require_once 'ketNoi.php';

class NhapKhoNVLModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    // 🔹 Lấy danh sách phiếu yêu cầu đã duyệt
   public function getApprovedRequests() {
    $sql = "SELECT DISTINCT maYCNK, ngayLap, nhaCungCap
            FROM phieuyeucaunhapkhonvl
            WHERE trangThai = 'Đã duyệt'";
    
    $result = $this->conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}




    // 🔹 Lấy chi tiết NVL theo mã phiếu yêu cầu
public function getDetailsByRequest($maYCNK) {
    $sql = "SELECT n.maNVL, n.tenNVL, n.donViTinh, n.loaiNVL,
                   c.soLuong AS soLuongYeuCau,
                   c.soLuongTonKho,
                   c.soLuongCanNhap
            FROM chitiet_phieuyeucaunhapkhonvl c
            JOIN nvl n ON c.maNVL = n.maNVL
            WHERE c.maYCNK = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param('s', $maYCNK);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}





    // 🔹 Lưu phiếu nhập NVL + cập nhật tồn kho
   public function luuPhieuNhap($data) {
    $this->conn->begin_transaction();

    try {
        // ✅ Kiểm tra phiếu này đã nhập kho chưa
        $check = $this->conn->prepare("SELECT trangThai FROM phieuyeucaunhapkhonvl WHERE maYCNK=?");
        $check->bind_param("s", $data['maYCNK']);
        $check->execute();
        $result = $check->get_result()->fetch_assoc();

        if (!$result) {
            throw new Exception("Phiếu yêu cầu không tồn tại!");
        }
        if ($result['trangThai'] === 'Đã nhập kho') {
            throw new Exception("Phiếu này đã được nhập kho trước đó!");
        }

        // ✅ Lưu phiếu nhập NVL
        $sqlPN = "INSERT INTO phieunhapnvl 
                  (tenPNVL, nguoiLap, nhaCungCap, ngayNhap, maYCNK, maNVL, soLuongNhap)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtPN = $this->conn->prepare($sqlPN);
        if (!$stmtPN) throw new Exception("Lỗi prepare: " . $this->conn->error);

foreach ($data['items'] as $item) {
    $maNVL = (int)$item['maNVL'];
    $soLuong = (int)$item['soLuong'];

    // Bỏ qua nếu số lượng <= 0
    if ($soLuong <= 0) continue;

    // ✅ Chuẩn bị statement mới mỗi vòng (tránh cache giá trị)
    $stmtPN = $this->conn->prepare(
        "INSERT INTO phieunhapnvl 
         (tenPNVL, nguoiLap, nhaCungCap, ngayNhap, maYCNK, maNVL, soLuongNhap)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    if (!$stmtPN) throw new Exception("Lỗi prepare insert: " . $this->conn->error);

    $stmtPN->bind_param(
        'ssssssi',
        $data['tenPNVL'],
        $data['nguoiLap'],
        $data['nhaCungCap'],
        $data['ngayNhap'],
        $data['maYCNK'],
        $maNVL,
        $soLuong
    );
    $stmtPN->execute();
    $stmtPN->close();

    // ✅ Cập nhật tồn kho riêng biệt
    $stmtUpdate = $this->conn->prepare("UPDATE nvl SET soLuongTonKho = soLuongTonKho + ? WHERE maNVL = ?");
    if (!$stmtUpdate) throw new Exception("Lỗi prepare update: " . $this->conn->error);
    $stmtUpdate->bind_param('ii', $soLuong, $maNVL);
    $stmtUpdate->execute();
    $stmtUpdate->close();
}





        // ✅ Đánh dấu phiếu yêu cầu đã nhập kho
        $stmtStatus = $this->conn->prepare("UPDATE phieuyeucaunhapkhonvl SET trangThai='Đã nhập kho' WHERE maYCNK=?");
        $stmtStatus->bind_param('s', $data['maYCNK']);
        $stmtStatus->execute();

        $this->conn->commit();
        return ['success' => true, 'message' => 'Phiếu nhập kho đã lưu thành công và cập nhật tồn kho!'];

    } catch (Exception $e) {
        $this->conn->rollback();
        return ['success' => false, 'message' => "❌ Lỗi khi lưu phiếu nhập: " . $e->getMessage()];
    }
}

}
?>
