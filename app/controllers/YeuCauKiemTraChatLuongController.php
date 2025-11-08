<?php
require_once './app/models/YeuCauKiemTraChatLuongModel.php';

class YeuCauKiemTraChatLuongController {

    // Hiển thị form
    public function index() {
        $model = new YeuCauKiemTraChatLuongModel();
        $plans = $model->getApprovedPlans(); // lấy danh sách kế hoạch
        require_once './app/views/taoYCKiemTraChatLuong.php';
    }

    // Xử lý tạo phiếu tự động
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maKHSX = $_POST['planCode'];
            $tenNguoiLap = $_POST['tenNguoiLap'] ?? 'Hệ thống';

            $model = new YeuCauKiemTraChatLuongModel();
            $materials = $model->getMaterialsByPlan($maKHSX);

            if (empty($materials)) {
                echo "<script>alert('❌ Kế hoạch này chưa có nguyên vật liệu!');history.back();</script>";
                exit;
            }

            // tạm thời gán sản phẩm đầu tiên để lưu phiếu chính
            $tenSanPham = $materials[0]['tenNVL'];
            $maSanPham = 1; // nếu muốn lấy tự động từ bảng khác thì có thể truy vấn thêm
            $tongSoLuong = array_sum(array_column($materials, 'soLuong'));

            $maYC = $model->themPhieuYeuCau($tenNguoiLap, $tenSanPham, $maSanPham, $tongSoLuong, $maKHSX);


            if ($maYC) {
                foreach ($materials as $item) {
                    $model->themChiTietPhieu($maYC, $item['tenNVL'], $maSanPham, $item['soLuong']);
                }
                echo "<script>alert('✅ Tạo phiếu kiểm tra chất lượng thành công!');window.location='index.php?page=tao-yeu-cau-kiem-tra-chat-luong';</script>";
            } else {
                echo "<script>alert('❌ Lỗi khi tạo phiếu!');history.back();</script>";
            }
        }
    }
}
?>
