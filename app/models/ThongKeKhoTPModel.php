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
                COALESCE(nk.soLuongNhap, 0) AS soLuongNhap,
                COALESCE(px.soLuongXuat, 0) AS soLuongXuat,
                (COALESCE(nk.soLuongNhap, 0) - COALESCE(px.soLuongXuat, 0)) AS tonCuoi
            FROM san_pham sp

            LEFT JOIN (
                SELECT c.maSanPham, SUM(c.soLuongDat) AS soLuongNhap
                FROM chitietphieuyeucaukiemtrachatluong c
                JOIN nhapkhotp n ON c.maYC = n.maYC
                GROUP BY c.maSanPham
            ) nk ON sp.maSanPham = nk.maSanPham

            LEFT JOIN (
                SELECT maSanPham, SUM(soLuongXuat) AS soLuongXuat
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

        fputcsv($fp, ['Mã SP', 'Tên SP', 'Đơn vị', 'Số lượng nhập', 'Số lượng xuất', 'Tồn cuối']);

        foreach ($data as $row) {
            fputcsv($fp, [
                $row['maSanPham'],
                $row['tenSanPham'],
                $row['donVi'],
                $row['soLuongNhap'],
                $row['soLuongXuat'],
                $row['tonCuoi']
            ]);
        }

        fclose($fp);
        exit;
    }
}
