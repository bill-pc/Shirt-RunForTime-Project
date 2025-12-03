<?php
require_once './app/models/YeuCauKiemTraChatLuongModel.php';

class YeuCauKiemTraChatLuongController {

    // ====== HIỂN THỊ TRANG TẠO YÊU CẦU ======
    public function index() {
        $viewPath = __DIR__ . '/../views/taoYCKiemTraChatLuong.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "<h3 style='color:red;'>⚠️ Không tìm thấy file view: $viewPath</h3>";
        }
    }

    // ====== XỬ LÝ SUBMIT YÊU CẦU (nếu bạn thêm form action POST) ======
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $model = new YeuCauKiemTraChatLuongModel();
            $data = [
                'maKeHoach'   => $_POST['planCode'] ?? null,
                'maSanPham'   => $_POST['productCode'] ?? null,
                'soLuong'     => $_POST['quantity'] ?? 0,
                'xuong'       => $_POST['workshop'] ?? '',
                'thoiGian'    => $_POST['requestTime'] ?? '',
                'ghiChu'      => $_POST['notes'] ?? '',
            ];

            $success = $model->themYeuCauKiemTra($data);

            if ($success) {
                echo "<script>alert('✅ Tạo yêu cầu kiểm tra thành công!'); window.location='index.php?page=tao-yeu-cau-kiem-tra-chat-luong';</script>";
            } else {
                echo "<script>alert('❌ Lỗi khi lưu yêu cầu.'); window.history.back();</script>";
            }
        }
    }
}
