<?php
require_once 'app/models/XemCaLamViecModel.php';

class XemLichLamViecController {
    private $model;

    public function __construct() {
        $this->model = new XemCaLamViecModel();
    }

    /**
     * Hiển thị trang xem lịch làm việc
     */
    public function index() {
        // Lấy mã nhân viên từ session (nếu có)
        $maNhanVien = null;
        if (isset($_SESSION['user']) && isset($_SESSION['user']['maNhanVien'])) {
            $maNhanVien = $_SESSION['user']['maNhanVien'];
        }

        // Lấy dữ liệu lịch làm việc
        $lichLamViec = $this->model->getLichLamViec($maNhanVien);
        $tomTat = $this->model->getTomTatLichLamViec($maNhanVien);
        $tuanHienTai = $this->model->getTuanHienTai();

        require_once 'app/views/XemCaLamViec.php';
    }
}
?>

