<?php
require_once 'ketNoi.php';

class NhapKhoTP_DaCheckQCModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    /**
     * Lấy danh sách phiếu kiểm tra chất lượng đã đạt
     */
    public function getDanhSachPhieuQCDaDat() {
        // Lấy các phiếu đã duyệt (trangThaiPhieu = 'Đã duyệt' là đã đạt)
        $sql = "SELECT 
                    p.maYC AS maPhieu,
                    CONCAT(sp.maSanPham, ' - ', sp.tenSanPham) AS sanPham,
                    CONCAT('LOT', LPAD(p.maYC, 3, '0')) AS maLo,
                    p.soLuong,
                    CURDATE() AS ngayKiemTra,
                    p.maSanPham
                FROM phieuyeucaukiemtrachatluong p
                INNER JOIN san_pham sp ON p.maSanPham = sp.maSanPham
                WHERE p.trangThaiPhieu = 'Đã duyệt'
                    AND (p.trangThaiPhieu != 'Đã nhập kho' OR p.trangThaiPhieu IS NULL)
                ORDER BY p.maYC DESC";
        
        $result = $this->conn->query($sql);
        
        if (!$result) {
            error_log("Lỗi truy vấn danh sách phiếu QC: " . $this->conn->error);
            return [];
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Lấy chi tiết phiếu kiểm tra chất lượng theo mã phiếu
     */
    public function getChiTietPhieuQC($maPhieu) {
        $sql = "SELECT 
                    p.maYC AS maPhieu,
                    CONCAT(sp.maSanPham, ' - ', sp.tenSanPham) AS sanPham,
                    CONCAT('LOT', LPAD(p.maYC, 3, '0')) AS maLo,
                    p.soLuong,
                    CURDATE() AS ngayKiemTra,
                    p.maSanPham,
                    p.tenNguoiLap
                FROM phieuyeucaukiemtrachatluong p
                INNER JOIN san_pham sp ON p.maSanPham = sp.maSanPham
                WHERE p.maYC = ? AND p.trangThaiPhieu = 'Đã duyệt'";
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Lỗi chuẩn bị truy vấn chi tiết phiếu QC: " . $this->conn->error);
            return null;
        }

        $stmt->bind_param("i", $maPhieu);
        
        if (!$stmt->execute()) {
            error_log("Lỗi thực thi truy vấn chi tiết phiếu QC: " . $stmt->error);
            $stmt->close();
            return null;
        }

        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        return $data;
    }

    /**
     * Nhập kho thành phẩm từ phiếu QC đã đạt
     */
    public function nhapKhoThanhPham($maPhieu, $maSanPham, $soLuong) {
        // Bắt đầu transaction
        $this->conn->begin_transaction();

        try {
            // 1. Cập nhật số lượng tồn kho trong bảng san_pham
            $sql1 = "UPDATE san_pham 
                    SET soLuongTon = soLuongTon + ? 
                    WHERE maSanPham = ?";
            
            $stmt1 = $this->conn->prepare($sql1);
            
            if (!$stmt1) {
                throw new Exception("Lỗi chuẩn bị câu lệnh cập nhật kho: " . $this->conn->error);
            }

            $stmt1->bind_param("ii", $soLuong, $maSanPham);
            
            if (!$stmt1->execute()) {
                throw new Exception("Lỗi cập nhật kho: " . $stmt1->error);
            }
            
            $stmt1->close();

            // 2. Cập nhật trạng thái phiếu QC thành "Đã nhập kho" (nếu có)
            // Hoặc có thể thêm vào bảng phiếu nhập kho thành phẩm nếu có
            $sql2 = "UPDATE phieuyeucaukiemtrachatluong 
                    SET trangThaiPhieu = 'Đã nhập kho' 
                    WHERE maYC = ?";
            
            $stmt2 = $this->conn->prepare($sql2);
            
            if ($stmt2) {
                $stmt2->bind_param("i", $maPhieu);
                $stmt2->execute();
                $stmt2->close();
            }

            // Commit transaction
            $this->conn->commit();
            
            return true;

        } catch (Exception $e) {
            // Rollback nếu có lỗi
            $this->conn->rollback();
            error_log("Lỗi nhập kho thành phẩm: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Kiểm tra phiếu đã được nhập kho chưa
     */
    public function kiemTraPhieuDaNhapKho($maPhieu) {
        $sql = "SELECT trangThaiPhieu 
                FROM phieuyeucaukiemtrachatluong 
                WHERE maYC = ?";
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("i", $maPhieu);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        return isset($data['trangThaiPhieu']) && $data['trangThaiPhieu'] === 'Đã nhập kho';
    }
}
?>

