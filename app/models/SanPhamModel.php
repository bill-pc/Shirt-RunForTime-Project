<?php

class SanPhamModel {
    private $conn;


    public function __construct()
    {

        $database = new KetNoi();
        $this->conn = $database->connect();
        
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