<?php
require_once 'ketNoi.php';

class PhieuYeuCauNhapKhoModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    // 🔹 Lấy danh sách phiếu yêu cầu nhập kho
    public function getAll() {
        $sql = "SELECT p.maYCNK, p.ngayLap, p.trangThai, COUNT(c.maNVL) AS soLuongNVL
                FROM phieuyeucaunhapkhonvl p
                LEFT JOIN chitiet_phieuyeucaunhapkhonvl c ON p.maYCNK = c.maYCNK
                GROUP BY p.maYCNK, p.ngayLap, p.trangThai
                ORDER BY p.ngayLap DESC";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function getAllPlansForNhapKho() {
    $sql = "
        SELECT kh.maKHSX, kh.tenKHSX, kh.thoiGianBatDau, kh.thoiGianKetThuc
        FROM kehoachsanxuat kh
        WHERE kh.trangThai = 'Đã duyệt'
          AND kh.maKHSX NOT IN (
              SELECT DISTINCT p.maKHSX
              FROM phieuyeucaunhapkhonvl p
              WHERE p.maKHSX IS NOT NULL
          )
        ORDER BY kh.maKHSX DESC
    ";
    
    $result = $this->conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

    // 🔹 Lấy danh sách NVL từ kế hoạch sản xuất
    public function getMaterialsByPlan($maKHSX) {
        $sql = "SELECT c.maNVL, c.tenNVL, c.soLuongNVL AS soLuongCan,
                       n.soLuongTonKho, n.donViTinh
                FROM chitietkehoachsanxuat c
                JOIN nvl n ON c.maNVL = n.maNVL
                WHERE c.maKHSX = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $maKHSX);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    // 🔹 Kiểm tra kế hoạch đã có phiếu chưa
    public function existsByKeHoach($maKHSX) {
        $sql = "SELECT COUNT(*) AS total FROM phieuyeucaunhapkhonvl WHERE maKHSX = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $maKHSX);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] > 0;
    }

    // 🔹 Tạo mới phiếu nhập kho từ kế hoạch sản xuất
    // 🔹 Tạo mới phiếu nhập kho từ kế hoạch sản xuất
public function createPhieuYeuCauNhapKho($data) {
    $maKHSX = intval($data['maKHSX'] ?? 0);
    $nhaCungCap = trim($data['nhaCungCap'] ?? '');
    $ngayLap = $data['ngayLap'] ?? date('Y-m-d');
    $ghiChu = trim($data['ghiChu'] ?? '');
    $dsNVL = $data['nvl'] ?? [];

    if ($maKHSX <= 0 || empty($dsNVL)) {
        error_log("❌ Thiếu dữ liệu: maKHSX hoặc danh sách NVL rỗng");
        return false;
    }

    // ✅ Bước 1: Lọc các NVL thật sự cần nhập (soLuongCanNhap > 0)
    $sqlCheck = "
        SELECT c.maNVL, (c.soLuongNVL - n.soLuongTonKho) AS soLuongCanNhap
        FROM chitietkehoachsanxuat c
        JOIN nvl n ON c.maNVL = n.maNVL
        WHERE c.maKHSX = ?
          AND c.maNVL IN (" . implode(',', array_map('intval', $dsNVL)) . ")
          HAVING soLuongCanNhap > 0
    ";
    $stmtCheck = $this->conn->prepare($sqlCheck);
    $stmtCheck->bind_param('i', $maKHSX);
    $stmtCheck->execute();
    $needImport = $stmtCheck->get_result()->fetch_all(MYSQLI_ASSOC);

    // Không có NVL nào cần nhập → dừng
    if (count($needImport) === 0) {
        error_log("⚠️ Không có NVL nào cần nhập cho kế hoạch $maKHSX");
        return false;
    }

    // ✅ Bước 2: Tiến hành tạo phiếu
    $this->conn->begin_transaction();
    try {
        $maPhieu = 'YCNK' . date('ymdHis');

        // Lưu phiếu chính
        $sqlPhieu = "INSERT INTO phieuyeucaunhapkhonvl (maYCNK, maKHSX, ngayLap, nhaCungCap, ghiChu, trangThai)
                     VALUES (?, ?, ?, ?, ?, 'Chờ duyệt')";
        $stmt = $this->conn->prepare($sqlPhieu);
        $stmt->bind_param('sisss', $maPhieu, $maKHSX, $ngayLap, $nhaCungCap, $ghiChu);
        $stmt->execute();

        // Lưu chi tiết phiếu: chỉ những NVL cần nhập
        $sqlCT = "
            INSERT INTO chitiet_phieuyeucaunhapkhonvl (maYCNK, maNVL, soLuong, soLuongTonKho, soLuongCanNhap)
            SELECT ?, c.maNVL, c.soLuongNVL,
                   n.soLuongTonKho,
                   CASE
                       WHEN (c.soLuongNVL - n.soLuongTonKho) > 0 THEN (c.soLuongNVL - n.soLuongTonKho)
                       ELSE 0
                   END AS soLuongCanNhap
            FROM chitietkehoachsanxuat c
            JOIN nvl n ON c.maNVL = n.maNVL
            WHERE c.maKHSX = ?
              AND c.maNVL IN (" . implode(',', array_column($needImport, 'maNVL')) . ")
        ";
        $stmtCT = $this->conn->prepare($sqlCT);
        $stmtCT->bind_param('si', $maPhieu, $maKHSX);
        $stmtCT->execute();

        $this->conn->commit();
        return true;
    } catch (Exception $e) {
        $this->conn->rollback();
        error_log("❌ Lỗi lưu phiếu nhập kho: " . $e->getMessage());
        return false;
    }
}


    public function getChiTietPhieu($maYCNK) {
    $sql = "SELECT c.*, n.tenNVL, n.donViTinh
            FROM chitiet_phieuyeucaunhapkhonvl c
            JOIN nvl n ON c.maNVL = n.maNVL
            WHERE c.maYCNK = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param('s', $maYCNK);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

}
