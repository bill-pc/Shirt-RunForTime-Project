<?php
require_once 'ketNoi.php';

class SuaNhanVienModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

   public function update($data)
{
    $sql = "UPDATE nguoidung 
        SET hoTen=?, gioiTinh=?, ngaySinh=?, phongBan=?, diaChi=?, email=?, soDienThoai=?
        WHERE maND=?";


    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        die("Lỗi prepare: " . $this->conn->error);
    }

    $stmt->bind_param(
    "sssssssi",
    $data['hoTen'],
    $data['gioiTinh'],
    $data['ngaySinh'],
    $data['phongBan'],
    $data['diaChi'],
    $data['email'],
    $data['soDienThoai'],
    $data['maND']
);


    $result = $stmt->execute();
    $stmt->close();

    return $result;
}

}
