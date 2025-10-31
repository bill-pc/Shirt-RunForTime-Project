<?php
require_once 'app/models/PhieuXuatKhoModel.php';

class XuatKhoNVLController {

    private $model;

    public function __construct() {
        $this->model = new PhieuXuatNVLModel();
    }

    // ✅ Danh sách phiếu yêu cầu NVL đã duyệt
    public function danhSachPhieu() {
        $danhSachPhieu = $this->model->getAllPhieuXuat();
        require_once 'app/views/xuatKhoNVL.php';
    }

    // ✅ Xem và tạo phiếu xuất vật liệu từ YCCC
    public function chiTietPhieu() {
        if (!isset($_GET['maYCCC'])) {
            header("Location: index.php?page=xuat-kho-nvl");
            exit();
        }

        $maYCCC = intval($_GET['maYCCC']);

        // ✅ Lấy thông tin phiếu yêu cầu chính
        $thongTinPhieu = [
            'maYCCC' => $maYCCC,
            'tenPhieu' => $_GET['tenPhieu'] ?? 'Phiếu xuất NVL',
            'tenNguoiLap' => $_SESSION['tenNguoiDung'] ?? 'Chưa xác định'
        ];

        // ✅ Lấy danh sách NVL trong phiếu yêu cầu
        $dsNVL = $this->model->getChiTietNVLTheoYCCC($maYCCC);
        $dsXuong = $this->model->getDanhSachXuong();

        require_once 'app/views/xuatKhoNVL_ChiTiet.php';
    }

    // ✅ Lưu phiếu xuất NVL
    public function luuPhieu() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=xuat-kho-nvl");
            exit();
        }

        if ($this->model->createPhieuXuatNVL($_POST)) {
            header("Location: index.php?page=xuat-kho-nvl&success=1");
        } else {
            header("Location: index.php?page=xuat-kho-nvl&error=1");
        }
        exit();
    }
    
}
