<?php
require_once 'ketNoi.php';

class SuaNhanVienModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    public function update($data) {
        $sql = "UPDATE nguoidung 
                SET hoTen=?, chucVu=?, phongBan=?, diaChi=?, email=?, soDienThoai=? 
                WHERE maND=?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['hoTen'],
            $data['chucVu'],
            $data['phongBan'],
            $data['diaChi'],
            $data['email'],
            $data['soDienThoai'],
            $data['maND']
        ]);
    }
}
