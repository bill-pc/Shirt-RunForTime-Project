<?php
require_once 'app/models/XoaNhanVienModel.php';
require_once 'app/models/SuaNhanVienModel.php'; // cần để cập nhật DB

class SuaNhanVienController {
    private $model;
    private $userModel;

    public function __construct() {
        $this->model = new XoaNhanVienModel(); 
        $this->userModel = new SuaNhanVienModel(); // model thực hiện UPDATE
    }

    // ✅ Trang chính danh sách nhân viên
    public function index() {
        $keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
        $nhanviens = $keyword ? $this->model->search($keyword) : $this->model->getAll();
        require 'app/views/suanhanvien.php';
    }

    // ✅ Hiển thị form sửa theo ID
    public function edit() {
        if (!isset($_GET['id'])) {
            echo "Thiếu ID nhân viên!";
            return;
        }

        $id = $_GET['id'];
        $nhanvien = $this->model->getById($id);

        if (!$nhanvien) {
            echo "Không tìm thấy nhân viên!";
            return;
        }

        require 'app/views/suathongtinnv.php'; 
    }

    // ✅ Cập nhật thông tin nhân viên
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo "Phương thức không hợp lệ!";
            return;
        }

        $data = [
            'maND' => $_POST['maND'],
            'hoTen' => $_POST['hoTen'],
            'gioiTinh' => $_POST['gioiTinh']?? '',
            'ngaySinh' => $_POST['ngaySinh'],
            'phongBan' => $_POST['phongBan'],
            'diaChi' => $_POST['diaChi'],
            'email' => $_POST['email'],
            'soDienThoai' => $_POST['soDienThoai']
        ];

        $this->userModel->update($data);

        header("Location: index.php?page=suanhanvien&msg=updated");
        exit;
    }

    // ✅ AJAX tìm kiếm
    public function searchAjax() {
        header('Content-Type: application/json; charset=utf-8');

        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $results = $keyword ? $this->model->search($keyword) : [];

        echo json_encode($results);
        exit;
    }
}
