<?php
// app/models/NVLModel.php

class NVLModel {
    private $conn;

    public function __construct($db_connection) {
        
        if ($db_connection) {
            $this->conn = $db_connection;
        } else {
            die("Lỗi: Model không nhận được kết nối CSDL.");
        }
    }

    /**
     * Lấy tất cả NVL từ bảng 'nvl'
     *
     */
    public function getAllNVL() {
        $sql = 'SELECT maNVL, tenNVL, donViTinh FROM nvl WHERE soLuongTonKho > 0'; // Chỉ lấy NVL còn tồn kho
        $query = $this->conn->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>