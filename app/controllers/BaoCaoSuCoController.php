<?php
require_once 'app/models/BaoCaoSuCoModel.php';

class BaoCaoSuCoController {

    public function hienThiForm() {
        require 'app/views/lapbaocaosuco.php';
    }

    public function luuBaoCao() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ma = isset($_POST['ma_thiet_bi']) ? $_POST['ma_thiet_bi'] : '';
            $ten = isset($_POST['ten_thiet_bi']) ? $_POST['ten_thiet_bi'] : '';
            $loai = isset($_POST['loai_loi']) ? $_POST['loai_loi'] : '';
            $moTa = isset($_POST['mo_ta']) ? $_POST['mo_ta'] : '';

            // --- Xử lý upload hình ảnh ---
            $hinh = null;
            if (!empty($_FILES['hinh_anh']['name'])) {
                $file = $_FILES['hinh_anh'];
                $targetDir = "uploads/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                $fileName = time() . "_" . basename($file["name"]);
                $targetFile = $targetDir . $fileName;

                if (move_uploaded_file($file["tmp_name"], $targetFile)) {
                    $hinh = $targetFile;
                }
            }

            // --- Gọi model để lưu ---
            $model = new BaoCaoSuCoModel();
            $ok = $model->themBaoCao($ma, $ten, $loai, $moTa, $hinh);

            if ($ok) {
                echo "<script>alert('✅ Gửi báo cáo thành công!'); window.location='index.php?page=baocaosuco';</script>";
            } else {
                echo "<script>alert('❌ Lỗi khi lưu vào cơ sở dữ liệu!'); window.history.back();</script>";
            }
        } else {
            header("Location: index.php?page=baocaosuco");
            exit;
        }
    }
}
?>
