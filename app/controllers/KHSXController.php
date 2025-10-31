<?php
// app/controllers/KHSXController.php


class KHSXController extends Controller
{

    private $keHoachModel;
    private $donHangModel;

    public $searchKeyWord = '';



    public function __construct()
    {
        $this->keHoachModel = $this->model('KeHoachSanXuatModel');
        $this->donHangModel = $this->model('DonHangSanXuatModel');
    }

    public function create()
    {
        $danhSachBanDau = $this->donHangModel->getRecentDonHang();
    
        $data = [
            'pageTitle' => 'Lập Kế hoạch Sản xuất',
            'danhSachBanDau' => $danhSachBanDau
        ];

        $this->view('lapKHSX', $data);
    }

    public function ajaxTimKiem()
    {
        $keyword = $_GET['query'] ?? '';

        $results = $this->donHangModel->timKiemDonHang($keyword);

        header('Content-Type: application/json');
        echo json_encode($results);
        die();
    }

    public function ajaxGetChiTiet()
    {
        $id = $_GET['id'] ?? 0;

        $donHang = $this->donHangModel->getChiTietDonHang($id);

        // Trả về dữ liệu dạng JSON
        header('Content-Type: application/json');
        echo json_encode($donHang);
        die(); // Dừng lại
    }
}
