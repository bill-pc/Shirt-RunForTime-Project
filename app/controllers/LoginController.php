<?php
require_once 'app/models/ketNoi.php';

class LoginController {
    public function index() {
        require_once 'app/views/login.php';
    }

    public function handleLogin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        header("Location: index.php?page=login&error=1");
        exit;
    }

    $db = new KetNoi();
    $conn = $db->connect();

    // ✅ Lấy thêm cột nd.trangThai (1: hoạt động, 0: dừng)
    $sql = "SELECT tk.*, nd.hoTen, nd.trangThai 
            FROM taikhoan tk 
            LEFT JOIN nguoidung nd ON tk.maTK = nd.maTK 
            WHERE tk.tenDangNhap = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('Lỗi truy vấn SQL: ' . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // ✅ Nếu người dùng bị dừng (trangThai = 0)
        if (isset($user['trangThai']) && $user['trangThai'] == 0) {
            header("Location: index.php?page=login&error=locked");
            exit;
        }

        // ✅ Nếu tài khoản đang hoạt động, kiểm tra mật khẩu
        if ($user['matKhau'] === $password || password_verify($password, $user['matKhau'])) {
            $_SESSION['user'] = [
                'maTK' => $user['maTK'],
                'tenDangNhap' => $user['tenDangNhap'],
                'hoTen' => $user['hoTen'] ?? ''
            ];

            header("Location: index.php?page=home");
            exit;
        }
    }

    // ❌ Sai tài khoản hoặc mật khẩu
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
