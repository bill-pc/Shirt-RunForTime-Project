<?php
require_once 'ketNoi.php';

class YeuCauKiemTraChatLuongModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    // 🔹 Lấy danh sách kế hoạch đã duyệt (chưa có phiếu KTCL)
    public function getApprovedPlans() {
        $sql = "SELECT kh.maKHSX, kh.tenKHSX, kh.thoiGianBatDau, kh.thoiGianKetThuc,
                       sp.maSanPham, sp.tenSanPham, dh.soLuongSanXuat
                FROM kehoachsanxuat kh
                JOIN donhangsanxuat dh ON kh.maDonHang = dh.maDonHang
                JOIN san_pham sp ON kh.maSanPham = sp.maSanPham
                WHERE kh.trangThai = 'Đã duyệt'
                  AND kh.maKHSX NOT IN (
                      SELECT DISTINCT maKHSX
                      FROM phieuyeucaukiemtrachatluong
                      WHERE maKHSX IS NOT NULL
                  )
                ORDER BY kh.maKHSX DESC";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }


    // 🔹 Lấy thông tin sản phẩm từ kế hoạch sản xuất
    public function getProductByPlan($maKHSX) {
        $sql = "SELECT kh.maKHSX, kh.tenKHSX, 
                       sp.maSanPham, sp.tenSanPham, sp.donVi,
                       dh.soLuongSanXuat, dh.tenDonHang
                FROM kehoachsanxuat kh
                JOIN donhangsanxuat dh ON kh.maDonHang = dh.maDonHang
                JOIN san_pham sp ON kh.maSanPham = sp.maSanPham
                WHERE kh.maKHSX = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maKHSX);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    // 🔹 Thêm phiếu yêu cầu kiểm tra chất lượng
    public function themPhieuYeuCau($tenNguoiLap, $tenPhieu, $maSanPham, $maKHSX) {
        // Lấy maND từ session
        session_start();
        $maND = $_SESSION['user']['maND'] ?? 1;
        
        $ngayLap = date('Y-m-d');
        $trangThai = 'Chờ duyệt';
        
        $sql = "INSERT INTO phieuyeucaukiemtrachatluong 
                (tenPhieu, maSanPham, trangThai, ngayLap, tenNguoiLap, maND, maKHSX)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sisssis", $tenPhieu, $maSanPham, $trangThai, $ngayLap, $tenNguoiLap, $maND, $maKHSX);
        
        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }


    // 🔹 Thêm chi tiết phiếu yêu cầu kiểm tra
    public function themChiTietPhieu($maYC, $maSanPham, $tenSanPham, $soLuong, $donViTinh) {
        $trangThaiSanPham = 'Chờ kiểm tra';
        
        $sql = "INSERT INTO chitietphieuyeucaukiemtrachatluong 
                (maYC, maSanPham, tenSanPham, soLuong, donViTinh, trangThaiSanPham)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisiss", $maYC, $maSanPham, $tenSanPham, $soLuong, $donViTinh, $trangThaiSanPham);
        return $stmt->execute();
    }
}
?>
