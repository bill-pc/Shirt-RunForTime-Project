<?php
// app/models/GhiNhanThanhPhamModel.php
require_once('ketNoi.php');
class GhiNhanThanhPhamModel {
    private $conn;
    public function __construct($db_connection) {
        
        if ($db_connection) {
            $this->conn = $db_connection;
        } else {
            die("Lỗi: Model không nhận được kết nối CSDL.");
        }
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