<?php
require_once 'ketNoi.php';

class BaoCaoSuCoModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ✅ Thêm báo cáo sự cố vào CSDL
    public function themBaoCao($ma, $ten, $loai, $moTa, $hinh) {
        $sql = "INSERT INTO baocaoloi (maThietBi, loaiLoi, moTa, hinhAnh, thoiGian)
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array($ma, $ten, $loai, $moTa, $hinh));
    }
}
?>
