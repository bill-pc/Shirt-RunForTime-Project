<?php
require_once 'app/models/ThongKeNVLModel.php';

class ThongKeNVLController {
    private $model;

    public function __construct() {
        $this->model = new ThongKeNVLModel();
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $start = $_POST['start_date'] ?? '';
            $end = $_POST['end_date'] ?? '';
            $tenNVL = $_POST['tenNVL'] ?? '';
            $loai = $_POST['loai_baocao'] ?? '';

            // Trả về JSON
            $rows = $this->model->layThongKeKhoNVL($start, $end, $tenNVL, $loai);

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($rows);
            exit;
        }

        // Hiển thị view
        require_once 'app/views/thongkekhonvl.php';
    }

   public function xuatCSV() {
    // Lấy tham số lọc từ form
    $start_date = $_GET['start_date'] ?? '';
    $end_date = $_GET['end_date'] ?? '';
    $tenNVL = $_GET['tenNVL'] ?? '';
    $loai = $_GET['loai'] ?? '';

    require_once 'app/models/ThongKeNVLModel.php';
    $model = new ThongKeNVLModel();
    $data = $model->layThongKeKhoNVL($start_date, $end_date, $tenNVL, $loai);

    // Tên file CSV
    $filename = "thongke_nvl_" . date('Ymd_His') . ".csv";

    // Header xuất file
    header("Content-Type: text/csv; charset=UTF-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    echo "\xEF\xBB\xBF"; // BOM UTF-8 để tránh lỗi tiếng Việt

    $output = fopen("php://output", "w");

    // Ghi tiêu đề cột
    fputcsv($output, ["Mã NVL", "Tên NVL", "Đơn vị tính", "Tổng nhập", "Tổng xuất", "Tồn kho"]);

    // Ghi dữ liệu thống kê
    foreach ($data as $row) {
        fputcsv($output, [
            $row['maNVL'],
            $row['tenNVL'],
            $row['donViTinh'],
            $row['tongNhap'],
            $row['tongXuat'],
            $row['tonKho']
        ]);
    }

    fclose($output);
    exit;
}

}
?>
