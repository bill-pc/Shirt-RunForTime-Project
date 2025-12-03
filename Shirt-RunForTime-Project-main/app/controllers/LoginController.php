<?php
require_once 'app/models/ketNoi.php';

class LoginController {
    public function index() {
        require_once 'app/views/login.php';
    }

    public function handleLogin() {
        session_start();

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            header("Location: index.php?page=login&error=1");
            exit;
        }

        $db = new KetNoi();
        $conn = $db->connect();

        $sql = "SELECT tk.*, nd.hoTen 
                FROM taikhoan tk 
                LEFT JOIN nguoidung nd ON tk.maTK = nd.maTK 
                WHERE tenDangNhap = ? and nd.trangThai=1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // So sánh mật khẩu (hỗ trợ plain và hash)
            if ($user['matKhau'] === $password || password_verify($password, $user['matKhau'])) {
                $_SESSION['user'] = [
                    'maTK' => $user['maTK'],
                    'tenDangNhap' => $user['tenDangNhap'],
                    'hoTen' => $user['hoTen'] ?? ''
                ];

                // Chuyển hướng chính xác bằng PHP header (session vẫn giữ)
                header("Location: index.php?page=home");
                exit;
            }
        }

        // Nếu sai tài khoản hoặc mật khẩu
        header("Location: index.php?page=login&error=1");
        exit;
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header("Location: index.php?page=home");
        exit;
    }
}
?>
