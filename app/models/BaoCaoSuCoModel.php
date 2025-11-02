<?php
require_once 'ketNoi.php';

class BaoCaoSuCoModel {
    private $conn;

    public function __construct() {
        $database = new KetNoi();
        $this->conn = $database->connect();
    }

    public function themBaoCao($maThietBi, $tenBaoCao, $loaiLoi, $moTa, $hinhAnh) {
        $sql = "INSERT INTO baocaoloi (maThietBi, tenBaoCao, loaiLoi, moTa, hinhAnh, thoiGian)
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(array($maThietBi, $tenBaoCao, $loaiLoi, $moTa, $hinhAnh));
    }
}
?>
