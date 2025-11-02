<?php
require_once 'ketNoi.php';

class YeuCauKiemTraChatLuongModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    public function themYeuCauKiemTra($data) {
        try {
            $sql = "INSERT INTO yeucau_kiemtra (maKeHoach, maSanPham, soLuong, xuong, thoiGian, ghiChu)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $data['maKeHoach'],
                $data['maSanPham'],
                $data['soLuong'],
                $data['xuong'],
                $data['thoiGian'],
                $data['ghiChu']
            ]);
        } catch (PDOException $e) {
            error_log("Lỗi thêm yêu cầu kiểm tra: " . $e->getMessage());
            return false;
        }
    }
}
