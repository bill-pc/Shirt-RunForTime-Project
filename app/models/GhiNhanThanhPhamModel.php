<?php
// app/models/GhiNhanThanhPhamModel.php
require_once('ketNoi.php');

class GhiNhanThanhPhamModel
{
    private $conn;

    public function __construct()
    {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    /**
     * Lưu danh sách nhiều dòng cùng lúc (Batch Insert)
     */
    public function luuDanhSach($header, $details)
    {
        $this->conn->begin_transaction();
        try {
            $sql = "INSERT INTO ghinhanthanhphamtheongay 
                    (maKHSX, maSanPham, maNhanVien, soLuongSPHoanThanh, ngayLam)
                    VALUES (?, ?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);

            foreach ($details as $item) {
                $stmt->bind_param(
                    "iiiis",
                    $header['maKHSX'],
                    $header['maSanPham'],
                    $item['maNhanVien'],
                    $item['soLuong'],
                    $header['ngayLam']
                );
                $stmt->execute();
            }

            $stmt->close();
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Lỗi lưu danh sách TP: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Lấy lịch sử 5 ngày gần nhất (Gộp theo Ngày & Kế hoạch)
     */
    public function getLichSuGhiNhan($limit = 5)
    {
        // Lưu ý: Đã fix lỗi GROUP BY
        $sql = "SELECT 
                    g.ngayLam,
                    g.maKHSX,
                    k.tenKHSX,
                    s.tenSanPham,
                    SUM(g.soLuongSPHoanThanh) as tongSoLuong,
                    COUNT(g.maNhanVien) as soNhanVien
                FROM ghinhanthanhphamtheongay g
                LEFT JOIN kehoachsanxuat k ON g.maKHSX = k.maKHSX
                LEFT JOIN san_pham s ON g.maSanPham = s.maSanPham
                GROUP BY g.ngayLam, g.maKHSX, k.tenKHSX, s.tenSanPham
                ORDER BY g.ngayLam DESC, g.maKHSX DESC
                LIMIT ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Lấy chi tiết nhân viên trong 1 phiếu gộp
     */
    public function getChiTietPhieu($ngayLam, $maKHSX)
    {
        $sql = "SELECT 
                    n.hoTen,
                    n.phongBan,
                    g.soLuongSPHoanThanh
                FROM ghinhanthanhphamtheongay g
                JOIN nguoidung n ON g.maNhanVien = n.maND
                WHERE g.ngayLam = ? AND g.maKHSX = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $ngayLam, $maKHSX);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getSoLuongTrungBinh()
    {
        $sql = "SELECT 
                    AVG(soLuongSPHoanThanh) as sanLuongTB
                FROM ghinhanthanhphamtheongay";

        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row ? (int)$row['sanLuongTB'] : 0;
    }
}
