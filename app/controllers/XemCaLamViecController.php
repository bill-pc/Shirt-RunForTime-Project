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
        // Đảm bảo session đã start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Lấy mã người dùng từ session
        $maND = null;
        if (isset($_SESSION['user']) && isset($_SESSION['user']['maTK'])) {
            $maTK = $_SESSION['user']['maTK'];
            // Lấy maND từ maTK thông qua bảng nguoidung
            $maND = $this->model->getMaNDFromMaTKPublic($maTK);
        }

        // Lấy dữ liệu lịch làm việc
        $lichLamViec = $this->model->getLichLamViec($maND);
        $tomTat = $this->model->getTomTatLichLamViec($maND);
        $tuanHienTai = $this->model->getTuanHienTai();

        require_once 'app/views/xemCaLamViec.php';
    }
}
?>

