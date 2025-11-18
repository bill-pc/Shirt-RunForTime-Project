<?php
// app/controllers/GhiNhanThanhPhamController.php
require_once 'app/models/GhiNhanThanhPhamModel.php';
require_once 'app/models/KeHoachSanXuatModel.php';
require_once 'app/models/SanPhamModel.php';
require_once 'app/models/NhanVienModel.php';

class GhiNhanThanhPhamController
{
    private $conn;
    private $khsxModel;

    public function index()
    {
        // Khởi tạo các model cần thiết
        $ghiNhanModel = new GhiNhanThanhPhamModel();
        $this->khsxModel = new KeHoachSanXuatModel($this->conn);
        $sanPhamModel = new SanPhamModel();
        $nhanVienModel = new NhanVienModel();

        
        $danhSachKHSX = $this->khsxModel->getKHSXDaDuyet();
        $danhSachSanPham = $sanPhamModel->getAllSanPham();
        $danhSachNhanVien = $nhanVienModel->getNhanVienSanXuat();

        $danhSachHomNay = $ghiNhanModel->getGhiNhanHomNay();

        require_once 'app/views/ghiNhanTP.php';
    }


    public function luu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = [
                'maKHSX' => $_POST['maKHSX'] ?? 0,
                'maSanPham' => $_POST['maSanPham'] ?? 0,
                'maNhanVien' => $_POST['maNhanVien'] ?? 0,
                'soLuongSPHoanThanh' => $_POST['soLuong'] ?? 0,
                'ngayLam' => $_POST['ngayLam'] ?? date('Y-m-d')
            ];

            if (empty($data['maKHSX']) || empty($data['maSanPham']) || empty($data['maNhanVien']) || $data['soLuongSPHoanThanh'] <= 0) {
                header('Location: index.php?page=ghi-nhan-tp&error=1');
                exit;
            }

            $model = new GhiNhanThanhPhamModel();
            $success = $model->luuGhiNhan($data);

            if ($success) {
                header('Location: index.php?page=ghi-nhan-tp&success=1');
            } else {
                header('Location: index.php?page=ghi-nhan-tp&error=1');
            }
            exit;
        }
        header('Location: index.php?page=ghi-nhan-tp');
        exit;
    }

    public function ajax_get_sanpham_theo_khsx() {
        header('Content-Type: application/json; charset=utf-8');
        if (!isset($_GET['maKHSX'])) {
            echo json_encode(['error' => 'Thiếu mã KHSX']);
            exit;
        }

        $maKHSX = (int)$_GET['maKHSX'];
        $khsxModel = new KeHoachSanXuatModel($this->conn);
        $sanPham = $khsxModel->getSanPhamTheoKHSX($maKHSX);

        echo json_encode($sanPham); // Trả về 1 object sản phẩm
        exit;
    }

    public function ajax_get_xuong_cua_nhanvien() {
        header('Content-Type: application/json; charset=utf-8');
        if (!isset($_GET['maND'])) {
            echo json_encode(['error' => 'Thiếu mã Nhân viên']);
            exit;
        }

        $maND = (int)$_GET['maND'];
        $nhanVienModel = new NhanVienModel();
        $xuong = $nhanVienModel->getXuongCuaNhanVien($maND);

        echo json_encode($xuong); // Trả về 1 object xưởng
        exit;
    }
}
