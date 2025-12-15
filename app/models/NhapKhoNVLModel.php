<?php
require_once 'ketNoi.php';

class NhapKhoNVLModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    // 🔹 Lấy danh sách phiếu yêu cầu đã duyệt
   public function getApprovedRequests() {
    $sql = "SELECT p.maYCNK, p.tenPhieu, p.ngayLap, p.tenNguoiLap,
                   GROUP_CONCAT(DISTINCT c.nhaCungCap SEPARATOR ', ') as nhaCungCap
            FROM phieuyeucaunhapkhonvl p
            LEFT JOIN chitiet_phieuyeucaunhapkhonvl c ON p.maYCNK = c.maYCNK
            WHERE p.trangThai = 'Đã duyệt'
            GROUP BY p.maYCNK, p.tenPhieu, p.ngayLap, p.tenNguoiLap
            ORDER BY p.ngayLap DESC";
    
    $result = $this->conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}




    // 🔹 Lấy chi tiết NVL theo mã phiếu yêu cầu
public function getDetailsByRequest($maYCNK) {
    $sql = "SELECT n.maNVL, n.tenNVL, n.donViTinh, n.loaiNVL,
                   c.soLuong AS soLuongYeuCau,
                   c.nhaCungCap
            FROM chitiet_phieuyeucaunhapkhonvl c
            JOIN nvl n ON c.maNVL = n.maNVL
            WHERE c.maYCNK = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param('i', $maYCNK);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}





    // 🔹 Lưu phiếu nhập NVL + cập nhật tồn kho (Đơn giản)
   public function luuPhieuNhap($data) {
    $this->conn->begin_transaction();

    // Nếu không có items, không thực hiện lưu
    if (empty($data['items']) || !is_array($data['items'])) {
        throw new Exception('Không có mục nào để lưu vào kho.');
    }

    try {
        // ✅ Kiểm tra phiếu này đã nhập kho chưa
        $check = $this->conn->prepare("SELECT trangThai FROM phieuyeucaunhapkhonvl WHERE maYCNK=?");
        $check->bind_param("i", $data['maYCNK']);
        $check->execute();
        $result = $check->get_result()->fetch_assoc();

        if (!$result) {
            throw new Exception("Phiếu yêu cầu không tồn tại!");
        }
        if ($result['trangThai'] === 'Đã nhập kho') {
            throw new Exception("Phiếu này đã được nhập kho trước đó!");
        }

        // ✅ Lấy nhà cung cấp từ chi tiết phiếu yêu cầu
        $getNCC = $this->conn->prepare("SELECT maNVL, nhaCungCap FROM chitiet_phieuyeucaunhapkhonvl WHERE maYCNK=?");
        $getNCC->bind_param("i", $data['maYCNK']);
        $getNCC->execute();
        $nccList = $getNCC->get_result()->fetch_all(MYSQLI_ASSOC);
        $nccMap = [];
        foreach ($nccList as $row) {
            $nccMap[$row['maNVL']] = $row['nhaCungCap'];
        }

        // ✅ Lưu phiếu nhập NVL cho từng NVL
        foreach ($data['items'] as $item) {
            $maNVL = (int)$item['maNVL'];
            $soLuong = (int)$item['soLuong'];

            // Bỏ qua nếu số lượng <= 0
            if ($soLuong <= 0) continue;

            // Lấy nhà cung cấp từ phiếu yêu cầu
            $nhaCungCap = $nccMap[$maNVL] ?? '';

            // Insert phiếu nhập
            $stmtPN = $this->conn->prepare(
                "INSERT INTO phieunhapnvl 
                 (tenPNVL, nguoiLap, nhaCungCap, ngayNhap, maYCNK, maNVL, soLuongNhap)
                 VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            if (!$stmtPN) throw new Exception("Lỗi prepare insert: " . $this->conn->error);

            // Bind types: tenPNVL(s), nguoiLap(s), nhaCungCap(s), ngayNhap(s), maYCNK(i), maNVL(i), soLuong(i)
            $bindOk = $stmtPN->bind_param(
                'ssssiii',
                $data['tenPNVL'],
                $data['nguoiLap'],
                $nhaCungCap,
                $data['ngayNhap'],
                $data['maYCNK'],
                $maNVL,
                $soLuong
            );

            if (!$bindOk) {
                throw new Exception('Lỗi bind_param insert: ' . $stmtPN->error);
            }

            if (!$stmtPN->execute()) {
                $err = $stmtPN->error;
                $stmtPN->close();
                throw new Exception('Lỗi execute insert: ' . $err);
            }

            $stmtPN->close();

            // ✅ Cập nhật tồn kho
            $stmtUpdate = $this->conn->prepare("UPDATE nvl SET soLuongTonKho = soLuongTonKho + ? WHERE maNVL = ?");
            if (!$stmtUpdate) throw new Exception("Lỗi prepare update: " . $this->conn->error);
            $stmtUpdate->bind_param('ii', $soLuong, $maNVL);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        }

        // ✅ Đánh dấu phiếu yêu cầu đã nhập kho
        $stmtStatus = $this->conn->prepare("UPDATE phieuyeucaunhapkhonvl SET trangThai='Đã nhập kho' WHERE maYCNK=?");
        $stmtStatus->bind_param('i', $data['maYCNK']);
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
