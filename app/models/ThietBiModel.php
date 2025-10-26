<?php
require_once 'ketNoi.php';

class ThietBiModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // ✅ Hàm tìm thiết bị theo từ khóa
    public function timThietBiTheoTuKhoa($keyword) {
        $sql = "SELECT maThietBi, tenThietBi 
                FROM thietbi 
                WHERE maThietBi LIKE :kw OR tenThietBi LIKE :kw
                LIMIT 10";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':kw', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
