<?php

require_once 'ketNoi.php';
class DonHangSanXuatModel
{
    private $conn;

    public function __construct($db_connection) {
        
        if ($db_connection) {
            $this->conn = $db_connection;
        } else {
            die("Lỗi: Model không nhận được kết nối CSDL.");
        }
    }

    public function getAllDonHang()
    {
        $query = $this->conn->prepare('SELECT * FROM donhangsanxuat');
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function timKiemDonHang($keyWord)
    {
        $sql = 'SELECT dh.maDonHang, dh.tenDonHang, dh.ngayGiao, dh.trangThai
                FROM donhangsanxuat dh
                WHERE dh.maDonHang LIKE ? or dh.tenDonHang LIKE ?';
        $query = $this->conn->prepare($sql);
        $searchKeyWord = '%' . $keyWord . '%';
        $query->bind_param('ss', $searchKeyWord, $searchKeyWord);
        $query->execute();

        $result = $query->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        return $data;
    }

    public function getChiTietDonHang($id)
    {
        $sql = 'SELECT dh.*, sp.tenSanPham
                FROM donhangsanxuat dh
                JOIN san_pham sp ON dh.maSanPham = sp.maSanPham
                WHERE dh.maDonHang = ?';
        $query = $this->conn->prepare($sql);
        $query->bind_param('i', $id);
        $query->execute();

        $result = $query->get_result();
        return $result->fetch_assoc();
    }

    public function getRecentDonHang($limit = 10) {
        $sql = 'SELECT dh.maDonHang, dh.tenDonHang, dh.ngayGiao, dh.trangThai
                FROM donhangsanxuat dh
                ORDER BY dh.maDonHang DESC 
                LIMIT ?'; 
        
        $query = $this->conn->prepare($sql);
        $query->bind_param("i", $limit); 
        $query->execute();
        
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
