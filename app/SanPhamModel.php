<?php

class SanPhamModel {
    private $conn;


    public function __construct($db_connection) {
        
        if ($db_connection) {
            $this->conn = $db_connection;
        } else {
            die("Lỗi: Model không nhận được kết nối CSDL.");
        }
    }

    public function getAllSanPham() {
        $sql = 'SELECT maSanPham, tenSanPham FROM san_pham WHERE trangThaiSanPham = 1';
        $query = $this->conn->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>