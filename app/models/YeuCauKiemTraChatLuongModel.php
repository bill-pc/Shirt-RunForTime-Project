<?php
require_once 'ketNoi.php';

class YeuCauKiemTraChatLuongModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    // 🔹 Lấy danh sách kế hoạch đã duyệt
    public function getApprovedPlans() {
    $sql = "SELECT kh.maKHSX, kh.tenKHSX
            FROM kehoachsanxuat kh
            WHERE kh.trangThai = 'Đã duyệt'
              AND kh.maKHSX NOT IN (
                  SELECT DISTINCT maKHSX
                  FROM phieuyeucaukiemtrachatluong
                  WHERE maKHSX IS NOT NULL
              )";
    $result = $this->conn->query($sql);
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}


    // 🔹 Lấy nguyên vật liệu từ kế hoạch sản xuất
    public function getMaterialsByPlan($maKHSX) {
        $sql = "SELECT c.maNVL, c.tenNVL, c.soLuongNVL AS soLuong, x.tenXuong
                FROM chitietkehoachsanxuat c
                JOIN xuong x ON c.maXuong = x.maXuong
                WHERE c.maKHSX = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maKHSX);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // 🔹 Thêm phiếu yêu cầu kiểm tra chất lượng
    public function themPhieuYeuCau($tenNguoiLap, $tenSanPham, $maSanPham, $tongSoLuong, $maKHSX) {
    $sql = "INSERT INTO phieuyeucaukiemtrachatluong 
            (tenSanPham, maSanPham, maKHSX, soLuong, trangThaiPhieu, tenNguoiLap)
            VALUES (?, ?, ?, ?, 'Chờ kiểm tra', ?)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("siiss", $tenSanPham, $maSanPham, $maKHSX, $tongSoLuong, $tenNguoiLap);
    if ($stmt->execute()) {
        return $this->conn->insert_id;
    }
    return false;
}


    // 🔹 Thêm chi tiết phiếu yêu cầu (mỗi NVL)
    public function themChiTietPhieu($maYC, $tenNVL, $maSanPham, $soLuong) {
        $sql = "INSERT INTO chitietphieuyeucaukiemtrachatluong (maYC, tenSanPham, maSanPham, soLuong)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isii", $maYC, $tenNVL, $maSanPham, $soLuong);
        return $stmt->execute();
    }
}
?>
