<?php
// app/models/GhiNhanThanhPhamModel.php
require_once('ketNoi.php');
class GhiNhanThanhPhamModel {
    private $conn;
    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    // Tính sản lượng trung bình/ngày từ bảng 'ghinhanthanhphamtheongay'
    public function getSoLuongTrungBinh() {
        // Tính trung bình cộng của cột 'soLuongSPHoanThanh'
        $sql = 'SELECT AVG(soLuongSPHoanThanh) AS avg_daily FROM ghinhanthanhphamtheongay';
        $query = $this->conn->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        $row = $result->fetch_assoc();
        
        // Làm tròn số và trả về (hoặc trả về 0 nếu chưa có dữ liệu)
        return round($row['avg_daily'] ?? 0); 
    }
}
?>