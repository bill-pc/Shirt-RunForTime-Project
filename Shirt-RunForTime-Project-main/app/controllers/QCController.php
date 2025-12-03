<?php
require_once 'app/models/QCModel.php';

class QCController {
    private $model;

    public function __construct() {
        $this->model = new QCModel();
    }

    // Hiển thị danh sách
    public function index() {
        $danhSachQC = $this->model->getDanhSachCanKiemTra();
        require_once 'app/views/qc_list.php';
    }

    // Xử lý cập nhật kết quả
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maYC = isset($_POST['maYC']) ? intval($_POST['maYC']) : 0;
            $slDat = isset($_POST['soLuongDat']) ? intval($_POST['soLuongDat']) : 0;
            $slHong = isset($_POST['soLuongHong']) ? intval($_POST['soLuongHong']) : 0;
            $ghiChu = $_POST['ghiChu'] ?? '';
            $tongSoLuong = isset($_POST['tongSoLuong']) ? intval($_POST['tongSoLuong']) : 0;

            if ($maYC <= 0) {
                echo "<script>alert('Lỗi: Mã phiếu không hợp lệ!'); window.history.back();</script>";
                return;
            }

            // Kiểm tra tổng số lượng
            if (($slDat + $slHong) != $tongSoLuong) {
                echo "<script>alert('Lỗi: Tổng số lượng Đạt ($slDat) và Hỏng ($slHong) phải bằng tổng số lượng yêu cầu ($tongSoLuong)!'); window.history.back();</script>";
                return;
            }

            $user = $_SESSION['user']['hoTen'] ?? 'QC';
            $result = $this->model->capNhatKetQuaQC($maYC, $slDat, $slHong, $ghiChu, $user);

            if ($result) {
                // Chuyển hướng về lại trang danh sách QC
                echo "<script>alert('Cập nhật kết quả kiểm tra thành công!'); window.location.href='index.php?page=bao-cao-chat-luong';</script>";
                exit();
            } else {
                echo "<script>alert('Lỗi hệ thống khi cập nhật!'); window.history.back();</script>";
            }
        }
    }
}
?>