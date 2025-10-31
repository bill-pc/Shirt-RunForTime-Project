<?php
class XuongModel {
    private $conn;
    public function __construct() {
        require_once 'ketNoi.php'; 
        $this->conn = (new Database())->connect();
    }

    public function getAllXuong() {
        $sql = 'SELECT maXuong, tenXuong FROM xuong';
        $query = $this->conn->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>