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
// Nhân viên
        // ✅ Trang hiển thị form lập báo cáo sự cố
        case 'baocaosuco':
            include './app/views/lapbaocaosuco.php';
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
//quản lý sản xuất
        case 'xemcongviec':
            require_once './app/controllers/CongViecController.php';
            $controller = new CongViecController();
            $controller->index();
            break;

        case 'xoa-congviec':
            require_once './app/controllers/CongViecController.php';
            $controller = new CongViecController($db);
            $controller->delete();
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
/// quản lý nhân sự:
        case 'timkiem-nhanvien':
            require_once 'app/controllers/XoaNhanVienController.php';
            $controller = new XoaNhanVienController();
            $controller->searchAjax();
            break;

        case 'xoanhanvien':
            require_once 'app/controllers/XoaNhanVienController.php';
            $nvController = new XoaNhanVienController();
            // Nếu AJAX/POST xóa (JS gửi POST tới index.php?page=xoanhanvien&id=...)
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
                $nvController->deleteAjax(); // trả JSON
            } else {
                // hiển thị danh sách / trang quản lý
                $nvController->index();
            }
            break;

        // (nếu bạn vẫn muốn route xác nhận bằng GET)
        case 'xacnhan-xoa-nhanvien':
            require_once '.app/controllers/XoaNhanVienController.php';
            $nvController = new XoaNhanVienController();
            $nvController->xacNhanXoa(); // nếu bạn dùng trang xác nhận riêng
            break;
        case 'xemnhanvien':
            require_once 'app/controllers/XemNhanVienController.php';
            $controller = new XemNhanVienController();

            if (isset($_GET['id'])) {
                $controller->show($_GET['id']); // ✅ Xem chi tiết 1 nhân viên
            } else {
                $controller->index(); // ✅ Xem danh sách nhân viên
            }
            break;



        

    default:
        echo "<h2 style='text-align:center; margin-top:50px;'>404 - Trang không tồn tại!</h2>";
        break;
}
?>
