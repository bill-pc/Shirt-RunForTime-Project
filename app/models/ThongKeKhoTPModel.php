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

                -- TỔNG NHẬP: lấy từ chitiet_nhapkhotp.soLuong
                COALESCE(nk.tongNhap, 0) AS tongNhap,

                -- TỔNG XUẤT
                COALESCE(px.tongXuat, 0) AS tongXuat,

                -- TỒN KHO THỰC TẾ
                sp.soLuongTon AS tonKho

            FROM san_pham sp

            -- JOIN TỔNG NHẬP
            LEFT JOIN (
                SELECT maSanPham, SUM(soLuong) AS tongNhap
                FROM chitiet_nhapkhotp
                GROUP BY maSanPham
            ) nk ON sp.maSanPham = nk.maSanPham

            -- JOIN TỔNG XUẤT
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

        // BOM UTF-8 cho Excel
        echo chr(0xEF).chr(0xBB).chr(0xBF);

        $fp = fopen("php://output", "w");

        fputcsv($fp, ['Mã SP', 'Tên SP', 'Đơn vị', 'Tổng nhập', 'Tổng xuất', 'Tồn kho']);

        foreach ($data as $row) {
            fputcsv($fp, [
                $row['maSanPham'],
                $row['tenSanPham'],
                $row['donVi'],
                $row['tongNhap'],
                $row['tongXuat'],
                $row['tonKho']
            ]);
        }

        fclose($fp);
        exit;
    }
}
