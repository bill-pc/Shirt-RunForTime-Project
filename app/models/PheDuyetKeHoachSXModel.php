<?php
require_once 'ketNoi.php';

class PheDuyetKeHoachSXModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    // ✅ 1. Lấy danh sách kế hoạch sản xuất chờ duyệt
    public function getPendingPlans() {
        $sql = "SELECT maKHSX, tenKHSX, thoiGianBatDau, thoiGianKetThuc, trangThai
        FROM kehoachsanxuat
        WHERE trangThai = 'Chờ duyệt'
        ORDER BY thoiGianBatDau DESC";

        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // ✅ 2. Lấy chi tiết kế hoạch (sản phẩm, NVL, xưởng)
    public function getPlanDetails($maKHSX) {
        $sql = "SELECT k.maKHSX, k.maDonHang, k.ngayBatDau, k.ngayKetThuc, k.ghiChu,
                       s.tenSanPham, s.soLuongSanXuat, x.tenXuong
                FROM kehoachsanxuat k
                LEFT JOIN sanpham s ON k.maSanPham = s.maSanPham
                LEFT JOIN xuong x ON k.maXuong = x.maXuong
                WHERE k.maKHSX = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $maKHSX);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();

        // ✅ Lấy chi tiết nguyên vật liệu cho kế hoạch
        $sqlNVL = "SELECT c.maNVL, n.tenNVL, n.donViTinh, n.soLuongTonKho, c.soLuongNVL AS soLuongCan, 
                          CASE 
                            WHEN n.soLuongTonKho >= c.soLuongNVL THEN 'Đủ kho'
                            ELSE CONCAT('Thiếu ', c.soLuongNVL - n.soLuongTonKho)
                          END AS ghiChu
                   FROM chitietkehoachsanxuat c
                   JOIN nvl n ON c.maNVL = n.maNVL
                   WHERE c.maKHSX = ?";
        $stmtNVL = $this->conn->prepare($sqlNVL);
        $stmtNVL->bind_param('i', $maKHSX);
        $stmtNVL->execute();
        $data['nguyenVatLieu'] = $stmtNVL->get_result()->fetch_all(MYSQLI_ASSOC);

        return $data;
    }

    public function updatePlanStatus($maKHSX, $trangThai, $ghiChu = '') {
    $sql = "UPDATE kehoachsanxuat SET trangThai = ?, ghiChu = ? WHERE maKHSX = ?";
    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        die("❌ Lỗi prepare SQL: " . $this->conn->error);
    }

    $stmt->bind_param("ssi", $trangThai, $ghiChu, $maKHSX);

    if (!$stmt->execute()) {
        die("❌ Lỗi khi cập nhật kế hoạch: " . $stmt->error);
    }

    // Debug để kiểm tra có bản ghi nào được update
    if ($stmt->affected_rows === 0) {
        echo "<script>alert('⚠️ Không có bản ghi nào được cập nhật (mã kế hoạch không tồn tại).');</script>";
    }

    $stmt->close();
}
public function addApprovalHistory($maKHSX, $hanhDong, $ghiChu, $nguoiThucHien) {
    $sql = "INSERT INTO lichsupheduyet (maKHSX, hanhDong, ghiChu, nguoiThucHien) VALUES (?, ?, ?, ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("isss", $maKHSX, $hanhDong, $ghiChu, $nguoiThucHien);
    $stmt->execute();
    $stmt->close();
}

public function getApprovalHistory($maKHSX) {
    $sql = "SELECT hanhDong, ghiChu, nguoiThucHien, thoiGian 
            FROM lichsupheduyet 
            WHERE maKHSX = ? 
            ORDER BY thoiGian DESC";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $maKHSX);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}


}
?>
