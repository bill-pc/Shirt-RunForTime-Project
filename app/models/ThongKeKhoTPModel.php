<?php
require_once 'ketNoi.php';

class ThongKeKhoTPModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    public function thongKe($search = "") {

    $sql = "
        SELECT 
            sp.maSanPham,
            sp.tenSanPham,
            sp.donVi,

            sp.soLuongTon AS tongSL,   -- TỔNG SL LẤY TỪ soLuongTon

            COALESCE(px.tongXuat, 0) AS tongXuat,   -- TỔNG XUẤT

            (sp.soLuongTon - COALESCE(px.tongXuat, 0)) AS tonKho   -- TỒN = TỔNG SL - TỔNG XUẤT

        FROM san_pham sp

        LEFT JOIN (
            SELECT maSanPham, SUM(soLuongXuat) AS tongXuat
            FROM phieuxuatthanhpham
            GROUP BY maSanPham
        ) px ON sp.maSanPham = px.maSanPham

        WHERE sp.tenSanPham LIKE ?
        ORDER BY sp.maSanPham ASC
    ";

    $stmt = $this->conn->prepare($sql);
    $like = "%".$search."%";
    $stmt->bind_param("s", $like);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}



    public function exportCSV($search = "") {
        $data = $this->thongKe($search);

        header("Content-Type: text/csv; charset=UTF-8");
        header("Content-Disposition: attachment; filename=ThongKeKhoTP_" . date("Ymd_His") . ".csv");

        echo chr(0xEF).chr(0xBB).chr(0xBF); // BOM UTF-8

        $fp = fopen("php://output", "w");

        fputcsv($fp, ['Mã SP', 'Tên SP', 'Đơn vị', 'Tổng SL', 'Tổng xuất', 'Tồn Kho']);

foreach ($data as $row) {
    fputcsv($fp, [
        $row['maSanPham'],
        $row['tenSanPham'],
        $row['donVi'],
        $row['tongSL'],
        $row['tongXuat'],
        $row['tonKho']
    ]);
}



        fclose($fp);
        exit;
    }
}
