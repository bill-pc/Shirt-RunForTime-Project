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

        // Lấy khoảng thời gian
        $tuNgay = $_GET['tuNgay'] ?? null;
        $denNgay = $_GET['denNgay'] ?? null;

        // 🔒 YÊU CẦU: Chỉ hiển thị đơn hàng "Chờ duyệt"
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

        // 1. KIỂM TRA DỮ LIỆU ĐẦU VÀO
        $maDonHang = $_POST['maDonHang'] ?? '';
        
        if (empty($maDonHang)) {
            // Nếu không có mã đơn hàng, báo lỗi ngay
            echo "<script>alert('Lỗi: Không tìm thấy mã đơn hàng!'); window.history.back();</script>";
            exit;
        }

        $this->conn->begin_transaction();

        try {
            $ngayBatDau = $_POST['ngay_bat_dau'];
            $ngayKetThuc = $_POST['ngay_ket_thuc'];
            $maNguoiLap = 1; // Giá trị tạm thời

            // 2. TẠO KHSX CHÍNH
            $dataKHSX = [
                'tenKHSX' => 'KHSX cho ĐH ' . $maDonHang,
                'maDonHang' => $maDonHang,
                'thoiGianBatDau' => $ngayBatDau,
                'thoiGianKetThuc' => $ngayKetThuc,
                'maND' => $maNguoiLap
            ];
            $maKHSX_moi = $this->keHoachModel->createKHSX($dataKHSX);

            if (!$maKHSX_moi) throw new Exception("Lỗi tạo KHSX");

            // 3. LƯU CHI TIẾT (Giữ nguyên logic cũ của bạn)
            // ... (Đoạn code vòng lặp lưu chi tiết xưởng cắt/may giữ nguyên) ...
            // Nếu bạn đã xóa đoạn này để test thì nhớ thêm lại nhé!
            // Ví dụ rút gọn:
            if (isset($_POST['xuong_cat'])) {
                $xuongCatData = $_POST['xuong_cat'];
                foreach ($xuongCatData['nvl_id'] as $index => $maNVL) {
                    $this->keHoachModel->createChiTietKHSX([
                        'maKHSX' => $maKHSX_moi,
                        'maSanPham' => $xuongCatData['maSanPham'],
                        'maXuong' => 1,
                        'maNVL' => $maNVL,
                        'soLuongNVL' => $xuongCatData['nvl_soLuong'][$index]
                    ]);
                }
            }
            // Tương tự cho xưởng may...

            // 4. CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG (QUAN TRỌNG)
            // Gọi hàm update và kiểm tra kết quả
            $kqUpdate = $this->donHangModel->updateTrangThai($maDonHang, 'Đang thực hiện');
            
            if (!$kqUpdate) {
                // Nếu update thất bại, ném lỗi để rollback toàn bộ
                throw new Exception("Lỗi: Không thể cập nhật trạng thái đơn hàng số " . $maDonHang);
            }

            // 5. HOÀN TẤT
            $this->conn->commit();
            header('Location: index.php?page=lap-ke-hoach&success=1');
            exit;

        } catch (Exception $e) {
            $this->conn->rollback();
            // In lỗi chi tiết ra màn hình để xem nguyên nhân
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
