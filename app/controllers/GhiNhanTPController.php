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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inputJSON = file_get_contents('php://input');
            $input = json_decode($inputJSON, true);

            header('Content-Type: application/json');

            if (!$input || empty($input['details']) || empty($input['maKHSX'])) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ hoặc danh sách rỗng.']);
                exit;
            }

            $header = [
                'maKHSX' => $input['maKHSX'],
                'maSanPham' => $input['maSanPham'],
                'ngayLam' => $input['ngayLam']
            ];

            $model = new GhiNhanThanhPhamModel();

            if ($model->luuDanhSach($header, $input['details'])) {
                echo json_encode(['success' => true, 'message' => 'Lưu thành công!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi CSDL khi lưu dữ liệu.']);
            }
            exit;
        }
    }

    public function ajaxGetSanPham()
    {
        $maKHSX = $_GET['maKHSX'] ?? 0;
        $model = new KeHoachSanXuatModel();

        $sanPham = $model->getSanPhamChinh($maKHSX);

        if ($sanPham) {
            echo json_encode([$sanPham]);
        } else {
            echo json_encode([]);
        }
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
