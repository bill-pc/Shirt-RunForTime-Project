<?php
require_once 'app/models/DanhMucModel.php';
require_once 'app/models/HomeModel.php';

class HomeController {
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Nếu chưa đăng nhập → chỉ hiển thị trang chào mừng đơn giản
        if (!isset($_SESSION['user'])) {
            $isLoggedIn = false;
            require_once 'app/views/home.php'; // 👈 trang chưa đăng nhập
            return;
        }

        // Nếu đã đăng nhập → hiển thị trang có danh mục
        $isLoggedIn = true;
        $danhMucModel = new DanhMucModel();
        $danhMucData = $danhMucModel->getDanhMuc();

        $homeModel = new HomeModel();
        $thongKe = $homeModel->layThongKeTongQuan();
         $duLieuBieuDo = $homeModel->layNangSuatTheoNgay(7);

        require_once 'app/views/home.php';
    }
}
