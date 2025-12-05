<?php
class KetNoi {
    // === THAY ĐỔI THÔNG TIN KẾT NỐI CỦA BẠN Ở ĐÂY ===
    private $host = "localhost";
    private $user = "root";
    private $pass = "admin";     // Mật khẩu XAMPP của bạn (thường là rỗng)
    
    // Tên CSDL bạn đã import (ví dụ: QLAo)
    private $dbname = "qlsx_test";   
    // =============================================

    private $conn; // Biến để giữ kết nối

    /**
     * Hàm kết nối CSDL
     * @return mysqli
     */
    public function connect() {
        // Nếu đã kết nối rồi, dùng lại kết nối cũ
        if ($this->conn) {
            return $this->conn;
        }

        // Tạo kết nối mới
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        // Kiểm tra lỗi kết nối
        if ($this->conn->connect_error) {
            die("❌ Kết nối thất bại: " . $this->conn->connect_error);
        }

        // Thiết lập UTF-8 để lưu tiếng Việt
        $this->conn->set_charset("utf8mb4");

        // Trả về kết nối
        return $this->conn;
    }

    /**
     * Hàm đóng kết nối (nếu cần)
     */
    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>