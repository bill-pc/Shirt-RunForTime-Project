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

        $danhSachKHSX = $khsxModel->getKHSXDaDuyet();
        $danhSachXuong = $xuongModel->getAllXuong();

        $lichSuGhiNhan = $ghiNhanModel->getLichSuGhiNhan();

        require_once 'app/views/ghiNhanTP.php';
    }

    public function luu()
    {
        header('Content-Type: application/json; charset=utf-8');

        // Nhận JSON từ JS
        $data = json_decode(file_get_contents("php://input"), true);

        // Kiểm tra dữ liệu đầu vào
        if (!$data || !isset($data['header']) || !isset($data['details'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Dữ liệu gửi lên thiếu header hoặc details'
            ]);
            return;
        }

        require_once './app/models/GhiNhanThanhPhamModel.php';
        $model = new GhiNhanThanhPhamModel();

        // Gọi hàm Model (Hàm này trả về TRUE hoặc chuỗi LỖI)
        $ketQua = $model->luuDanhSach(
            $data['header'],
            $data['details']
        );

        // --- ĐOẠN SỬA QUAN TRỌNG ---
        if ($ketQua === true) {
            // Nếu đúng là TRUE (boolean) thì mới báo thành công
            echo json_encode([
                'success' => true,
                'message' => 'Lưu thành công!'
            ]);
        } else {
            // Ngược lại (trả về chuỗi lỗi hoặc false) thì báo lỗi
            // Nếu $ketQua là false (do lỗi hệ thống khác) thì báo lỗi chung
            $msg = is_string($ketQua) ? $ketQua : 'Lỗi không xác định từ CSDL';
            
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi: ' . $msg
            ]);
        }
    }

    public function ajaxGetSanPham()
    {
        $maKHSX = $_GET['maKHSX'] ?? 0;

        require_once 'app/models/KeHoachSanXuatModel.php';
        $model = new KeHoachSanXuatModel();

        $sanPham = $model->getSanPhamTheoKHSX($maKHSX);

        header('Content-Type: application/json');

        if ($sanPham) {
            echo json_encode([$sanPham]); // JS cần ARRAY
        } else {
            echo json_encode([]);
        }
        exit;
    }


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
