<?php
require_once 'ketNoi.php'; // Đảm bảo trùng tên file bạn đang dùng

class CongViecModel {
    private $conn;

    public function __construct() {
        $database = new KetNoi();
        $this->conn = $database->connect(); // Kết nối mysqli
    }

    // ✅ Lấy tất cả công việc
    public function getAll() {
        $sql = "SELECT * FROM congviec ORDER BY maCongViec DESC";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // ✅ Lấy 1 công việc theo mã
    public function getById($maCongViec) {
        $sql = "SELECT * FROM congviec WHERE maCongViec = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maCongViec);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ✅ Thêm công việc mới
    public function insert($data) {
        $sql = "INSERT INTO congviec (tieuDe, moTa, trangThai, ngayHetHan)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssss",
            $data['tieuDe'],
            $data['moTa'],
            $data['trangThai'],
            $data['ngayHetHan']
        );
        return $stmt->execute();
    }

    // ✅ Cập nhật công việc
    public function update($data) {
        $sql = "UPDATE congviec 
                SET tieuDe = ?, moTa = ?, trangThai = ?, ngayHetHan = ?
                WHERE maCongViec = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssssi",
            $data['tieuDe'],
            $data['moTa'],
            $data['trangThai'],
            $data['ngayHetHan'],
            $data['maCongViec']
        );
        return $stmt->execute();
    }

    // ✅ Xóa công việc
    public function delete($maCongViec) {
        $sql = "DELETE FROM congviec WHERE maCongViec = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maCongViec);
        return $stmt->execute();
    }
}
?>
