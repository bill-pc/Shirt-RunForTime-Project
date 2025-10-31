<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy tham số ?page= từ URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// ---------------------------
// Login / Logout
// ---------------------------
if ($page === 'login' || $page === 'login-process' || $page === 'logout') {
    require_once 'app/controllers/LoginController.php';
    $controller = new LoginController();

    switch ($page) {
        case 'login':
            $controller->index();
            break;

        case 'login-process':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->handleLogin();
            } else {
                header("Location: index.php?page=login");
                exit;
            }
            break;

        case 'logout':
            $controller->logout();
            break;
    }
    exit;
}

// ---------------------------
// Kiểm tra session trước các trang khác
// ---------------------------
if (!isset($_SESSION['user']) && $page !== 'home') {
    header("Location: index.php?page=login");
    exit;
}

// ---------------------------
// Các trang khác
// ---------------------------

switch ($page) {
    case 'home':
        require_once 'app/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

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
///Kho NVL
        case 'thongke-khonvl':
            require_once 'app/controllers/ThongKeNVlController.php';
            $c = new ThongKeController();
            $c->index();
            break;

        case 'thongke_export':
            require_once 'app/controllers/ThongKeNVLController.php';
            $c = new ThongKeController();
            $c->exportCsv();
            break;

//kho thành phẩm
        case 'xuatthanhpham':
            require_once 'app/controllers/XuatThanhPhamController.php';
            $controller = new XuatThanhPhamController();
            $controller->index();
            break;

        case 'xuatthanhpham_xuat':
            require_once 'app/controllers/XuatThanhPhamController.php';
            $controller = new XuatThanhPhamController();
            $controller->xuat();
            break;

case 'tao-yeu-cau-nvl':
        require_once './app/controllers/YeuCauNVLController.php';
        $controller = new YeuCauNVLController();
        $controller->index();
        break;

    case 'chi-tiet-yeu-cau':
        require_once './app/controllers/YeuCauNVLController.php';
        $controller = new YeuCauNVLController();
        $controller->chiTiet();
        break;

    case 'luu-yeu-cau-nvl':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'app/controllers/YeuCauNVLController.php';
            $controller = new YeuCauNVLController();
            $controller->luuPhieu();
        } else {
            header('Location: index.php?page=tao-yeu-cau-nvl');
            exit;
        }
        break;
    case 'thong-tin-ca-nhan':
        require_once 'app/controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->index();
        break;
    case 'phe-duyet-cac-yeu-cau':
        require_once 'app/controllers/PheDuyetController.php';
        $controller = new PheDuyetController();
        $controller->index();
        break;
    case 'chi-tiet-phe-duyet-yeu-cau':
        require_once 'app/controllers/PheDuyetController.php';
        $controller = new PheDuyetController();
        $controller->chiTiet();
        break;
    case 'duyet-phieu':
        require_once 'app/controllers/PheDuyetController.php';
        $controller = new PheDuyetController();
        $controller->duyet();
        break;

    case 'tuchoi-phieu':
        require_once 'app/controllers/PheDuyetController.php';
        $controller = new PheDuyetController();
        $controller->tuChoi();
        break;
    case 'xuat-kho-nvl':
        require_once 'app/controllers/XuatKhoNVLController.php';
        (new XuatKhoNVLController())->danhSachPhieu();
        break;

    case 'chi-tiet-xuat-kho':
        require_once 'app/controllers/XuatKhoNVLController.php';
        (new XuatKhoNVLController())->chiTietPhieu();
        break;

    case 'luu-phieu-xuat-kho':
        require_once 'app/controllers/XuatKhoNVLController.php';
        (new XuatKhoNVLController())->luuPhieu();
        break;
        

    default:
        echo "<h2 style='text-align:center; margin-top:50px;'>404 - Trang không tồn tại!</h2>";
        break;
}
?>
