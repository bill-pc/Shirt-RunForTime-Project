<?php
require_once 'ketNoi.php';

class KeHoachSanXuatModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    // 🔹 Lấy danh sách kế hoạch sản xuất đã duyệt (để chọn lập phiếu nhập kho)
    public function getAllPlansForNhapKho() {
        $sql = "SELECT maKHSX, tenKHSX, thoiGianBatDau, thoiGianKetThuc, trangThai
                FROM kehoachsanxuat
                WHERE trangThai = 'Đã duyệt'";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die('❌ Lỗi prepare: ' . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // 🔹 Lấy chi tiết kế hoạch theo ID
    public function getPlanById($maKHSX) {
        $sql = "SELECT kh.tenKHSX, kh.thoiGianKetThuc, nd.hoTen AS tenNguoiLap
                FROM kehoachsanxuat kh
                JOIN nguoidung nd ON kh.maND = nd.maND
                WHERE kh.maKHSX = ?";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Lỗi chuẩn bị truy vấn KHSX ID: " . $this->conn->error);
            return null;
        }

        $stmt->bind_param("i", $maKHSX);
        if (!$stmt->execute()) {
            error_log("Lỗi thực thi truy vấn KHSX ID: " . $stmt->error);
            return null;
        }

        $result = $stmt->get_result();
        $data = $result ? $result->fetch_assoc() : null;
        $stmt->close();
        return $data;
    }

    // 🔹 Lấy danh sách NVL thuộc kế hoạch sản xuất
    public function getMaterialsForPlan($maKHSX) {
    $sql = "SELECT 
                c.maNVL,
                c.tenNVL,
                c.soLuongNVL AS soLuongCan,
                n.soLuongTonKho,
                n.donViTinh
            FROM chitietkehoachsanxuat c
            LEFT JOIN nvl n ON c.maNVL = n.maNVL
            WHERE c.maKHSX = ?";
    
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        error_log('❌ Lỗi prepare NVL cho KHSX: ' . $this->conn->error);
        return [];
    }

    $stmt->bind_param("i", $maKHSX);
    if (!$stmt->execute()) {
        error_log('❌ Lỗi execute NVL cho KHSX: ' . $stmt->error);
        return [];
    }

    $result = $stmt->get_result();
    $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $stmt->close();
    return $data;
}
    // 🔹 Lấy danh sách kế hoạch sản xuất chờ duyệt
    public function getPendingPlans() {
        $sql = "SELECT maKHSX, tenKHSX, thoiGianBatDau, thoiGianKetThuc, trangThai
                FROM kehoachsanxuat
                WHERE trangThai = 'Chờ duyệt'
                ORDER BY thoiGianBatDau DESC";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log('❌ Lỗi prepare getPendingPlans: ' . $this->conn->error);
            return [];
        }


        if (!$stmt->execute()) {
            error_log('❌ Lỗi execute getPendingPlans: ' . $stmt->error);
            return [];
        }

        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        return $data;
    }

  // ✅ Hàm chung để lấy danh sách kế hoạch sản xuất (dùng cho YeuCauNVLController)
     // ✅ Hàm lấy tất cả kế hoạch sản xuất
    public function getAllPlans() {
        $sql = "SELECT maKHSX, tenKHSX, thoiGianBatDau, thoiGianKetThuc, trangThai
                FROM kehoachsanxuat
                ORDER BY thoiGianBatDau DESC";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>
