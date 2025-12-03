<?php
require_once 'ketNoi.php';

class TaiKhoanModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    /**
     * 🟢 Tạo tài khoản mới
     * Mặc định trạng thái = 'Hoạt động'
     */
    public function createAccount($tenDangNhap, $matKhau, $trangThai = 'Hoạt động') {
        $sql = "INSERT INTO taikhoan (tenDangNhap, matKhau, trangThai)
                VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("❌ Lỗi prepare: " . $this->conn->error);
        }

        $stmt->bind_param("sss", $tenDangNhap, $matKhau, $trangThai);
        $result = $stmt->execute();

        if (!$result) {
            error_log("❌ Lỗi khi thêm tài khoản: " . $stmt->error);
        }

        $id = $this->conn->insert_id; // ✅ Lấy ID tài khoản vừa thêm
        $stmt->close();

        return $id;
    }

    /**
     * 🟡 Kiểm tra trùng tên đăng nhập
     */
    public function checkDuplicate($tenDangNhap) {
        $sql = "SELECT COUNT(*) AS total FROM taikhoan WHERE tenDangNhap = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("❌ Lỗi prepare: " . $this->conn->error);
        }

        $stmt->bind_param("s", $tenDangNhap);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result['total'] > 0;
    }
}
?>
