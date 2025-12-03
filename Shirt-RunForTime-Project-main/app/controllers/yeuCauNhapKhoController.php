<?php
require_once './app/models/KeHoachSanXuatModel.php';
require_once './app/models/PhieuYeuCauNhapKhoModel.php';

class YeuCauNhapKhoController {

    // 1) Danh sách KHSX đã duyệt
    public function index() {
        $m = new KeHoachSanXuatModel();
        $danhSachKHSX = $m->getAllPlansForNhapKho();
        require __DIR__ . '/../views/taoYCNhapKhoNVL.php';
    }

    // 2) Xem chi tiết KHSX → form lập phiếu (UI của bạn)
    public function chiTiet() {
        $maKHSX = intval($_GET['maKHSX'] ?? 0);
        if ($maKHSX<=0) { echo "Thiếu mã KHSX"; return; }

        $m = new KeHoachSanXuatModel();
        $thongTinKHSX = $m->getPlanById($maKHSX);
        $danhSachNVL  = $m->getMaterialsForPlan($maKHSX);
        require_once __DIR__ . '/../views/taoYCNhapKhoNVL.php';
 // chính là UI bạn gửi ảnh
    }

    // // 3) Lưu phiếu yêu cầu
    public function luuPhieu() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $m = new PhieuYeuCauNhapKhoModel();
        $ok = $m->createPhieuYeuCauNhapKho($_POST);
        echo $ok
            ? "<script>alert('Đã lập phiếu yêu cầu!'); location='index.php?page=tao-yeu-cau-nhap-kho';</script>"
            : "<script>alert('Lỗi lập phiếu!'); history.back();</script>";
    }
}
