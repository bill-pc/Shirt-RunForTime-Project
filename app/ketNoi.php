<?php
// app/models/KetNoi.php

class KetNoi {
    private $conn;
    private $host = '127.0.0.1'; // hoặc 'localhost'
    private $dbname = 'qlsx';
    private $username = 'root';
    private $password = 'admin'; // <-- ĐIỀN MẬT KHẨU CỦA BẠN VÀO ĐÂY (nếu có)

    public function __construct() {
        // Tắt báo cáo lỗi mặc định để xử lý tùy chỉnh
        mysqli_report(MYSQLI_REPORT_OFF);

        // Thử kết nối
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        // KIỂM TRA LỖI
        if ($this->conn->connect_error) {
            // Nếu kết nối thất bại, dừng chương trình và báo lỗi
            die("Kết nối CSDL thất bại: " . $this->conn->connect_error);
        }

        // Đặt bảng mã (encoding)
        $this->conn->set_charset("utf8mb4");
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>