<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'app/core/Controller.php';
require_once 'app/controllers/HomeController.php';
require_once 'app/models/KetNoi.php';

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
    case 'tao-yeu-cau-nvl':
        require_once './app/controllers/YeuCauNVLController.php';
        $controller = new YeuCauNVLController();
        $controller->index();
        break;
    case 'chi-tiet-yeu-cau':
        require_once './app/controllers/YeuCauNVLController.php';
        $controller = new YeuCauNVLController();
        $controller->chiTiet(); // Gọi hàm chiTiet() mới
        break;
    case 'luu-yeu-cau-nvl':
        // Chỉ chấp nhận phương thức POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Đường dẫn đúng từ thư mục gốc
            require_once 'app/controllers/YeuCauNVLController.php';
            $controller = new YeuCauNVLController();
            $controller->luuPhieu(); // Gọi hàm xử lý lưu
        } else {
            // Nếu truy cập bằng GET, chuyển về trang danh sách
            header('Location: index.php?page=tao-yeu-cau-nvl');
            exit; // Dừng thực thi script sau khi chuyển hướng
        }
        break;
    case 'lap-ke-hoach':
        require_once 'app/models/DonHangSanXuatModel.php';
        require_once 'app/controllers/KHSXController.php';
        $controller = new KHSXController();
        $controller->create();
        break;

    case 'ajax-tim-kiem':
        require_once 'app/models/DonHangSanXuatModel.php';
        require_once 'app/controllers/KHSXController.php';
        $controller = new KHSXController();
        $controller->ajaxTimKiem();
        break;
        
    case 'ajax-get-chitiet':
        require_once 'app/models/DonHangSanXuatModel.php';
        require_once 'app/controllers/KHSXController.php';
        $controller = new KHSXController();
        $controller->ajaxGetChiTiet();
        break;
    default:
        echo "404 - Trang không tồn tại!";
        break;
}
