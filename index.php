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
    case 'lap-bao-cao':
        include 'app/views/xemBaoCao.php';
        break;
    case 'lap-ke-hoach':
        // 1. TẢI TẤT CẢ CÁC MODEL MÀ KHSXController SẼ CẦN
        require_once 'app/models/DonHangSanXuatModel.php';
        require_once 'app/models/KeHoachSanXuatModel.php';
        require_once 'app/models/XuongModel.php';
        require_once 'app/models/NVLModel.php';
        require_once 'app/models/GhiNhanThanhPhamModel.php';
        require_once 'app/models/SanPhamModel.php';

        // 2. SAU ĐÓ MỚI TẢI CONTROLLER
        require_once 'app/controllers/KHSXController.php'; // (Dòng 59 cũ của bạn)

        $controller = new KHSXController(); // Bây giờ hàm __construct() sẽ chạy đúng
        $controller->create();
        break;

    case 'ajax-tim-kiem':
        require_once 'app/models/DonHangSanXuatModel.php';

        require_once 'app/models/KeHoachSanXuatModel.php';
        require_once 'app/models/XuongModel.php';
        require_once 'app/models/NVLModel.php';
        require_once 'app/models/GhiNhanThanhPhamModel.php';
        require_once 'app/models/SanPhamModel.php';
        require_once 'app/controllers/KHSXController.php';

        $controller = new KHSXController();
        $controller->ajaxTimKiem();
        break;

    case 'ajax-get-modal-data':
        require_once 'app/models/DonHangSanXuatModel.php';
        require_once 'app/models/XuongModel.php';
        require_once 'app/models/NVLModel.php';
        require_once 'app/models/GhiNhanThanhPhamModel.php';
        require_once 'app/models/SanPhamModel.php';
        require_once 'app/models/KeHoachSanXuatModel.php';
        require_once 'app/controllers/KHSXController.php';

        $controller = new KHSXController();
        $controller->ajaxGetModalData();
        break;


    case 'luu-ke-hoach':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'app/models/DonHangSanXuatModel.php';
            require_once 'app/models/KeHoachSanXuatModel.php';
            require_once 'app/models/XuongModel.php';
            require_once 'app/models/NVLModel.php';
            require_once 'app/models/GhiNhanThanhPhamModel.php';
            require_once 'app/models/SanPhamModel.php';
            require_once 'app/controllers/KHSXController.php';

            $controller = new KHSXController();
            $controller->store();
        }
        break;
    default:
        echo "404 - Trang không tồn tại!";
        break;
}
