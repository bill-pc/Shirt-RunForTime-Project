<?php
require_once 'ketNoi.php';

class XoaNhanVienModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // ✅ Lấy tất cả nhân viên đang hoạt động (chưa xóa)
    public function getAll() {
        $stmt = $this->conn->query("SELECT maND, hoTen, chucVu, phongBan, diaChi, email, soDienThoai 
                                    FROM nguoidung 
                                    WHERE trangThai = 1
                                    ORDER BY maND ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Lấy nhân viên theo ID
    public function getById($maNV) {
        $stmt = $this->conn->prepare("SELECT * FROM nguoidung WHERE maND = ?");
        $stmt->execute([$maNV]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Xóa mềm nhân viên (ẩn khỏi giao diện, vẫn còn trong DB)
    public function deleteById($maNV) {
        $stmt = $this->conn->prepare("UPDATE nguoidung SET trangThai = 0 WHERE maND = ?");
        return $stmt->execute([$maNV]);
    }

    // (Tuỳ chọn) ✅ Lấy danh sách nhân viên đã bị xóa
    public function getDeleted() {
        $stmt = $this->conn->query("SELECT * FROM nguoidung WHERE trangThai = 0");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // (Tuỳ chọn) ✅ Khôi phục nhân viên
    public function restoreById($maNV) {
        $stmt = $this->conn->prepare("UPDATE nguoidung SET trangThai = 1 WHERE maND = ?");
        return $stmt->execute([$maNV]);
    }
    public function search($keyword) {
    $stmt = $this->conn->prepare("
        SELECT maND, hoTen, chucVu, phongBan, diaChi, email, soDienThoai
        FROM nguoidung
        WHERE trangThai = 1 
        AND (hoTen LIKE ? OR chucVu LIKE ? OR phongBan LIKE ? OR email LIKE ?)
        ORDER BY maND ASC
    ");
    $stmt->execute(["%$keyword%", "%$keyword%", "%$keyword%", "%$keyword%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
?>
