<?php
require_once 'ketNoi.php';

class ThanhPhamModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    public function thongKe() {
        $sql = "
            SELECT 
                sp.maSanPham,
                sp.tenSanPham,
                sp.donVi,
                sp.soLuongTon,
                COALESCE(SUM(px.soLuongXuat), 0) AS soLuongXuat
            FROM san_pham sp
            LEFT JOIN phieuxuatthanhpham px ON sp.maSanPham = px.maSanPham
            GROUP BY sp.maSanPham, sp.tenSanPham, sp.donVi, sp.soLuongTon
            ORDER BY sp.tenSanPham ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function exportCSV() {
        $data = $this->thongKe();
        if (!is_dir("exports")) mkdir("exports");

        $file = "exports/thongke_thanhpham_" . date("Ymd_His") . ".csv";
        $fp = fopen($file, "w");

        // BOM UTF-8 để Excel đọc đúng Unicode
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        // Tiêu đề CSV
        fputcsv($fp, ['STT', 'Mã SP', 'Tên SP', 'Đơn vị', 'Số lượng tồn', 'Số lượng xuất']);

        $i = 1;
        foreach ($data as $row) {
            fputcsv($fp, [
                $i++,
                $row['maSanPham'],
                $row['tenSanPham'],
                $row['donVi'],
                $row['soLuongTon'],
                $row['soLuongXuat'],
            ]);
        }

        fclose($fp);
        return $file;
    }
}
