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
        'nhaCungCap' => $_POST['nhaCungCap'] ?? '',
        'ngayNhap' => date('Y-m-d'),
        'maYCNK' => $_POST['maYCNK'] ?? '',
        'items' => json_decode($_POST['items'] ?? '[]', true)
    ];

    $result = $this->model->luuPhieuNhap($data);

    if ($result['success']) {
        echo "<script>
            alert('✅ {$result['message']}');
            window.location.href = 'index.php?page=nhap-kho-nvl';
        </script>";
    } else {
        echo "<script>
            alert('{$result['message']}');
            window.location.href = 'index.php?page=nhap-kho-nvl';
        </script>";
    }
}

}
?>
