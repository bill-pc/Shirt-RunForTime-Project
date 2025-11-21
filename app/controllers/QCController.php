<?php
require_once 'app/models/QCModel.php';

class QCController {
    private $model;

    public function __construct() {
        $this->model = new QCModel();
    }

    public function index() {
        $danhSachQC = $this->model->getDanhSachCanKiemTra();
        require_once 'app/views/qc_list.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maYC = $_POST['maYC'] ?? 0;
            $slDat = intval($_POST['soLuongDat'] ?? 0);
            $slHong = intval($_POST['soLuongHong'] ?? 0);
            $ghiChu = $_POST['ghiChu'] ?? '';
            $tongSoLuong = intval($_POST['tongSoLuong'] ?? 0);

            if ($maYC <= 0) {
                echo "<script>alert('Lỗi: Mã phiếu không hợp lệ!'); window.history.back();</script>";
                return;
            }

            if (($slDat + $slHong) != $tongSoLuong) {
                echo "<script>alert('Lỗi: Tổng số lượng Đạt và Hỏng phải bằng tổng số lượng yêu cầu ($tongSoLuong)!'); window.history.back();</script>";
                return;
            }

            $user = $_SESSION['user']['hoTen'] ?? 'QC';
            $result = $this->model->capNhatKetQuaQC($maYC, $slDat, $slHong, $ghiChu, $user);

            if ($result) {
                echo "<script>alert('Cập nhật kết quả kiểm tra thành công!'); window.location.href='index.php?page=bao-cao-chat-luong';</script>";
            } else {
                echo "<script>alert('Lỗi hệ thống khi cập nhật!'); window.history.back();</script>";
            }
        }
    }
}
?>