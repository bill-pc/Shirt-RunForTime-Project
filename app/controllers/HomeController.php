<?php
require_once 'app/models/DanhMucModel.php';
class HomeController {
    public function index() {
        require_once 'app/models/DanhMucModel.php';
        $danhMucModel = new DanhMucModel();
        $danhMucData = $danhMucModel->getDanhMuc();

        // Gọi view
        require_once 'app/views/home.php';
    }
}
