<?php
require_once 'ketnoi.php'; // đường dẫn đến file ketnoi.php

class CongViecModel {
    private $conn;

    public function __construct() {
        $database = new Database();     // gọi class Database
        $this->conn = $database->connect(); // tạo kết nối PDO
    }

    public function getAll() {
        $sql = "SELECT * FROM congviec ORDER BY maCongViec DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM congviec WHERE maCongViec = :maCongViec";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maCongViec', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM congviec WHERE maCongViec = :maCongViec";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':maCongViec', $id);
        return $stmt->execute();
    }

    // thêm nếu cần chức năng thêm/sửa:
    public function insert($data) {
        $sql = "INSERT INTO congviec (maCongViec, tieuDe, moTa, trangThai, ngayHetHan)
                VALUES (:maCongViec, :tieuDe, :moTa, :trangThai, :ngayHetHan)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($data) {
        $sql = "UPDATE congviec 
                SET maCongViec=:maCongViec, tieuDe=:tieuDe, moTa=:moTa, trangThai=:trangThai, ngayHetHan=:ngayHetHan 
                WHERE id=:id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
}
