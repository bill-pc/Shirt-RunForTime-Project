<?php
require_once 'app/models/ThongKeNVLModel.php';

class ThongKeController {
    private $model;

    public function __construct() {
        $this->model = new ThongKeNVLModel();
    }

    // ✅ Hiển thị giao diện thống kê & xử lý truy vấn AJAX
    public function index() {
        // Nếu là AJAX (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $start = $_POST['start_date'] ?? '';
            $end = $_POST['end_date'] ?? '';
            $tenNVL = $_POST['tenNVL'] ?? '';
            $loai = $_POST['loai_baocao'] ?? '';

            $rows = $this->model->layThongKeKhoNVL($start, $end, $tenNVL, $loai);

            header('Content-Type: application/json');
            echo json_encode($rows);
            exit;
        }

        // Lần đầu truy cập — chỉ hiển thị giao diện
        require_once 'app/views/thongkekhonvl.php';
    }

    // ✅ Xuất toàn bộ báo cáo kho NVL ra CSV
    public function exportCsv() {
        $data = $this->model->layTatCaKhoNVL();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=baocao_kho_nvl.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['STT', 'Mã NVL', 'Tên NVL', 'Đơn vị tính', 'Tổng nhập', 'Tổng xuất', 'Tồn kho']);

        $stt = 1;
        foreach ($data as $row) {
            fputcsv($output, [
                $stt++,
                $row['maNVL'],
                $row['tenNVL'],
                $row['donViTinh'] ?? '',
                $row['tongNhap'] ?? 0,
                $row['tongXuat'] ?? 0,
                $row['tonKho'] ?? 0
            ]);
        }

        fclose($output);
        exit;
    }
}
?>
