<?php
class PheDuyetKeHoachSXController {

    // Hiển thị trang danh sách kế hoạch chờ phê duyệt
    public function index() {
        $viewPath = __DIR__ . '/../views/pheDuyetKeHoachSX.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "<h3 style='color:red;'>❌ Không tìm thấy view: $viewPath</h3>";
        }
    }

    // (Tuỳ chọn) Xử lý phê duyệt hoặc từ chối kế hoạch
    public function duyetKeHoach() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maKH = $_POST['maKeHoach'] ?? '';
            $trangThai = $_POST['trangThai'] ?? 'Chờ duyệt';
            $ghiChu = $_POST['ghiChu'] ?? '';

            // TODO: Gọi model cập nhật DB sau khi duyệt
            echo "<script>alert('✅ Đã cập nhật trạng thái kế hoạch $maKH thành \"$trangThai\"'); window.location='index.php?page=phe-duyet-ke-hoach-sx';</script>";
        }
    }
}
