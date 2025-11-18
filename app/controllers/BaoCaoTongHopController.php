<?php
// app/controllers/BaoCaoTongHopController.php
require_once 'app/models/BaoCaoTongHopModel.php';

class BaoCaoTongHopController
{

    public function index()
    {
        $model = new BaoCaoTongHopModel();

        // Lấy giá trị lọc từ POST hoặc GET (dùng POST để gọn gàng hơn)
        $loai = $_POST['loai_bao_cao'] ?? 'all';
        // Mặc định lọc 7 ngày gần nhất
        $start = $_POST['start_date'] ?? date('Y-m-d', strtotime('-7 days'));
        $end = $_POST['end_date'] ?? date('Y-m-d');

        // Lấy dữ liệu
        $danhSachBaoCao = $model->getBaoCaoTongHop($loai, $start, $end);

        // Truyền các giá trị lọc ra View để giữ lại trên form
        $filter_values = [
            'loai' => $loai,
            'start' => $start,
            'end' => $end
        ];

        // Tải View
        require_once 'app/views/baoCaoTongHop.php';
    }
    public function ajaxGetDetails()
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = $_GET['id'] ?? 0;
        $type = $_GET['type'] ?? '';

        if (empty($id) || empty($type)) {
            echo json_encode(['error' => 'Thiếu ID hoặc loại báo cáo.']);
            exit;
        }

        // Gọi Model để lấy dữ liệu
        $model = new BaoCaoTongHopModel();
        $details = $model->getDetail($id, $type);

        // Trả dữ liệu về cho JavaScript
        echo json_encode($details);
        exit;
    }
}
