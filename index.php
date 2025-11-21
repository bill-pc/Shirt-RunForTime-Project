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



    case 'lichlamviec':
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
    case 'baocaosuco':
        include './app/views/lapbaocaosuco.php';
        break;
    // ✅ Khi người dùng nhấn GỬI báo cáo, xử lý POST
    case 'luu-baocaosuco':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once './app/controllers/BaoCaoSuCoController.php';
            $controller = new BaoCaoSuCoController();
            $controller->luuBaoCao(); // Gọi hàm xử lý lưu báo cáo
        } else {
            header('Location: index.php?page=baocaosuco');
            exit;
        }
        break;
    case 'xemcongviec':
        require_once './app/controllers/CongViecController.php';
        $controller = new CongViecController();
        $controller->index();
        break;

    case 'chitietkhxs':
        require_once './app/controllers/CongViecController.php';
        $c = new CongViecController();
        $c->detail();
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

    case 'themnhanvien':
        require_once 'app/controllers/ThemNhanVienController.php';
        $controller = new ThemNhanVienController();
        $controller->index();
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
    // Kho NVL
    case 'thongke-khonvl':
        require_once 'app/controllers/ThongKeNVLController.php'; // chữ V L hoa đúng
        $c = new ThongKeNVLController();
        $c->index();
        break;

    case 'xuatcsv-thongkenvl':
        require_once 'app/controllers/ThongKeNVLController.php';
        $controller = new ThongKeNVLController();
        $controller->xuatCSV();
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
// ===== Thống kê sản phẩm (bắt cả 2 tên route) =====

    case 'thongke_sanpham':
    case 'thongke':
        require_once __DIR__ . '/app/controllers/ThongKeKhoTPController.php';
        (new ThongKeKhoTPController())->index();
        break;

    case 'export_thongke':
        require_once __DIR__ . '/app/controllers/ThongKeKhoTPController.php';
        (new ThongKeKhoTPController())->export();
        break;
    // TẠO YÊU CẦU
    case 'tao-yeu-cau-nhap-kho':
    case 'tao-yeu-cau-nhap-nguyen-vat-lieu':
        require_once './app/controllers/YeuCauNhapKhoController.php';
        (new YeuCauNhapKhoController())->index();
        break;

    case 'chi-tiet-yeu-cau-nhap-kho':
        require_once './app/controllers/YeuCauNhapKhoController.php';
        (new YeuCauNhapKhoController())->chiTiet();
        break;

    case 'luu-yeu-cau-nhap-kho':
        require_once './app/controllers/YeuCauNhapKhoController.php';
        (new YeuCauNhapKhoController())->luuPhieu();
        break;
    case 'nhap-kho-nvl':
        require_once './app/controllers/NhapKhoNVLController.php';
        $controller = new NhapKhoNVLController();
        $controller->index();
        break;
    case 'tao-yeu-cau-kiem-tra-chat-luong':
        require_once './app/controllers/YeuCauKiemTraChatLuongController.php';
        $controller = new YeuCauKiemTraChatLuongController();
        $controller->index();
        break;

    case 'tao-yeu-cau-kiem-tra-chat-luong-process':
        require_once './app/controllers/YeuCauKiemTraChatLuongController.php';
        $controller = new YeuCauKiemTraChatLuongController();
        $controller->create();
        break;

    case 'phe-duyet-ke-hoach-sx':
        require_once './app/controllers/PheDuyetKeHoachSXController.php';
        $controller = new PheDuyetKeHoachSXController();
        $controller->index();
        break;

    case 'phe-duyet-ke-hoach-sx-process':
        require_once './app/controllers/PheDuyetKeHoachSXController.php';
        $controller = new PheDuyetKeHoachSXController();
        $controller->duyetKeHoach();
        break;
    case 'capnhatnv':
        require_once './app/controllers/SuaNhanVienController.php';
        $controller = new SuaNhanVienController();
        $controller->update();
        break;
    case 'suanhanvien':
        require_once './app/controllers/SuaNhanVienController.php';
        $controller = new SuaNhanVienController();
        $controller->index(); // ✅ hiện danh sách nhân viên có nút sửa từng dòng
        break;

    case 'suathongtinnv':
        require_once './app/controllers/SuaNhanVienController.php';
        $controller = new SuaNhanVienController();
        $controller->edit(); // ✅ hiển thị form sửa 1 nhân viên (có id)
        break;
    case 'lap-khsx':
        require_once './app/models/ketNoi.php';
        require_once './app/controllers/KHSXController.php';
        $controller = new KHSXController();
        $controller->create();
        break;

    case 'ajax-tim-kiem':
        require_once './app/models/ketNoi.php';
        require_once './app/controllers/KHSXController.php';
        $controller = new KHSXController();
        $controller->ajaxTimKiem();
        break;

    case 'ajax-get-modal-data':
        require_once './app/models/ketNoi.php';
        require_once './app/controllers/KHSXController.php';
        $controller = new KHSXController();
        $controller->ajaxGetModalData();
        break;
    case 'luu-ke-hoach':
        require_once './app/controllers/KHSXController.php';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once './app/models/ketNoi.php';
            $controller = new KHSXController();
            $controller->store();
        }
    case 'ghi-nhan-tp':
        require_once './app/controllers/GhiNhanTPController.php';
        $controller = new GhiNhanThanhPhamController();
        $controller->index();
        break;

    case 'luu-ghi-nhan-tp':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once './app/controllers/GhiNhanTPController.php';
            $controller = new GhiNhanThanhPhamController();
            $controller->luu();
        } else {
            header('Location: index.php?page=ghi-nhan-tp');
            exit;
        }
        break;
    case 'bao-cao-tong-hop':
        require_once 'app/models/BaoCaoTongHopModel.php';
        require_once 'app/controllers/BaoCaoTongHopController.php';
        $controller = new BaoCaoTongHopController();
        $controller->index();
        break;
    case 'ajax-get-report-details':
        require_once 'app/models/BaoCaoTongHopModel.php';
        require_once 'app/controllers/BaoCaoTongHopController.php';
        $controller = new BaoCaoTongHopController();
        $controller->ajaxGetDetails();
        break;
    case 'lap-bao-cao': // Giữ lại route cũ (nếu có)
        // Hoặc redirect sang route mới
        header('Location: index.php?page=bao-cao-tong-hop');
        exit;

    case 'tao-don-hang-san-xuat':
        require_once 'app/controllers/TaoDonHangSanXuatController.php';
        $controller = new TaoDonHangSanXuatController();
        $controller->index();
        break;

    case 'luu-don-hang-san-xuat':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'app/controllers/TaoDonHangSanXuatController.php';
            $controller = new TaoDonHangSanXuatController();
            $controller->luu();
        } else {
            header('Location: index.php?page=tao-don-hang-san-xuat');
            exit;
        }
        break;

    default:
        echo "404 - Trang không tồn tại!";
        break;
}
