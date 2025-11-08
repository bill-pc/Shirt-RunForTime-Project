<?php
require_once 'app/models/TaoDonHangSanXuatModel.php';

class TaoDonHangSanXuatController {
    private $model;

    public function __construct() {
        $this->model = new TaoDonHangSanXuatModel();
    }

    /**
     * Hiển thị form tạo đơn hàng sản xuất
     */
    public function index() {
        // Lấy danh sách sản phẩm để hiển thị trong dropdown
        $danhSachSanPham = $this->model->getDanhSachSanPham();
        
        // Tải view
        require_once 'app/views/taoDonHangSanXuat.php';
    }

    /**
     * Xử lý lưu đơn hàng sản xuất
     */
    public function luu() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=tao-don-hang-san-xuat');
            exit;
        }

        // Validate dữ liệu
        $maDonHang = isset($_POST['maDonHang']) ? trim($_POST['maDonHang']) : '';
        $sanPham = isset($_POST['sanPham']) ? (int)$_POST['sanPham'] : 0;
        $soLuong = isset($_POST['soLuong']) ? (int)$_POST['soLuong'] : 0;
        $ngayGiao = isset($_POST['ngayGiao']) ? trim($_POST['ngayGiao']) : '';
        $ghiChu = isset($_POST['ghiChu']) ? trim($_POST['ghiChu']) : '';

        // Kiểm tra dữ liệu bắt buộc
        if (empty($maDonHang) || $sanPham <= 0 || $soLuong <= 0 || empty($ngayGiao)) {
            header('Location: index.php?page=tao-don-hang-san-xuat&error=1&msg=' . urlencode('Vui lòng điền đầy đủ thông tin bắt buộc'));
            exit;
        }

        // Kiểm tra ngày giao hợp lệ
        $ngayGiaoTimestamp = strtotime($ngayGiao);
        if ($ngayGiaoTimestamp === false) {
            header('Location: index.php?page=tao-don-hang-san-xuat&error=1&msg=' . urlencode('Ngày giao không hợp lệ'));
            exit;
        }

        // Chuẩn bị dữ liệu
        $data = [
            'maDonHang' => $maDonHang,
            'sanPham' => $sanPham,
            'soLuong' => $soLuong,
            'ngayGiao' => date('Y-m-d', $ngayGiaoTimestamp),
            'ghiChu' => $ghiChu
        ];

        // Lưu đơn hàng
        $result = $this->model->luuDonHang($data);

        if ($result) {
            // Thành công - chuyển hướng với thông báo
            header('Location: index.php?page=tao-don-hang-san-xuat&success=1');
            exit;
        } else {
            // Thất bại - chuyển hướng với thông báo lỗi
            header('Location: index.php?page=tao-don-hang-san-xuat&error=1&msg=' . urlencode('Không thể lưu đơn hàng. Vui lòng thử lại.'));
            exit;
        }
    }
}
?>

