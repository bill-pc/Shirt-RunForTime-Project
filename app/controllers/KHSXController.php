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
        // Lấy giá trị bộ lọc
        $ngayGiao = $_GET['ngayGiao'] ?? null;
        $trangThai = $_GET['trangThai'] ?? null;

        $results = [];

        if ($keyword === '') {
            // Sửa lại: Truyền bộ lọc vào hàm
            $results = $this->donHangModel->getRecentDonHang(10, $ngayGiao, $trangThai);
        } else {
            // Sửa lại: Truyền bộ lọc vào hàm
            $results = $this->donHangModel->timKiemDonHang($keyword, $ngayGiao, $trangThai);
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

        // Bắt đầu transaction
        $this->conn->begin_transaction();

        try {
            // 1. LẤY DỮ LIỆU CHUNG
            $maDonHang = $_POST['maDonHang'];
            $ngayBatDau = $_POST['ngay_bat_dau'];
            $ngayKetThuc = $_POST['ngay_ket_thuc'];
            $maNguoiLap = 1; // Giả sử ID người lập = 1

            // 2. TẠO KHSX CHÍNH (BẢNG CHA)
            $dataKHSX = [
                'tenKHSX' => 'KHSX cho ĐH ' . $maDonHang,
                'maDonHang' => $maDonHang,
                'thoiGianBatDau' => $ngayBatDau,
                'thoiGianKetThuc' => $ngayKetThuc,
                'maND' => $maNguoiLap
            ];

            // Gọi Model để lưu bảng cha
            $maKHSX_moi = $this->keHoachModel->createKHSX($dataKHSX);

            /**
             * KIỂM TRA QUAN TRỌNG:
             * Nếu maKHSX_moi trả về 0 (do lỗi SQL hoặc lỗi CSDL ở Bước 1),
             * chúng ta phải dừng lại và hủy bỏ.
             */
            if (!$maKHSX_moi) {
                throw new Exception("Lỗi: Không thể tạo Kế hoạch sản xuất chính (ID trả về = 0).");
            }

            // 3. TẠO CHI TIẾT XƯỞNG CẮT (BẢNG CON)
            $xuongCatData = $_POST['xuong_cat'];
            foreach ($xuongCatData['nvl_id'] as $index => $maNVL) {
                $soLuongNVL = $xuongCatData['nvl_soLuong'][$index];

                $dataChiTiet = [
                    'maKHSX' => $maKHSX_moi, // Sử dụng ID từ bảng cha
                    'maXuong' => 1,
                    'maNVL' => $maNVL,
                    'soLuongNVL' => $soLuongNVL
                ];
                $this->keHoachModel->createChiTietKHSX($dataChiTiet);
            }

            // 4. TẠO CHI TIẾT XƯỞNG MAY (BẢNG CON)
            $xuongMayData = $_POST['xuong_may'];
            foreach ($xuongMayData['nvl_id'] as $index => $maNVL) {
                $soLuongNVL = $xuongMayData['nvl_soLuong'][$index];

                $dataChiTiet = [
                    'maKHSX' => $maKHSX_moi, // Sử dụng ID từ bảng cha
                    'maXuong' => 2,
                    'maNVL' => $maNVL,
                    'soLuongNVL' => $soLuongNVL
                ];
                $this->keHoachModel->createChiTietKHSX($dataChiTiet);
            }

            // 5. CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG (TỪ YÊU CẦU TRƯỚC)
            $this->donHangModel->updateTrangThai($maDonHang, 'Đang thực hiện');

            // 6. HOÀN TẤT
            // Nếu mọi thứ thành công, lưu lại CSDL
            $this->conn->commit();

            header('Location: index.php?page=lap-ke-hoach&success=1');
            exit;
        } catch (Exception $e) {
            // Nếu có bất kỳ lỗi nào (ở Bước 2 hoặc 4), hủy bỏ tất cả
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
