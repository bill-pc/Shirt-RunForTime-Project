<?php
require_once 'app/models/KetNoi.php';

class HomeModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    public function layThongKeTongQuan() {
        $data = [];
        $data['tongKHSX'] = $this->getCount("SELECT COUNT(*) FROM kehoachsanxuat");
        $data['tongNVL'] = $this->getCount("SELECT COUNT(*) FROM nvl");
        $data['tongDonHang'] = $this->getCount("SELECT COUNT(*) FROM donhangsanxuat");
        $data['tongThietBi'] = $this->getCount("SELECT COUNT(*) FROM thietbi");
        $data['daDuyet'] = $this->getCount("SELECT COUNT(*) FROM kehoachsanxuat WHERE trangThai='Đã duyệt'");
        $data['choDuyet'] = $this->getCount("SELECT COUNT(*) FROM kehoachsanxuat WHERE trangThai='Chờ duyệt'");
        return $data;
    }

    private function getCount($sql) {
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_row()[0] : 0;
    }

    // 🔹 Lấy dữ liệu cho biểu đồ năng suất theo ngày
    public function layNangSuatTheoNgay($soNgay = 7) {
    $sql = "
        SELECT 
            DATE(ngayLam) AS ngay,
            SUM(soLuongSPHoanThanh) AS tongSoLuong
        FROM ghinhanthanhphamtheongay
        WHERE ngayLam >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
        GROUP BY DATE(ngayLam)
        ORDER BY ngay ASC
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param('i', $soNgay);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

}
