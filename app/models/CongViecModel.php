<?php
require_once __DIR__ . '/ketnoi.php';

class CongViecModel {
    private $conn;

    public function __construct() {
        $database = new KetNoi(); // ✅ Tên class bạn đang dùng
        $this->conn = $database->connect();
    }

    // ✅ Lấy danh sách kế hoạch sản xuất đã duyệt
    public function getApprovedPlans() {
        $sql = "SELECT 
                    maKHSX, 
                    tenKHSX, 
                    thoiGianBatDau, 
                    thoiGianKetThuc
                FROM kehoachsanxuat
                WHERE trangThai = 'Đã duyệt'
                ORDER BY maKHSX DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->get_result();
        $plans = [];
        while ($row = $result->fetch_assoc()) {
            $plans[] = $row;
        }

        return $plans;
    }

    // ✅ Lấy chi tiết kế hoạch theo ID
    public function getPlanById($id) {
        $sql = "SELECT 
                    maKHSX, 
                    tenKHSX, 
                    thoiGianBatDau, 
                    thoiGianKetThuc
                FROM kehoachsanxuat
                WHERE maKHSX = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ✅ Lấy danh sách công việc theo kế hoạch
    public function getTasksByPlanId($maKHSX) {
        $sql = "SELECT 
                    cv.tieuDe,
                    cv.moTa,
                    x.tenXuong,
                    cv.trangThai,
                    cv.ngayHetHan
                FROM congviec cv
                JOIN kehoachsanxuat ct ON cv.maKHSX = ct.maKHSX
                JOIN xuong x ON cv.maXuong = x.maXuong
                WHERE ct.maKHSX = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maKHSX);
        $stmt->execute();

        $result = $stmt->get_result();
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }

        return $tasks;
    }
}
?>