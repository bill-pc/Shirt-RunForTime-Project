<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once './app/models/NhapKhoNVLModel.php';

class NhapKhoNVLController {
    private $model;

    public function __construct() {
        $this->model = new NhapKhoNVLModel();
    }

    public function index() {
        $requests = $this->model->getApprovedRequests();
        require_once __DIR__ . '/../views/nhapKhoNVL.php';
    }

    // 🔹 API lấy chi tiết NVL theo phiếu
    public function ajaxGetDetails() {
    $maYCNK = $_GET['maYCNK'] ?? '';
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($this->model->getDetailsByRequest($maYCNK));
}

    // 🔹 Lưu phiếu nhập kho NVL
   public function luuPhieu() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

    // ✅ Bật hiển thị lỗi để dễ debug
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $data = [
        'tenPNVL' => 'Phiếu nhập nguyên vật liệu',
        'nguoiLap' => $_SESSION['user']['hoTen'] ?? 'Không rõ',
        'ghiChu' => $_POST['ghiChu'] ?? '',
        'ngayNhap' => date('Y-m-d'),
        'maYCNK' => $_POST['maYCNK'] ?? '',
        'items' => json_decode($_POST['items'] ?? '[]', true)
    ];

    // Nếu json_decode trả về null do JSON không hợp lệ, đặt lại thành mảng rỗng
    if (!is_array($data['items'])) {
        $data['items'] = [];
    }

    $result = $this->model->luuPhieuNhap($data);

    // Trả về JSON để frontend xử lý
    header('Content-Type: application/json; charset=utf-8');
    if ($result['success']) {
        echo json_encode([
            'success' => true,
            'message' => $result['message'],
            'redirect' => 'index.php?page=nhap-kho-nvl'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $result['message']
        ]);
    }
    return;
}

}
?>
