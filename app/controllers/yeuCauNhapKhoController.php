<?php
require_once './app/models/KeHoachSanXuatModel.php';
require_once './app/models/PhieuYeuCauNhapKhoModel.php';

class YeuCauNhapKhoController {

    // ============================
    // 1️⃣ DANH SÁCH + FORM LẬP PHIẾU
    // ============================
    public function index() {
        // 🔹 Lấy danh sách kế hoạch sản xuất đã duyệt
       $phieuModel = new PhieuYeuCauNhapKhoModel();
$danhSachKHSX = $phieuModel->getAllPlansForNhapKho();


        // 🔹 Lấy danh sách phiếu yêu cầu nhập kho NVL
        $phieuModel = new PhieuYeuCauNhapKhoModel();
        $danhSachPhieu = $phieuModel->getAll();

        // 🔹 Gọi view
        require __DIR__ . '/../views/taoYCNhapKhoNVL.php';
    }

    // ============================
    // 2️⃣ XEM CHI TIẾT KẾ HOẠCH
    // ============================
    public function chiTiet() {
        $maKHSX = intval($_GET['maKHSX'] ?? 0);
        if ($maKHSX <= 0) {
            echo "Thiếu mã kế hoạch sản xuất!";
            return;
        }

        $m = new KeHoachSanXuatModel();
        $thongTinKHSX = $m->getPlanById($maKHSX);
        $danhSachNVL  = $m->getMaterialsForPlan($maKHSX);

        require_once __DIR__ . '/../views/taoYCNhapKhoNVL.php';
    }

    // ============================
    // 3️⃣ LƯU PHIẾU YÊU CẦU
    // ============================
public function luuPhieu() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo "404 - Trang không tồn tại!";
        return;
    }

    $model = new PhieuYeuCauNhapKhoModel();

    $data = [
        'maKHSX' => $_POST['maKHSX'] ?? null,
        'nhaCungCap' => $_POST['nhaCungCap'] ?? '',
        'ngayLap' => $_POST['ngayLap'] ?? date('Y-m-d'),
        'ghiChu' => $_POST['ghiChu'] ?? '',
        'nvl' => $_POST['nvl'] ?? []
    ];

    $maKHSX = intval($data['maKHSX'] ?? 0);

    // ✅ Kiểm tra đã có phiếu cho kế hoạch này chưa
    if ($model->existsByKeHoach($maKHSX)) {
        echo "<script>
            alert('⚠️ Kế hoạch sản xuất này đã được lập phiếu yêu cầu nhập kho NVL rồi!');
            window.location.href = 'index.php?page=tao-yeu-cau-nhap-kho';
        </script>";
        return;
    }

    $ok = $model->createPhieuYeuCauNhapKho($data);

    if ($ok) {
        echo "<script>
            alert('✅ Đã lưu phiếu yêu cầu nhập kho thành công!');
            window.location.href = 'index.php?page=tao-yeu-cau-nhap-kho';
        </script>";
    } else {
        echo "<script>
            alert('❌ Lưu phiếu thất bại! Vui lòng kiểm tra lại.');
            window.history.back();
        </script>";
    }
}

}
