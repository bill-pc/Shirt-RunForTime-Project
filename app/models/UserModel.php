<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Lấy thông tin người dùng theo maTK
    public function getUserById($maTK) {
        $sql = "SELECT maTK, hoTen, chucVu, soDienThoai, email, diaChi
                FROM nguoidung
                WHERE maTK = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return null;
        }

        $stmt->bind_param("i", $maTK);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();

        return $user ?: null;
    }
}
?>
