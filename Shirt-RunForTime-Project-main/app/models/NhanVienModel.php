<?php
require_once 'ketNoi.php';

class NhanVienModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    /**
     * 🟢 Thêm nhân viên mới vào bảng nguoidung
     */
    public function insert($data) {
        $sql = "INSERT INTO nguoidung (hoTen, chucVu, soDienThoai, email, diaChi, maTK)
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("❌ Lỗi prepare: " . $this->conn->error);
        }

        $hoTen = trim($data['hoTen'] ?? '');
        $chucVu = trim($data['chucVu'] ?? '');
        $soDienThoai = trim($data['soDienThoai'] ?? '');
        $email = trim($data['email'] ?? '');
        $diaChi = trim($data['diaChi'] ?? '');
        $maTK = (int)($data['maTK'] ?? 1);

        $stmt->bind_param("sssssi", $hoTen, $chucVu, $soDienThoai, $email, $diaChi, $maTK);
        $result = $stmt->execute();

        if (!$result) {
            error_log("❌ Lỗi khi thêm nhân viên: " . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    /**
     * 🟡 Kiểm tra trùng email hoặc số điện thoại
     */
    public function checkDuplicate($email, $soDienThoai) {
        $sql = "SELECT COUNT(*) AS total FROM nguoidung WHERE email = ? OR soDienThoai = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("❌ Lỗi prepare: " . $this->conn->error);
        }

        $stmt->bind_param("ss", $email, $soDienThoai);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result['total'] > 0;
    }

    /**
     * 🟢 Lấy tất cả nhân viên
     */
    public function getAll() {
        $sql = "SELECT * FROM nguoidung";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("❌ Lỗi truy vấn: " . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * 🟢 Lấy thông tin nhân viên theo ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM nguoidung WHERE maND = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("❌ Lỗi prepare: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result;
    }

    // public function getNhanVienByPhongBan($tenPhongBan) {
    //     $sql = "SELECT maND, hoTen, chucVu 
    //             FROM nguoidung 
    //             WHERE trangThai = 1 AND phongBan = ?
    //             ORDER BY hoTen";
        
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->bind_param("s", $tenPhongBan);
    //     $stmt->execute();
        
    //     $result = $stmt->get_result();
    //     return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    // }

    public function getNhanVienSanXuat() {
        $sql = "SELECT maND, hoTen, phongBan 
                FROM nguoidung 
                WHERE trangThai = 1 AND phongBan LIKE 'Xưởng%'
                ORDER BY hoTen";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getXuongCuaNhanVien($maND) {
        $sql = "SELECT phongBan FROM nguoidung WHERE maND = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;
        $stmt->bind_param("i", $maND);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data; 
    }

    
    public function getNhanVienTheoPhongBan($phongBan) {
        $sql = "SELECT maND, hoTen FROM nguoidung WHERE phongBan = ? AND trangThai = 1";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return [];
        $stmt->bind_param("s", $phongBan);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data; 
    }

}
?>
