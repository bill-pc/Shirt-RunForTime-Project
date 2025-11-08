<?php
require_once 'app/models/NhapKhoTP_DaCheckQCModel.php';

class NhapKhoTP_DaCheckQCController {
    private $model;

    public function __construct() {
        $this->model = new NhapKhoTP_DaCheckQCModel();
    }

    /**
     * Hiển thị trang nhập kho thành phẩm từ phiếu QC đã đạt
     */
    public function index() {
        // Lấy danh sách phiếu QC đã đạt
        $danhSachPhieuQC = $this->model->getDanhSachPhieuQCDaDat();
        
        // Nếu có chọn phiếu từ URL
        $chiTietPhieu = null;
        if (isset($_GET['maPhieu']) && !empty($_GET['maPhieu'])) {
            $maPhieu = (int)$_GET['maPhieu'];
            $chiTietPhieu = $this->model->getChiTietPhieuQC($maPhieu);
        }
        
        require_once 'app/views/nhapKhoTP_DaCheckQC.php';
    }

    /**
     * Xử lý nhập kho thành phẩm
     */
    public function luuNhapKho() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=nhap-kho-tp-da-check-qc');
            exit;
        }

        // Validate dữ liệu
        $maPhieu = isset($_POST['maPhieu']) ? (int)$_POST['maPhieu'] : 0;
        $maSanPham = isset($_POST['maSanPham']) ? (int)$_POST['maSanPham'] : 0;
        $soLuong = isset($_POST['soLuong']) ? (int)$_POST['soLuong'] : 0;

        // Kiểm tra dữ liệu bắt buộc
        if ($maPhieu <= 0 || $maSanPham <= 0 || $soLuong <= 0) {
            header('Location: index.php?page=nhap-kho-tp-da-check-qc&error=1&msg=' . urlencode('Dữ liệu không hợp lệ'));
            exit;
        }

        // Kiểm tra phiếu đã nhập kho chưa
        if ($this->model->kiemTraPhieuDaNhapKho($maPhieu)) {
            header('Location: index.php?page=nhap-kho-tp-da-check-qc&error=1&msg=' . urlencode('Phiếu này đã được nhập kho'));
            exit;
        }

        // Lấy chi tiết phiếu để kiểm tra số lượng
        $chiTietPhieu = $this->model->getChiTietPhieuQC($maPhieu);
        
        if (!$chiTietPhieu) {
            header('Location: index.php?page=nhap-kho-tp-da-check-qc&error=1&msg=' . urlencode('Không tìm thấy phiếu'));
            exit;
        }

        // Kiểm tra số lượng không vượt quá số lượng trong phiếu
        if ($soLuong > $chiTietPhieu['soLuong']) {
            header('Location: index.php?page=nhap-kho-tp-da-check-qc&maPhieu=' . $maPhieu . '&error=1&msg=' . urlencode('Số lượng không được vượt quá số lượng trong phiếu'));
            exit;
        }

        // Thực hiện nhập kho
        $result = $this->model->nhapKhoThanhPham($maPhieu, $maSanPham, $soLuong);

        if ($result) {
            // Thành công
            header('Location: index.php?page=nhap-kho-tp-da-check-qc&success=1');
            exit;
        } else {
            // Thất bại
            header('Location: index.php?page=nhap-kho-tp-da-check-qc&maPhieu=' . $maPhieu . '&error=1&msg=' . urlencode('Không thể nhập kho. Vui lòng thử lại.'));
            exit;
        }
    }
}
?>

