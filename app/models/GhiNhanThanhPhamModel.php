<?php
// app/models/GhiNhanThanhPhamModel.php
require_once('ketNoi.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class GhiNhanThanhPhamModel
{
    private $conn;

    public function __construct()
    {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    /**
     * Lưu danh sách nhiều dòng cùng lúc và Cập nhật trạng thái Kế hoạch nếu đủ số lượng
     */
   /**
     * Lưu và Chỉ cập nhật trạng thái Hoàn thành khi XƯỞNG MAY làm đủ số lượng
     */
    public function luuDanhSach($header, $details)
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $this->conn->begin_transaction();

        try {
            // ---------------------------------------------------------
            // 1. INSERT SẢN LƯỢNG (Vẫn lưu bình thường cho tất cả bộ phận)
            // ---------------------------------------------------------
            $sql = "INSERT INTO ghinhanthanhphamtheongay 
                    (maNhanVien, maSanPham, soLuongSPHoanThanh, ngayLam, maKHSX) 
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);

            $maNV_bind = 0;
            $maSP_bind = (int) $header['maSanPham'];
            $soLuong_bind = 0;
            $ngayLam_bind = $header['ngayLam'];
            $maKHSX_bind = (int) $header['maKHSX'];

            $stmt->bind_param("iiisi", $maNV_bind, $maSP_bind, $soLuong_bind, $ngayLam_bind, $maKHSX_bind);

            foreach ($details as $item) {
                if (empty($item['maNhanVien']) || !isset($item['soLuong']) || $item['soLuong'] <= 0) {
                    throw new Exception("Dữ liệu chi tiết không hợp lệ");
                }
                $maNV_bind = (int) $item['maNhanVien'];
                $soLuong_bind = (int) $item['soLuong'];
                $stmt->execute();
            }
            $stmt->close();

            // ---------------------------------------------------------
            // 2. TÍNH TỔNG SẢN LƯỢNG (CHỈ TÍNH CỦA XƯỞNG MAY)
            // ---------------------------------------------------------
            // Logic: Join bảng ghinhan với nguoidung để lọc theo phongBan = 'Xưởng may'
            $sqlTongMay = "SELECT COALESCE(SUM(g.soLuongSPHoanThanh), 0) AS tongMay
                           FROM ghinhanthanhphamtheongay g
                           JOIN nguoidung n ON g.maNhanVien = n.maND
                           WHERE g.maKHSX = ? 
                           AND n.phongBan = 'Xưởng may'"; 
            
            // Lưu ý: Chuỗi 'Xưởng may' phải khớp y hệt trong bảng nguoidung của bạn
            
            $stmtTong = $this->conn->prepare($sqlTongMay);
            $stmtTong->bind_param("i", $maKHSX_bind);
            $stmtTong->execute();
            $ketQuaTong = $stmtTong->get_result()->fetch_assoc();
            $tongDaMay = (int) $ketQuaTong['tongMay']; // Tổng này chỉ tính riêng đội may
            $stmtTong->close();

            // ---------------------------------------------------------
            // 3. LẤY MỤC TIÊU TỪ ĐƠN HÀNG
            // ---------------------------------------------------------
            $sqlKH = "SELECT d.soLuongSanXuat 
                      FROM kehoachsanxuat k
                      JOIN donhangsanxuat d ON k.maDonHang = d.maDonHang 
                      WHERE k.maKHSX = ?";
            $stmtKH = $this->conn->prepare($sqlKH);
            $stmtKH->bind_param("i", $maKHSX_bind);
            $stmtKH->execute();
            $resultKH = $stmtKH->get_result()->fetch_assoc();
            $stmtKH->close();

            // ---------------------------------------------------------
            // 4. SO SÁNH (XƯỞNG MAY vs ĐƠN HÀNG) & CẬP NHẬT
            // ---------------------------------------------------------
            if ($resultKH) {
                $soLuongCanLam = (int) $resultKH['soLuongSanXuat'];

                // Nếu Xưởng May làm đủ số lượng -> Hoàn thành
                if ($soLuongCanLam > 0 && $tongDaMay >= $soLuongCanLam) {
                    $sqlUpdate = "UPDATE kehoachsanxuat 
                                  SET trangThai = 'Hoàn thành' 
                                  WHERE maKHSX = ?";
                    $stmtUpdate = $this->conn->prepare($sqlUpdate);
                    $stmtUpdate->bind_param("i", $maKHSX_bind);
                    $stmtUpdate->execute();
                    $stmtUpdate->close();
                }
            }

            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("❌ Lỗi: " . $e->getMessage());
            return $e->getMessage(); 
        }
    }

    // --- CÁC HÀM KHÁC GIỮ NGUYÊN ---

    public function getLichSuGhiNhan($limit = 5)
    {
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
        $sql = "SELECT AVG(soLuongSPHoanThanh) as sanLuongTB FROM ghinhanthanhphamtheongay";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row ? (int) $row['sanLuongTB'] : 0;
    }

    public function getSoLuongTrungBinhTheoXuong($tenXuongKeyword)
    {
        $sql = "SELECT AVG(tong_ngay) as sanLuongTB FROM (
                    SELECT SUM(g.soLuongSPHoanThanh) as tong_ngay
                    FROM ghinhanthanhphamtheongay g
                    JOIN nguoidung nd ON g.maNhanVien = nd.maND
                    WHERE nd.phongBan LIKE ? 
                    GROUP BY g.ngayLam
                    ORDER BY g.ngayLam DESC
                    LIMIT 5
                ) as bang_tam";

        $stmt = $this->conn->prepare($sql);
        $keyword = "%" . $tenXuongKeyword . "%";
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? (int) $row['sanLuongTB'] : 0;
    }
}