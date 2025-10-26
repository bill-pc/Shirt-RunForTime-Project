<?php
require_once 'app/models/ThietBiModel.php';

class SearchController {
    public function search() {
        // Lấy từ khóa tìm kiếm
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $type = isset($_GET['type']) ? $_GET['type'] : '';

        // Thiết lập header JSON để tránh lỗi HTML output
        header('Content-Type: application/json; charset=utf-8');

        // Nếu không có từ khóa thì trả mảng rỗng
        if (empty($keyword)) {
            echo json_encode(array());
            return;
        }

        // Nếu type là thietbi -> tìm thiết bị
        if ($type === 'thietbi') {
            $model = new ThietBiModel();
            $result = $model->timThietBiTheoTuKhoa($keyword);
            echo json_encode($result);
            return;
        }

        // Nếu không khớp type nào
        echo json_encode(array(
            "status" => "ok",
            "message" => "Không có type hợp lệ"
        ));
    }
}
?>
