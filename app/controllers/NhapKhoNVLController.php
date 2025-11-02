<?php
class NhapKhoNVLController {
    public function index() {
        $viewPath = __DIR__ . '/../views/nhapKhoNVL.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "<h3 style='color:red;'>⚠️ Không tìm thấy file view: $viewPath</h3>";
        }
    }
}
?>
