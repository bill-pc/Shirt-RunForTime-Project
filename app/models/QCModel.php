<?php
// app/models/QCModel.php

class QCModel {
    private $conn;

    public function __construct() {
        // Giả sử tệp ketNoi.php định nghĩa class Database với hàm connect()
        $this->conn = (new KetNoi())->connect();
    }

    
    public function getAllYCCL() {
        // Giả sử trạng thái chờ là 'Chờ duyệt'
        $sql = "SELECT 
                    pyc.maYC, 
                    pyc.soLuong,
                    pyc.tenNguoiLap,
                    sp.maSanPham,
                    sp.tenSanPham
                FROM phieuyeucaukiemtrachatluong pyc
                JOIN san_pham sp ON pyc.maSanPham = sp.maSanPham
                WHERE pyc.trangThaiPhieu = 'Chờ duyệt'";
        
        $query = $this->conn->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    
    public function updateYCCL($maYC, $soLuongDat, $soLuongHong) {
        $sql = "UPDATE phieuyeucaukiemtrachatluong 
                SET 
                    trangThaiPhieu = 'Đã kiểm tra'
                    -- (Bạn có thể thêm cột 'ghiChu' để lưu kết quả nếu muốn)
                    -- ghiChu = CONCAT('Kết quả: Đạt ', ?, ', Hỏng ', ?)
                WHERE maYC = ?";
        
        $stmt = $this->conn->prepare($sql);
        // $stmt->bind_param("iii", $soLuongDat, $soLuongHong, $maYC);
        $stmt->bind_param("i", $maYC); // Chỉ cập nhật trạng thái
        return $stmt->execute();
    }
}
?>