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
        $ketNoi = new KetNoi();
        $this->conn = $ketNoi->connect();
        $this->keHoachModel = new KeHoachSanxuatModel($this->conn);
        $this->donHangModel = new DonHangSanXuatModel();
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
        include __DIR__ . '/../views/lapKHSX.php';
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

        // Bắt đầu Transaction (Đảm bảo an toàn dữ liệu)
        $this->conn->begin_transaction();

        try {
            // 1. LẤY DỮ LIỆU CHUNG TỪ FORM
            $maDonHang = $_POST['maDonHang'];
            $ngayBatDau = $_POST['ngay_bat_dau'];
            $ngayKetThuc = $_POST['ngay_ket_thuc'];
            $maNguoiLap = 1; // Giả sử ID người lập = 1 (bạn sẽ thay bằng Session)

            // (SỬA LẠI) Kiểm tra dữ liệu cơ bản
            if (empty($maDonHang) || empty($ngayBatDau) || empty($ngayKetThuc)) {
                throw new Exception("Lỗi: Thiếu thông tin Đơn hàng hoặc Ngày bắt đầu/kết thúc.");
            }

            $dataKHSX = [
                'tenKHSX' => 'KHSX cho ĐH ' . $maDonHang, // Tên tự động
                'maDHSX' => $maDonHang,
                'thoiGianBatDau' => $ngayBatDau,
                'thoiGianKetThuc' => $ngayKetThuc,
                'maND' => $maNguoiLap
            ];

            // 2. TẠO KẾ HOẠCH CHA
            $maKHSX_moi = $this->keHoachModel->createKHSX($dataKHSX);

            if (!$maKHSX_moi) {
                // Lỗi này sẽ được ném ra từ Model nếu SQL thất bại
                // (Dựa trên code Model chúng ta đã sửa trước đó)
                throw new Exception("Lỗi: Không thể tạo Kế hoạch sản xuất chính.");
            }

            // 3. TẠO CHI TIẾT CHO XƯỞNG CẮT (maXuong = 1)
            // (SỬA LẠI) Thêm kiểm tra 'isset' và 'is_array'
            if (isset($_POST['xuong_cat']) && is_array($_POST['xuong_cat'])) {
                $xuongCatData = $_POST['xuong_cat'];

                // Chỉ lặp nếu có sản phẩm và mảng nvl_id tồn tại
                if (!empty($xuongCatData['maSanPham']) && isset($xuongCatData['nvl_id']) && is_array($xuongCatData['nvl_id'])) {
                    $maSP_Cat = $xuongCatData['maSanPham'];

                    foreach ($xuongCatData['nvl_id'] as $index => $maNVL) {
                        // Đảm bảo có số lượng tương ứng
                        if (isset($xuongCatData['nvl_soLuong'][$index])) {
                            $soLuongNVL = $xuongCatData['nvl_soLuong'][$index];

                            $dataChiTiet = [
                                'maKHSX' => $maKHSX_moi,
                                'maXuong' => 1, // Giả sử Xưởng Cắt có ID = 1
                                'maSanPham' => $maSP_Cat,
                                'maNVL' => $maNVL,
                                'soLuongNVL' => $soLuongNVL
                            ];
                            // Thêm kiểm tra lỗi khi chèn chi tiết
                            if (!$this->keHoachModel->createChiTietKHSX($dataChiTiet)) {
                                throw new Exception("Lỗi: Không thể lưu chi tiết Xưởng Cắt.");
                            }
                        }
                    }
                }
            } // Kết thúc kiểm tra Xưởng Cắt

            // 4. TẠO CHI TIẾT CHO XƯỞNG MAY (maXuong = 2)
            // (SỬA LẠI) Thêm kiểm tra 'isset' và 'is_array'
            if (isset($_POST['xuong_may']) && is_array($_POST['xuong_may'])) {
                $xuongMayData = $_POST['xuong_may'];

                // Chỉ lặp nếu có sản phẩm và mảng nvl_id tồn tại
                if (!empty($xuongMayData['maSanPham']) && isset($xuongMayData['nvl_id']) && is_array($xuongMayData['nvl_id'])) {
                    $maSP_May = $xuongMayData['maSanPham'];

                    foreach ($xuongMayData['nvl_id'] as $index => $maNVL) {
                        if (isset($xuongMayData['nvl_soLuong'][$index])) {
                            $soLuongNVL = $xuongMayData['nvl_soLuong'][$index];

                            $dataChiTiet = [
                                'maKHSX' => $maKHSX_moi,
                                'maXuong' => 2, // Giả sử Xưởng May có ID = 2
                                'maSanPham' => $maSP_May,
                                'maNVL' => $maNVL,
                                'soLuongNVL' => $soLuongNVL
                            ];
                            // Thêm kiểm tra lỗi khi chèn chi tiết
                            if (!$this->keHoachModel->createChiTietKHSX($dataChiTiet)) {
                                throw new Exception("Lỗi: Không thể lưu chi tiết Xưởng May.");
                            }
                        }
                    }
                }
            } // Kết thúc kiểm tra Xưởng May

            // 5. HOÀN TẤT
            // Nếu không có lỗi, lưu tất cả thay đổi vào CSDL
            $this->conn->commit();
            echo "<script>
                alert('Lập kế hoạch sản xuất thành công!');
                window.location.href = 'index.php?page=lap-khsx';
            </script>";
            exit;
        } catch (Exception $e) {
            // Nếu có lỗi, hủy bỏ tất cả thay đổi
            $errorMessage = addslashes($e->getMessage());
            echo "<script>
                alert('Đã xảy ra lỗi. Vui lòng thử lại: {$errorMessage}');
                window.location.href = 'index.php?page=lap-khsx';
            </script>";
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
