

<?php
// app/controllers/KHSXController.php
require_once "Controller.php";

class KHSXController extends Controller
{
    private $conn;
    private $keHoachModel;
    private $donHangModel;
    private $xuongModel;
    private $nvlModel;
    private $ghiNhanTPModel;
    private $sanPhamModel;


    public $searchKeyWord = '';



    public function __construct() {
    
        $this->donHangModel = new DonHangSanXuatModel();
        $this->keHoachModel = new KeHoachSanXuatModel();
        $this->xuongModel = new XuongModel();
        $this->nvlModel = new NVLModel();
        $this->ghiNhanTPModel = new GhiNhanThanhPhamModel();
        $this->sanPhamModel = new SanPhamModel();
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'Lập Kế hoạch Sản xuất'
        ];
        $this->view('lapKHSX', $data);
    }

    public function ajaxTimKiem()
    {
        ob_clean();

        $keyword = $_GET['query'] ?? '';
        $results = [];

        if ($keyword === '') {
            $results = $this->donHangModel->getRecentDonHang();
        } else {
            $results = $this->donHangModel->timKiemDonHang($keyword);
        }

        header('Content-Type: application/json');
        echo json_encode($results);
        die();
    }
    public function ajaxGetChiTiet()
    {
        $id = $_GET['id'] ?? 0;

        $donHang = $this->donHangModel->getChiTietDonHang($id);

        header('Content-Type: application/json');
        echo json_encode($donHang);
        die(); // Dừng lại
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=lap-ke-hoach');
            exit;
        }

        $this->conn->begin_transaction();

        try {
            // 1. LẤY DỮ LIỆU CHUNG TỪ FORM
            $maDonHang = $_POST['maDonHang'];
            $ngayBatDau = $_POST['ngay_bat_dau'];
            $ngayKetThuc = $_POST['ngay_ket_thuc'];
            $maNguoiLap = 1; // Giả sử ID người lập = 1 (bạn sẽ thay bằng Session)

            $dataKHSX = [
                'tenKHSX' => 'KHSX cho ĐH ' . $maDonHang, // Tên tự động
                'maDHSX' => $maDonHang,
                'thoiGianBatDau' => $ngayBatDau,
                'thoiGianKetThuc' => $ngayKetThuc,
                'maND' => $maNguoiLap
            ];
            $maKHSX_moi = $this->keHoachModel->createKHSX($dataKHSX);

            if (!$maKHSX_moi) {
                throw new Exception("Lỗi: Không thể tạo Kế hoạch sản xuất chính.");
            }

            $xuongCatData = $_POST['xuong_cat'];
            $maSP_Cat = $xuongCatData['maSanPham'];
            foreach ($xuongCatData['nvl_id'] as $index => $maNVL) {
                $soLuongNVL = $xuongCatData['nvl_soLuong'][$index];

                $dataChiTiet = [
                    'maKHSX' => $maKHSX_moi,
                    'maXuong' => 1, // Giả sử Xưởng Cắt có ID = 1
                    'maSanPham' => $maSP_Cat,
                    'maNVL' => $maNVL,
                    'soLuongNVL' => $soLuongNVL
                ];
                $this->keHoachModel->createChiTietKHSX($dataChiTiet);
            }

            // 4. TẠO CHI TIẾT CHO XƯỞNG MAY (maXuong = 2)
            $xuongMayData = $_POST['xuong_may'];
            $maSP_May = $xuongMayData['maSanPham'];
            // Lặp qua mảng NVL của Xưởng May
            foreach ($xuongMayData['nvl_id'] as $index => $maNVL) {
                $soLuongNVL = $xuongMayData['nvl_soLuong'][$index];

                $dataChiTiet = [
                    'maKHSX' => $maKHSX_moi,
                    'maXuong' => 2, // Giả sử Xưởng May có ID = 2
                    'maSanPham' => $maSP_May,
                    'maNVL' => $maNVL,
                    'soLuongNVL' => $soLuongNVL
                ];
                $this->keHoachModel->createChiTietKHSX($dataChiTiet);
            }


            $this->conn->commit();

            // Chuyển hướng về trang chủ (hoặc trang danh sách KHSX)
            header('Location: index.php?page=lap-ke-hoach');
            exit; 
        } catch (Exception $e) {
            // Nếu có lỗi, hủy bỏ tất cả thay đổi
            $this->conn->rollback();
            echo "Đã xảy ra lỗi. Vui lòng thử lại: " . $e->getMessage();
        }
    }

    public function ajaxGetModalData()
    {
        ob_clean();
        $id = $_GET['id'] ?? 0;

        $donHang = $this->donHangModel->getChiTietDonHang($id);
        $danhSachXuong = $this->xuongModel->getAllXuong();
        $danhSachNVL = $this->nvlModel->getAllNVL();
        $sanLuongTB = $this->ghiNhanTPModel->getSoLuongTrungBinh();
        $danhSachSanPham = $this->sanPhamModel->getAllSanPham();

        $data = [
            'donHang' => $donHang,
            'danhSachXuong' => $danhSachXuong,
            'danhSachNVL' => $danhSachNVL,
            'sanLuongTB' => $sanLuongTB,
            'danhSachSanPham' => $danhSachSanPham
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
        die();
    }
}
