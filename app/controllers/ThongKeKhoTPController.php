<?php
require_once 'app/models/ThongKeKhoTPModel.php';

class ThongKeKhoTPController {
    private $model;

    public function __construct() {
        $this->model = new ThongKeKhoTPModel();
    }

    public function index() {
        $search = $_GET["search"] ?? "";
        $data = $this->model->thongKe($search);

        require 'app/views/thongkekhotp.php';
    }

    public function export() {
        $search = $_GET["search"] ?? "";
        $this->model->exportCSV($search);
    }
}
