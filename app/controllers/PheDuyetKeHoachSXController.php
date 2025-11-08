<?php
require_once './app/models/PheDuyetKeHoachSXModel.php';

class PheDuyetKeHoachSXController {
    private $model;

    public function __construct() {
        $this->model = new PheDuyetKeHoachSXModel();
    }

    public function index() {
        $plans = $this->model->getPendingPlans();
        require_once __DIR__ . '/../views/pheDuyetKeHoachSX.php';
    }

    // ✅ Xử lý phê duyệt / từ chối
    public function duyetKeHoach() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $maKH = intval($_POST['maKeHoach'] ?? 0);
        $ghiChu = $_POST['ghiChu'] ?? '';
        $trangThai = $_POST['trangThai'] ?? 'Đã duyệt';
        $nguoiThucHien = $_SESSION['user']['hoTen'] ?? 'Hệ thống';

        if ($maKH <= 0) {
            echo json_encode(['success' => false, 'message' => 'Thiếu mã kế hoạch']);
            exit;
        }

        // ✅ Cập nhật trạng thái kế hoạch
        $this->model->updatePlanStatus($maKH, $trangThai, $ghiChu);

        // ✅ Ghi lịch sử phê duyệt
        $this->model->addApprovalHistory($maKH, $trangThai, $ghiChu, $nguoiThucHien);

        echo json_encode(['success' => true, 'message' => 'Cập nhật thành công']);
        exit;
    }
}


    // ✅ AJAX chi tiết kế hoạch
    public function ajaxGetPlanDetail() {
        header('Content-Type: application/json; charset=utf-8');
        require_once 'app/models/KeHoachSanXuatModel.php';
        $model = new KeHoachSanXuatModel();

        $maKHSX = intval($_GET['maKHSX'] ?? 0);
        $plan = $model->getPlanById($maKHSX);
        $materials = $model->getMaterialsForPlan($maKHSX);

        echo json_encode([
            'maKHSX' => $maKHSX,
            'tenKHSX' => $plan['tenKHSX'] ?? '',
            'ngayBatDau' => $plan['thoiGianBatDau'] ?? '',
            'ngayKetThuc' => $plan['thoiGianKetThuc'] ?? '',
            'nguyenVatLieu' => $materials
        ], JSON_UNESCAPED_UNICODE);
    }
    public function ajaxGetApprovalHistory() {
    header('Content-Type: application/json; charset=utf-8');
    $maKHSX = intval($_GET['maKHSX'] ?? 0);
    echo json_encode($this->model->getApprovalHistory($maKHSX), JSON_UNESCAPED_UNICODE);
    exit;
}

}
?>
