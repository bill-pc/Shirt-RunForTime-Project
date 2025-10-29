<?php
require_once 'app/models/ThietBiModel.php';

class SearchController {
    public function search() {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        $xuong = isset($_GET['xuong']) ? (int)$_GET['xuong'] : 0;

        header('Content-Type: application/json; charset=utf-8');

        if (empty($keyword)) {
            echo json_encode(array());
            return;
        }

        if ($type === 'thietbi') {
            $model = new ThietBiModel();

            // ✅ Nếu có mã xưởng thì lọc theo xưởng
            if ($xuong > 0) {
                $result = $model->timThietBiTheoTuKhoaVaXuong($keyword, $xuong);
            } else {
                // Giữ lại hàm cũ để tránh lỗi nếu người chưa chọn xưởng
                $result = $model->timThietBiTheoTuKhoa($keyword);
            }

            echo json_encode($result);
            return;
        }

        echo json_encode([
            "status" => "ok",
            "message" => "Không có type hợp lệ"
        ]);
    }
}
?>
