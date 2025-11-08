<?php
class XuongModel {
    private $conn;
    public function __construct()
    {

        $database = new KetNoi();
        $this->conn = $database->connect();
        
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