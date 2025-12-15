<?php
require_once './app/models/YeuCauKiemTraChatLuongModel.php';

class YeuCauKiemTraChatLuongController {

    // Hiển thị form
    public function index() {
        $model = new YeuCauKiemTraChatLuongModel();
        $plans = $model->getApprovedPlans(); // lấy danh sách kế hoạch
        require_once './app/views/taoYCKiemTraChatLuong.php';
    }

    // Xử lý tạo phiếu
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maKHSX = $_POST['planCode'] ?? null;
            $thoiHanHoanThanh = $_POST['thoiHanHoanThanh'] ?? null;
            $tenNguoiLap = $_SESSION['user']['hoTen'] ?? 'Admin';

            if (!$maKHSX) {
                echo "<script>alert('❌ Vui lòng chọn kế hoạch sản xuất!');history.back();</script>";
                exit;
            }

            if (!$thoiHanHoanThanh) {
                echo "<script>alert('❌ Vui lòng chọn thời hạn hoàn thành kiểm tra!');history.back();</script>";
                exit;
            }

            $model = new YeuCauKiemTraChatLuongModel();
            $product = $model->getProductByPlan($maKHSX);

            if (!$product) {
                echo "<script>alert('❌ Không tìm thấy thông tin sản phẩm!');history.back();</script>";
                exit;
            }

            // Validate: Thời hạn phải sau ngày kết thúc KHSX
            if (isset($product['thoiGianKetThuc']) && $thoiHanHoanThanh <= $product['thoiGianKetThuc']) {
                echo "<script>alert('❌ Thời hạn kiểm tra phải sau ngày kết thúc kế hoạch sản xuất ({$product['thoiGianKetThuc']})!');history.back();</script>";
                exit;
            }

            // Tạo tên phiếu
            $tenPhieu = 'Phiếu KTCL - ' . $product['tenKHSX'];
            
            // Thêm phiếu chính (có thời hạn hoàn thành)
            $maYC = $model->themPhieuYeuCau(
                $tenNguoiLap, 
                $tenPhieu, 
                $product['maSanPham'], 
                $maKHSX,
                $thoiHanHoanThanh
            );

            if ($maYC) {
                // Thêm chi tiết phiếu (1 sản phẩm duy nhất)
                $model->themChiTietPhieu(
                    $maYC,
                    $product['maSanPham'],
                    $product['tenSanPham'],
                    $product['soLuongSanXuat'],
                    $product['donVi']
                );
                
                echo "<script>
                    alert('✅ Tạo phiếu kiểm tra chất lượng thành công!');
                    window.location='index.php?page=tao-yeu-cau-kiem-tra-chat-luong';
                </script>";
            } else {
                echo "<script>alert('❌ Lỗi khi tạo phiếu!');history.back();</script>";
            }
        }
    }
}
?>
