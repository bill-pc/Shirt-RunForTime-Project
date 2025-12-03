<?php
require_once 'app/models/CongViecModel.php';

class CongViecController {
    private $model;

    public function __construct() {
        $this->model = new CongViecModel(); // Model tự tạo kết nối
    }

    public function index() {
        $data = $this->model->getAll();
        include __DIR__ . '/../views/xemcongviec.php';
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $this->model->delete($_GET['id']);
            header("Location: index.php?page=xemcongviec");
            exit;
        }
    }
}
