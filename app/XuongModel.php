<?php
class XuongModel {
    private $conn;
    public function __construct($db_connection) {
        
        if ($db_connection) {
            $this->conn = $db_connection;
        } else {
            die("Lỗi: Model không nhận được kết nối CSDL.");
        }
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