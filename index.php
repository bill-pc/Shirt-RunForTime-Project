<?php
require_once 'app/controllers/HomeController.php';

// Lấy tham số ?page= từ URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    case 'baocaosuco':  // ✅ Sửa lại key này
        include './app/views/lapbaocaosuco.php';
        break;

    case 'lichlamviec': // ✅ nên viết không dấu, không khoảng trắng
        include './app/views/lichlamviec.php';
        break;

    default:
        echo "404 - Trang không tồn tại!";
        break;
}
?>
