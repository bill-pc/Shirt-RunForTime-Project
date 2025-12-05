<?php
// app/controllers/KHSXController.php
require_once 'app/models/DonHangSanXuatModel.php';
require_once 'app/models/KeHoachSanXuatModel.php';
require_once 'app/models/XuongModel.php';
require_once 'app/models/NVLModel.php';
require_once 'app/models/GhiNhanThanhPhamModel.php';
require_once 'app/models/SanPhamModel.php';



class KHSXController
{
    private $conn;
    private $keHoachModel;
    private $donHangModel;
    private $xuongModel;
    private $nvlModel;
    private $ghiNhanTPModel;
    private $sanPhamModel;

    public function __construct()
    {
        // Kết nối CSDL
        $database = new KetNoi(); // Giả sử file ketNoi.php đã được require
        $this->conn = $database->connect();

        // Khởi tạo các model
        $this->donHangModel = new DonHangSanXuatModel();
        $this->keHoachModel = new KeHoachSanXuatModel();
        $this->xuongModel = new XuongModel();
        $this->nvlModel = new NVLModel();
        $this->ghiNhanTPModel = new GhiNhanThanhPhamModel();
        $this->sanPhamModel = new SanPhamModel();
    }

    public function create()
    {
        $danhSachKHSX = $this->keHoachModel->getDanhSachKHSX();
        $data = [
            'pageTitle' => 'Lập Kế hoạch Sản xuất',
            'danhSachKHSX' => $danhSachKHSX
        ];
        include __DIR__ . '/../views/lapKHSX.php';
    }

    public function ajaxTimKiem()
    {
        ob_clean();

        $keyword = $_GET['query'] ?? '';

        $tuNgay = $_GET['tuNgay'] ?? null;
        $denNgay = $_GET['denNgay'] ?? null;

        $trangThai = 'Chờ duyệt';

        $results = [];

        if ($keyword === '') {
            $results = $this->donHangModel->getRecentDonHang(10, $tuNgay, $denNgay, $trangThai);
        } else {
            $results = $this->donHangModel->timKiemDonHang($keyword, $tuNgay, $denNgay, $trangThai);
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
        die();
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=lap-ke-hoach');
            exit;
        }

        $maDonHang = $_POST['maDonHang'] ?? '';

        if (empty($maDonHang)) {
            echo "<script>alert('Lỗi: Không tìm thấy mã đơn hàng!'); window.history.back();</script>";
            exit;
        }

        $this->conn->begin_transaction();

        try {
            // Lấy thông tin đơn hàng để biết mã sản phẩm gốc
            $donHangInfo = $this->donHangModel->getChiTietDonHang($maDonHang);
            if (!$donHangInfo) {
                throw new Exception("Không tồn tại đơn hàng này.");
            }
            $maSanPhamGoc = $donHangInfo['maSanPham'];

            $ngayBatDau = $_POST['ngay_bat_dau'];
            $ngayKetThuc = $_POST['ngay_ket_thuc'];
            $maNguoiLap = isset($_SESSION['user']['maND']) ? $_SESSION['user']['maND'] : 1;

            // 2. TẠO KHSX CHÍNH (Đã thêm maSanPham)
            $dataKHSX = [
                'tenKHSX' => 'KHSX cho ĐH ' . $maDonHang,
                'maDonHang' => $maDonHang,
                'maSanPham' => $maSanPhamGoc, // Lưu sản phẩm chính vào kế hoạch
                'thoiGianBatDau' => $ngayBatDau,
                'thoiGianKetThuc' => $ngayKetThuc,
                'maND' => $maNguoiLap
            ];
            $maKHSX_moi = $this->keHoachModel->createKHSX($dataKHSX);

            if (!$maKHSX_moi) throw new Exception("Lỗi tạo KHSX");

            // 3. LƯU CHI TIẾT (Logic giữ nguyên)
            // Xưởng cắt
            if (isset($_POST['xuong_cat']) && isset($_POST['xuong_cat']['nvl_id'])) {
                $xuongCatData = $_POST['xuong_cat'];
                foreach ($xuongCatData['nvl_id'] as $index => $maNVL) {
                    if (!empty($maNVL)) {
                        $this->keHoachModel->createChiTietKHSX([
                            'maKHSX' => $maKHSX_moi,
                            // 'maSanPham' => ...  <-- XÓA DÒNG NÀY ĐI
                            'maXuong' => 1,
                            'maNVL' => $maNVL,
                            'soLuongNVL' => $xuongCatData['nvl_soLuong'][$index]
                        ]);
                    }
                }
            }

            // XƯỞNG MAY
            if (isset($_POST['xuong_may']) && isset($_POST['xuong_may']['nvl_id'])) {
                $xuongMayData = $_POST['xuong_may'];
                foreach ($xuongMayData['nvl_id'] as $index => $maNVL) {
                    if (!empty($maNVL)) {
                        $this->keHoachModel->createChiTietKHSX([
                            'maKHSX' => $maKHSX_moi,
                            // 'maSanPham' => ... <-- XÓA DÒNG NÀY ĐI
                            'maXuong' => 2,
                            'maNVL' => $maNVL,
                            'soLuongNVL' => $xuongMayData['nvl_soLuong'][$index]
                        ]);
                    }
                }
            }

            // 4. CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG
            $this->donHangModel->updateTrangThai($maDonHang, 'Đang thực hiện');

            $this->conn->commit();
            header('Location: index.php?page=lap-khsx&success=1');
            exit;
        } catch (Exception $e) {
            $this->conn->rollback();
            echo "<h1>Đã xảy ra lỗi!</h1>";
            echo "<p>Chi tiết: " . $e->getMessage() . "</p>";
            echo "<a href='index.php?page=lap-ke-hoach'>Quay lại</a>";
            exit;
        }
    }

    public function ajaxGetModalData()
    {
        ob_clean();
        $id = $_GET['id'] ?? 0;

        $donHang = $this->donHangModel->getChiTietDonHang($id);
        $danhSachNVL = $this->nvlModel->getAllNVL();
        $danhSachSanPham = $this->sanPhamModel->getAllSanPham();

        // Lấy năng suất trung bình riêng cho từng xưởng
        // Từ khóa truyền vào phải khớp với dữ liệu 'phongBan' trong bảng 'nguoidung'
        $sanLuongCat = $this->ghiNhanTPModel->getSoLuongTrungBinhTheoXuong('Cắt');
        $sanLuongMay = $this->ghiNhanTPModel->getSoLuongTrungBinhTheoXuong('May');

        $data = [
            'donHang' => $donHang,
            'danhSachNVL' => $danhSachNVL,
            'danhSachSanPham' => $danhSachSanPham,
            'nangSuat' => [
                'xuongCat' => $sanLuongCat,
                'xuongMay' => $sanLuongMay
            ]
        ];

        header('Content-Type: application/json');
        echo json_encode($data);
        die();
    }
}
