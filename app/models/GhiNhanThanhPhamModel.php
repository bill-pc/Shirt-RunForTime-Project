<?php
// app/models/GhiNhanThanhPhamModel.php
require_once('ketNoi.php');
class GhiNhanThanhPhamModel {
    private $conn;
    public function __construct() {
        // Giả sử tệp ketNoi.php định nghĩa class Database với hàm connect()
        $this->conn = (new KetNoi())->connect();
    }

   public function getSoLuongTrungBinh() {
        $sql = 'SELECT AVG(soLuongSPHoanThanh) AS avg_daily FROM ghinhanthanhphamtheongay';
        $query = $this->conn->prepare($sql);
        
        if (!$query) {
            error_log("Prepare failed: " . $this->conn->error);
            return 0;
        }

        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        
        return round($row['avg_daily'] ?? 0); 
    }

    public function luuGhiNhan($data) {
        $sql = "INSERT INTO ghinhanthanhphamtheongay 
                (maKHSX, maSanPham, maNhanVien, soLuongSPHoanThanh, ngayLam)
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Lỗi prepare luuGhiNhan: " . $this->conn->error);
            return false;
        }

        // Cột trong CSDL là maNhanVien, không phải maND
        $stmt->bind_param(
            "iiiis",
            $data['maKHSX'],
            $data['maSanPham'],
            $data['maNhanVien'], 
            $data['soLuongSPHoanThanh'],
            $data['ngayLam']
        );
        
        $result = $stmt->execute();
        if (!$result) {
            error_log("Lỗi execute luuGhiNhan: " . $stmt->error);
        }
        $stmt->close();
        return $result;
    }

    public function getGhiNhanHomNay() {
        $sql = "SELECT 
                    g.ngayLam,
                    k.tenKHSX,
                    s.tenSanPham,
                    n.hoTen AS tenNhanVien,
                    n.phongBan AS tenXuong, -- Lấy xưởng từ người dùng
                    g.soLuongSPHoanThanh
                FROM ghinhanthanhphamtheongay g
                JOIN kehoachsanxuat k ON g.maKHSX = k.maKHSX
                JOIN san_pham s ON g.maSanPham = s.maSanPham
                JOIN nguoidung n ON g.maNhanVien = n.maND -- Bảng SQL dùng maNhanVien
                WHERE g.ngayLam = CURDATE()
                ORDER BY g.maGhiNhan DESC";
        
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
?>