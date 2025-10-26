<?php
require_once 'app/models/BaoCaoSuCoModel.php';

class BaoCaoSuCoController {
    private $model;

    public function __construct() {
        $this->model = new BaoCaoSuCoModel();
    }

    public function luuBaoCao() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ✅ Lấy dữ liệu từ form (dùng isset để tương thích PHP cũ)
            $tenBaoCao  = isset($_POST['ten_baocao']) ? $_POST['ten_baocao'] : null;
            $maThietBi  = isset($_POST['ma_thiet_bi']) ? $_POST['ma_thiet_bi'] : null;
            $tenThietBi = isset($_POST['ten_thiet_bi']) ? $_POST['ten_thiet_bi'] : null; // chỉ hiển thị
            $loaiLoi    = isset($_POST['loai_loi']) ? $_POST['loai_loi'] : null;
            $moTa       = isset($_POST['mo_ta']) ? $_POST['mo_ta'] : null;

            // ✅ Xử lý upload hình ảnh (nếu có)
            $hinhAnh = null;
            if (!empty($_FILES['hinhAnh']['name'])) {
                $targetDir = "uploads/";
                if (!file_exists($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $fileName = time() . '_' . basename($_FILES['hinhAnh']['name']);
                $hinhAnh = $targetDir . $fileName;

                move_uploaded_file($_FILES['hinhAnh']['tmp_name'], $hinhAnh);
            }

            // ✅ Lưu vào DB (không lưu tên thiết bị)
            $result = $this->model->themBaoCao($maThietBi, $tenBaoCao, $loaiLoi, $moTa, $hinhAnh);

            // ✅ Phản hồi
            if ($result) {
                echo "<script>
                        alert('Đã gửi báo cáo thành công!');
                        window.location='index.php?page=home';
                        </script>";
            } else {
                echo "<script>
                        alert('Lỗi khi lưu báo cáo!');
                        window.history.back();
                        </script>";
            }
        } else {
            echo "Phương thức không hợp lệ!";
        }
    }
}
?>
