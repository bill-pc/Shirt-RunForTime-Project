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
        require_once './app/controllers/XemCaLamViecController.php';
        $controller = new XemLichLamViecController();
        $controller->index();
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

    case 'gioithieu':
        require_once 'app/views/gioithieu.php';
        break;

    //kho thành phẩm
    case 'nhap-kho-thanh-pham':
        require_once 'app/controllers/NhapKhoTP_DaCheckQCController.php';
        $controller = new NhapKhoTP_DaCheckQCController();
        $controller->index();
        break;
    case 'luu-nhap-kho-tp-da-check-qc':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'app/controllers/NhapKhoTP_DaCheckQCController.php';
            $controller = new NhapKhoTP_DaCheckQCController();
            $controller->luuNhapKho();
        } else {
            header('Location: index.php?page=nhap-kho-thanh-pham');
            exit;
        }
        break;
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
    case 'xuatthanhpham_chitiet':
        require 'app/controllers/XuatThanhPhamController.php';
        $c = new XuatThanhPhamController();
        $c->chitiet();
        break;

    // ===== Thống kê sản phẩm  =====

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
    case 'lap-ke-hoach-chi-tiet':
        require_once './app/controllers/KHSXController.php';
        $controller = new KHSXController();
        $controller->lapChiTiet();
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
            exit; // 🔥 BẮT BUỘC
        }
        header('Location: index.php?page=ghi-nhan-tp');
        exit;

    case 'ajax-get-sp-theo-khsx':
        require_once './app/controllers/GhiNhanTPController.php';
        $controller = new GhiNhanThanhPhamController();
        $controller->ajaxGetSanPham();
        exit;

    case 'ajax-get-nv-theo-xuong':
        require_once 'app/models/ketNoi.php';
        require_once 'app/models/XuongModel.php';
        require_once 'app/models/NhanVienModel.php';

        require_once 'app/controllers/GhiNhanTPController.php';

        $controller = new GhiNhanThanhPhamController();
        $controller->ajaxGetNhanVienByXuong();
        break;
    case 'ajax-get-chitiet-phieu':
        require_once 'app/models/ketNoi.php';
        require_once 'app/models/GhiNhanThanhPhamModel.php';
        require_once 'app/controllers/GhiNhanTPController.php';
        $controller = new GhiNhanThanhPhamController();
        $controller->ajaxGetChiTietPhieu();
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
    // Cập nhật thành phẩm
    case 'cap-nhat-thanh-pham':
        require_once 'app/controllers/QCController.php';
        $controller = new QCController();
        $controller->index();
        break;

    case 'qc-update':
        require_once 'app/controllers/QCController.php';
        $controller = new QCController();
        $controller->update();
        break;
    // case 'bao-cao-chat-luong':
    case 'baocao-chatluong':
        require_once 'app/controllers/BaoCaoChatLuongController.php';
        $controller = new BaoCaoChatLuongController();
        $controller->index();
        break;

    case 'baocao-get':
        require_once 'app/controllers/BaoCaoChatLuongController.php';
        $controller = new BaoCaoChatLuongController();
        $controller->getDetail();
        break;

    case 'baocao-export':
        require_once 'app/controllers/BaoCaoChatLuongController.php';
        $controller = new BaoCaoChatLuongController();
        $controller->export();
        break;



    //     break;
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
        $controller = new NhapKhoNVLController();
        $controller->ajaxGetDetails();
        break;

    case 'luu-phieu-nhap-nvl':
        require_once './app/controllers/NhapKhoNVLController.php';
        $controller = new NhapKhoNVLController();
        $controller->luuPhieu();
        break;

    case 'tao-yeu-cau-kiem-tra-chat-luong':
        require_once './app/controllers/YeuCauKiemTraChatLuongController.php';
        $controller = new YeuCauKiemTraChatLuongController();
        $controller->index();
        break;

    case 'tao-yeu-cau-kiem-tra-chat-luong-create':
    case 'tao-yeu-cau-kiem-tra-chat-luong-process':
        require_once './app/controllers/YeuCauKiemTraChatLuongController.php';
        $controller = new YeuCauKiemTraChatLuongController();
        $controller->create();
        break;


    case 'ajax-get-plan-detail':
        require_once './app/controllers/PheDuyetKeHoachSXController.php';
        $controller = new PheDuyetKeHoachSXController();
        $controller->ajaxGetPlanDetail();
        break;

    case 'ajax-get-approval-history':
        require_once './app/controllers/PheDuyetKeHoachSXController.php';
        $controller = new PheDuyetKeHoachSXController();
        $controller->ajaxGetApprovalHistory();
        break;

    case 'duyet-yc-nhap-kho':
        require_once './app/controllers/PheDuyetYeuCauNhapKhoController.php';
        $controller = new PheDuyetYeuCauNhapKhoController();
        $controller->approve();
        break;

    case 'tu-choi-yc-nhap-kho':
        require_once './app/controllers/PheDuyetYeuCauNhapKhoController.php';
        $controller = new PheDuyetYeuCauNhapKhoController();
        $controller->reject();
        break;

    case 'chi-tiet-yc-nhap-kho':
        require_once './app/controllers/PheDuyetYeuCauNhapKhoController.php';
        $controller = new PheDuyetYeuCauNhapKhoController();
        $controller->getDetails();
        break;

    default:
        // --- Xử lý trang giới thiệu: gioi-thieu-xxx ---
        if (strpos($page, 'gioi-thieu-') === 0) {
            $danhMucKey = substr($page, strlen('gioi-thieu-'));
            $allowedCategories = [
                'tong-quan',
                'nhan-su',
                'san-xuat',
                'kho-nvl',
                'xuong',
                'kiem-tra-chat-luong',
                'kho-thanh-pham',
                'cong-nhan'
            ];

            if (in_array($danhMucKey, $allowedCategories)) {
                $viewFileName = str_replace('-', '', $danhMucKey);
                $viewPath = "app/views/gioithieu/{$viewFileName}.php";
                if (file_exists($viewPath)) {
                    include $viewPath;
                } else {
                    http_response_code(404);
                    echo "<h2>❌ Nội dung giới thiệu chưa được tạo.</h2>";
                }
            } else {
                http_response_code(404);
                echo "<h2>⚠️ Danh mục giới thiệu không hợp lệ.</h2>";
            }
        }
        // --- Hoặc thử load view đơn giản ---
        else {
            $filePath = "app/views/{$page}.php";
            if (file_exists($filePath)) {
                include $filePath;
            } else {
                http_response_code(404);
                echo "<h2>⚠️ Trang không tồn tại: " . htmlspecialchars($page) . "</h2>";
            }
        }
        break;
}
