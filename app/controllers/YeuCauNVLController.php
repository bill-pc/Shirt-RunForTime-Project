<?php
require_once './app/models/KeHoachSanXuatModel.php';
require_once  './app/models/PhieuYeuCauCCNVLModel.php';

class YeuCauNVLController {

    public function index() {
        // 1. Gọi Model
        $khsxModel = new KeHoachSanXuatModel();
        $danhSachKHSX = $khsxModel->getAllPlans();

        // 2. Tải View và truyền dữ liệu $danhSachKHSX ra
        require_once './app/views/taoYCCungCapNVL.php';
    }

    
    
    public function chiTiet() {
        // Lấy mã KHSX từ URL
        if (!isset($_GET['maKHSX'])) {
            echo "Lỗi: Không có mã kế hoạch sản xuất.";
            return;
        }
        $maKHSX = $_GET['maKHSX'];

        // 1. Gọi Model
        $khsxModel = new KeHoachSanXuatModel();
        
        // Lấy thông tin phiếu (để điền tên, người lập)
        $thongTinPhieu = $khsxModel->getPlanById($maKHSX);
        
        // Lấy danh sách NVL (để điền vào bảng)
        $danhSachNVL = $khsxModel->getMaterialsForPlan($maKHSX);

        // 2. Tải View và truyền 2 khối dữ liệu
        require_once './app/views/taoYCCungCapNVL_ChiTiet.php';
    }
    public function luuPhieu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $phieuModel = new PhieuYeuCauModel();
            $success = $phieuModel->createPhieuYeuCau($_POST);

            if ($success) {
                // Giữ nguyên chuyển hướng khi thành công
                header('Location: index.php?page=tao-yeu-cau-nvl&success=1');
                exit;
            } else {
                // === VÔ HIỆU HÓA TẠM THỜI DÒNG NÀY ===
                // $maKHSX = isset($_POST['maKHSX']) ? $_POST['maKHSX'] : '';
                // header('Location: index.php?page=chi-tiet-yeu-cau&maKHSX=' . $maKHSX . '&error=1');
                // exit;

                // === THAY BẰNG DÒNG NÀY ĐỂ XEM LỖI ===
                echo "<h1>Lỗi xảy ra khi lưu phiếu!</h1>";
                echo "<p>Kiểm tra PHP Error Log để biết chi tiết.</p>";
                // Bạn có thể thử in ra $_POST để kiểm tra dữ liệu gửi lên
                echo "<pre>Dữ liệu gửi lên:\n";
                print_r($_POST);
                echo "</pre>";
                // Dừng thực thi để xem lỗi (nếu có)
                // Nếu bạn đã bật display_errors ở index.php, lỗi chi tiết có thể hiện ở đây
                die(); // Tạm thời dừng ở đây
            }
        } else {
            header('Location: index.php?page=tao-yeu-cau-nvl');
            exit;
        }
    }
}
?>