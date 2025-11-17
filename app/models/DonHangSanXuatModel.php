<?php

require_once 'ketNoi.php';
class DonHangSanXuatModel
{
    private $conn;
    public function __construct()
    {
        // Giả sử tệp ketNoi.php định nghĩa class Database với hàm connect()
        $this->conn = (new KetNoi())->connect();
    }

    public function getAllDonHang()
    {
        $query = $this->conn->prepare('SELECT * FROM donhangsanxuat');
        $query->execute();
        return $query->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function timKiemDonHang($keyWord, $ngayGiao = null, $trangThai = null)
    {
        // Câu SQL cơ bản
        $sql = 'SELECT dh.maDonHang, dh.tenDonHang, dh.ngayGiao, dh.trangThai
                FROM donhangsanxuat dh
                WHERE (dh.maDonHang LIKE ? OR dh.tenDonHang LIKE ?)';

        $types = "ss"; // 2 string cho $searchKeyWord
        $params = [];
        $searchKeyWord = '%' . $keyWord . '%';
        $params[] = &$searchKeyWord;
        $params[] = &$searchKeyWord;

        // Thêm điều kiện lọc ngày giao (nếu có)
        if (!empty($ngayGiao)) {
            $sql .= ' AND dh.ngayGiao = ?';
            $types .= 's';
            $params[] = &$ngayGiao;
        }

        // Thêm điều kiện lọc trạng thái (nếu có)
        if (!empty($trangThai)) {
            $sql .= ' AND dh.trangThai = ?';
            $types .= 's';
            $params[] = &$trangThai;
        }

        $query = $this->conn->prepare($sql);
        $query->bind_param($types, ...$params);
        $query->execute();

        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
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

    public function getRecentDonHang($limit = 10, $ngayGiao = null, $trangThai = null)
    {

        $sql = 'SELECT dh.maDonHang, dh.tenDonHang, dh.ngayGiao, dh.trangThai
                FROM donhangsanxuat dh
                WHERE 1=1'; // Bắt đầu bằng 1=1 để dễ nối chuỗi

        $types = "";
        $params = [];

        // Thêm điều kiện lọc ngày giao (nếu có)
        if (!empty($ngayGiao)) {
            $sql .= ' AND dh.ngayGiao = ?';
            $types .= 's';
            $params[] = &$ngayGiao;
        }

        // Thêm điều kiện lọc trạng thái (nếu có)
        if (!empty($trangThai)) {
            $sql .= ' AND dh.trangThai = ?';
            $types .= 's';
            $params[] = &$trangThai;
        }

        $sql .= ' ORDER BY dh.maDonHang DESC LIMIT ?';
        $types .= "i";
        $params[] = &$limit;

        $query = $this->conn->prepare($sql);
        if (!empty($types)) {
            $query->bind_param($types, ...$params);
        }
        $query->execute();

        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateTrangThai($maDonHang, $trangThai)
    {
        $sql = "UPDATE donhangsanxuat SET trangThai = ? WHERE maDonHang = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception("Lỗi SQL Prepare (updateTrangThai): " . $this->conn->error);
        }
        $stmt->bind_param("si", $trangThai, $maDonHang);
        return $stmt->execute();
    }
}
