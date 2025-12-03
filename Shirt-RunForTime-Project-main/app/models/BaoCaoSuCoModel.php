<?php
require_once 'ketNoi.php';

class BaoCaoSuCoModel {
    private $conn;

    public function __construct() {
        $database = new KetNoi();
        $this->conn = $database->connect();
    }

    public function themBaoCao($maND, $maThietBi, $tenBaoCao, $loaiLoi, $moTa, $hinhAnh) {
        $sql = "INSERT INTO baocaoloi (maND, maThietBi, tenBaoCao, loaiLoi, moTa, hinhAnh, thoiGian)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);

        // Có 6 dấu hỏi -> 6 giá trị
        $stmt->bind_param("isssss", $maND, $maThietBi, $tenBaoCao, $loaiLoi, $moTa, $hinhAnh);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
}

}
?>
