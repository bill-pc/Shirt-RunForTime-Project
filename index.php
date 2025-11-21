<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Import AuthMiddleware để kiểm tra quyền
require_once 'app/middleware/AuthMiddleware.php';

// Lấy tham số ?page= từ URL
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$allowed_ajax = [
    'ajax-get-plan-detail',
    'ajax-get-approval-history',
    'phe-duyet-ke-hoach-sx-process',
    'ajax-tim-kiem',
    'ajax-get-modal-data',
    'ajax-get-report-details',
    'ajax-get-details-nhapkho',
    'luu-phieu-nhap-nvl'
];

// Tắt display_errors cho AJAX requests để không làm hỏng JSON
if (in_array($page, $allowed_ajax)) {
    ini_set('display_errors', 0);
}

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
// Kiểm tra đăng nhập và phân quyền
// ---------------------------
if (!isset($_SESSION['user']) && $page !== 'home') {
    header("Location: index.php?page=login");
    exit;
}

// Kiểm tra quyền truy cập (trừ trang home và login)
if ($page !== 'home' && $page !== 'login') {
    if (!AuthMiddleware::checkPermission($page)) {
        // Người dùng không có quyền truy cập
        echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Không có quyền</title>
            <style>
                body { font-family: Arial; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background: #f5f5f5; }
                .error-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-align: center; }
                .error-box h1 { color: #dc3545; margin-bottom: 20px; }
                .error-box p { color: #666; margin-bottom: 30px; }
                .error-box a { background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
            </style>
        </head>
        <body>
            <div class='error-box'>
                <h1>⛔ Không có quyền truy cập</h1>
                <p>Vai trò <strong>" . htmlspecialchars($_SESSION['user']['vaiTro'] ?? 'Không xác định') . "</strong> không được phép truy cập trang này.</p>
                <a href='index.php?page=home'>← Về trang chủ</a>
            </div>
        </body>
        </html>";
        exit;
    }
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
    case 'calamviec':
    case 'xem-lich-lam-viec':
        require_once 'app/controllers/XemCaLamViecController.php';
        $controller = new XemLichLamViecController();
        $controller->index();
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

    case 'ajax-get-details-nhapkho':
        require_once './app/controllers/NhapKhoNVLController.php';
        (new NhapKhoNVLController())->ajaxGetDetails();
        break;

    case 'luu-phieu-nhap-nvl':
        require_once './app/controllers/NhapKhoNVLController.php';
        (new NhapKhoNVLController())->luuPhieu();
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
        (new PheDuyetKeHoachSXController())->index();
        break;

    case 'phe-duyet-ke-hoach-sx-process':
        require_once './app/controllers/PheDuyetKeHoachSXController.php';
        (new PheDuyetKeHoachSXController())->duyetKeHoach();
        break;
    case 'ajax-get-plan-detail':
        require_once './app/controllers/PheDuyetKeHoachSXController.php';
        (new PheDuyetKeHoachSXController())->ajaxGetPlanDetail();
        break;

    case 'ajax-get-approval-history':
        require_once './app/controllers/PheDuyetKeHoachSXController.php';
        (new PheDuyetKeHoachSXController())->ajaxGetApprovalHistory();
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
    case 'lap-bao-cao': 
        header('Location: index.php?page=bao-cao-tong-hop');
        exit;

    case 'bao-cao-chat-luong': 
        require_once 'app/controllers/QCController.php';
        (new QCController())->index();
        break;

    case 'qc-update': 
        require_once 'app/controllers/QCController.php';
        (new QCController())->update();
        break;
    default:
        echo "404 - Trang không tồn tại!";
        break;
}
