<?php
class DanhMucModel {
    public function getDanhMuc() {
        return array(
            "tongquan" => array("Đăng nhập", "Đăng xuất", "Thông tin cá nhân", "Báo cáo tổng hợp"),
            "nhansu" => array("Thêm nhân viên", "Xem nhân viên", "Xóa nhân viên", "Sửa nhân viên"),
            "sanxuat" => array("Tạo đơn hàng sản xuất", "Lập kế hoạch sản xuất", "Duyệt kế hoạch sản xuất"),
            "khoNVL" => array("Tạo yêu cầu nhập NVL", "Nhập kho NVL", "Xuất NVL", "Thống kê kho NVL"),
            "xuong" => array("Xem công việc", "Theo dõi tiến độ", "Yêu cầu NVL", "Yêu cầu kiểm tra chất lượng"),
            "qc" => array("Cập nhật thành phẩm", "Báo cáo chất lượng"),
            "khoTP" => array("Nhập kho TP", "Xuất kho TP", "Thống kê kho TP"),
            "congnhan" => array("Lịch làm việc", "Báo cáo sự cố")
        );
    }
}
?>
