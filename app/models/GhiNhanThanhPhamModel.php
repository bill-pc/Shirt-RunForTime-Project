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
}
?>