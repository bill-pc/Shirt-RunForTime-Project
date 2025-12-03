<?php
// app/controllers/GhiNhanThanhPhamController.php
require_once 'app/models/GhiNhanThanhPhamModel.php';
require_once 'app/models/KeHoachSanXuatModel.php';
require_once 'app/models/SanPhamModel.php';
require_once 'app/models/NhanVienModel.php';
require_once 'app/models/XuongModel.php';

class GhiNhanThanhPhamController
{

    public function index()
    {
        $ghiNhanModel = new GhiNhanThanhPhamModel();
        $khsxModel = new KeHoachSanXuatModel();
        $xuongModel = new XuongModel();

        // Lấy dữ liệu cho các Dropdown
        $danhSachKHSX = $khsxModel->getKHSXDaDuyet();
        $danhSachXuong = $xuongModel->getAllXuong();

        // Lấy lịch sử 5 ngày gần nhất
        $lichSuGhiNhan = $ghiNhanModel->getLichSuGhiNhan();

        require_once 'app/views/ghiNhanTP.php';
    }

    /**
     * XỬ LÝ LƯU DANH SÁCH (JSON)
     */
    public function luu()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Đọc dữ liệu JSON gửi từ fetch()
            $inputJSON = file_get_contents('php://input');
            $input = json_decode($inputJSON, true);

            header('Content-Type: application/json');

            if (!$input || empty($input['details']) || empty($input['maKHSX'])) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ hoặc danh sách rỗng.']);
                exit;
            }

            // Tạo header chung cho phiếu
            $header = [
                'maKHSX' => $input['maKHSX'],
                'maSanPham' => $input['maSanPham'],
                'ngayLam' => $input['ngayLam']
            ];

            $model = new GhiNhanThanhPhamModel();

            // Gọi Model để lưu
            if ($model->luuDanhSach($header, $input['details'])) {
                echo json_encode(['success' => true, 'message' => 'Lưu thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi CSDL khi lưu dữ liệu.']);
            }
            exit;
        }
    }

    // API: Lấy danh sách sản phẩm theo Kế hoạch
    public function ajaxGetSanPham()
    {
        $maKHSX = $_GET['maKHSX'] ?? 0;
        $model = new KeHoachSanXuatModel();
        echo json_encode($model->getDS_SanPhamTheoKHSX($maKHSX));
    }

    // API: Lấy nhân viên theo Xưởng
    public function ajaxGetNhanVienByXuong()
    {
        $maXuong = $_GET['maXuong'] ?? 0;
        $xuongModel = new XuongModel();
        $nhanVienModel = new NhanVienModel();

        $xuong = $xuongModel->getXuongById($maXuong);
        if ($xuong) {
            echo json_encode($nhanVienModel->getNhanVienTheoPhongBan($xuong['tenXuong']));
        } else {
            echo json_encode([]);
        }
    }

    public function ajaxGetChiTietPhieu()
    {
        $ngay = $_GET['ngay'] ?? '';
        $khsx = $_GET['khsx'] ?? 0;
        $model = new GhiNhanThanhPhamModel();
        echo json_encode($model->getChiTietPhieu($ngay, $khsx));
    }
}
