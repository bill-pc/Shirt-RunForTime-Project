<?php
require_once 'ketNoi.php';

class QCModel
{
    private $conn;

    public function __construct()
    {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    public function getDanhSachCanKiemTra()
    {
        $sql = "SELECT 
                    p.maYC, 
                    p.tenSanPham, 
                    p.soLuong AS tongSoLuong,
                    p.tenNguoiLap, 
                    p.ngayLap,
                    p.trangThaiPhieu,
                    kh.tenKHSX
                FROM phieuyeucaukiemtrachatluong p
                LEFT JOIN kehoachsanxuat kh ON p.maKHSX = kh.maKHSX
                WHERE p.trangThaiPhieu IN ('Chờ kiểm tra', 'Chờ duyệt')
                ORDER BY p.maYC DESC";

        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }


    public function getChiTietPhieu($maYC)
    {
        $sql = "SELECT * FROM phieuyeucaukiemtrachatluong WHERE maYC = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maYC);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function capNhatKetQuaQC($maYC, $slDat, $slHong, $ghiChu, $nguoiKiemTra)
    {
        $sql = "UPDATE phieuyeucaukiemtrachatluong 
                SET soLuongDat = ?, 
                    soLuongHong = ?, 
                    ghiChu = ?, 
                    ngayKiemTra = NOW(),
                    trangThaiPhieu = 'Đã duyệt' 
                WHERE maYC = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("iisi", $slDat, $slHong, $ghiChu, $maYC);

        return $stmt->execute();
    }
}
