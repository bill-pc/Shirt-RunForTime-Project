<?php
require_once 'ketNoi.php';

class ThanhPhamModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    public function thongKe($from = null, $to = null) {
        $params = [];
        $sql = "";

        if (!empty($from) && !empty($to)) {
            $sql = "
                SELECT 
                    sp.maSanPham,
                    sp.tenSanPham,
                    sp.donVi,
                    sp.soLuongTon,
                    COALESCE(SUM(CASE WHEN px.ngayXuat BETWEEN ? AND ? THEN px.soLuongXuat ELSE 0 END), 0) AS soLuongXuat,
                    COALESCE(MAX(CASE WHEN px.ngayXuat BETWEEN ? AND ? THEN px.ngayXuat END), sp.ngayXuat) AS ngayXuatHienThi
                FROM san_pham sp
                LEFT JOIN phieuxuatthanhpham px ON sp.maSanPham = px.maSanPham
                GROUP BY sp.maSanPham, sp.tenSanPham, sp.donVi, sp.soLuongTon, sp.ngayXuat
                HAVING (ngayXuatHienThi BETWEEN ? AND ?) OR (soLuongXuat > 0 AND ngayXuatHienThi IS NOT NULL)
                ORDER BY sp.tenSanPham ASC
            ";
            $params = [$from, $to, $from, $to, $from, $to];
        } else {
            $sql = "
                SELECT 
                    sp.maSanPham,
                    sp.tenSanPham,
                    sp.donVi,
                    sp.soLuongTon,
                    COALESCE(SUM(px.soLuongXuat), 0) AS soLuongXuat,
                    COALESCE(MAX(px.ngayXuat), sp.ngayXuat) AS ngayXuatHienThi
                FROM san_pham sp
                LEFT JOIN phieuxuatthanhpham px ON sp.maSanPham = px.maSanPham
                GROUP BY sp.maSanPham, sp.tenSanPham, sp.donVi, sp.soLuongTon, sp.ngayXuat
                ORDER BY sp.tenSanPham ASC
            ";
        }

        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $types = str_repeat("s", count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function exportCSV($from = null, $to = null) {
        $data = $this->thongKe($from, $to);
        if (!is_dir("exports")) mkdir("exports");

        $file = "exports/thongke_thanhpham_" . date("Ymd_His") . ".csv";
        $fp = fopen($file, "w");

        // Ghi BOM UTF-8 để đọc đúng trong Excel
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));

        // Ghi tiêu đề
        fputcsv($fp, ['STT', 'Mã SP', 'Tên SP', 'Đơn vị', 'Số lượng tồn', 'Số lượng xuất', 'Ngày xuất']);

        $i = 1;
        foreach ($data as $row) {
            fputcsv($fp, [
                $i++,
                $row['maSanPham'],
                $row['tenSanPham'],
                $row['donVi'],
                $row['soLuongTon'],
                $row['soLuongXuat'],
                $row['ngayXuatHienThi']
            ]);
        }

        fclose($fp);
        return $file;
    }
}
