<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Nạp controller chính
require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/BaoCaoSuCoController.php';

// Lấy tham số ?page= từ URL (nếu không có, mặc định là 'home')
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    case 'home':
        $controller = new HomeController();
        $controller->index();
        break;

    // ✅ Trang hiển thị form lập báo cáo sự cố
    case 'baocaosuco':
        include './app/views/lapbaocaosuco.php';
        break;

    // ✅ Trang hiển thị lịch làm việc
    case 'lichlamviec':
        include './app/views/lichlamviec.php';
        break;
    case 'search':
        require_once './app/controllers/SearchController.php';
        $controller = new SearchController();
        $controller->search();
        break;

    // ✅ Khi người dùng nhấn GỬI báo cáo, xử lý POST
    case 'luu-baocaosuco':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller = new BaoCaoSuCoController();
            $controller->luuBaoCao(); // Gọi hàm xử lý lưu báo cáo
        } else {
            header('Location: index.php?page=baocaosuco');
            exit;
        }
        break;

    
    default:
        echo "<h2 style='text-align:center; margin-top:50px;'>404 - Trang không tồn tại!</h2>";
        break;
}
?>
