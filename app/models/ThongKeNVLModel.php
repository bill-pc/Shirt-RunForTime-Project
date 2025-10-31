<?php
include_once 'ketNoi.php';

class ThongKeNVLModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    // ✅ Lấy thống kê kho NVL (gộp nhập, xuất, và tồn kho hiện có trong bảng nvl)
    public function layThongKeKhoNVL($start, $end, $tenNVL = '', $loai = '') {
        $query = "
            SELECT 
                nvl.maNVL,
                nvl.tenNVL,
                nvl.donViTinh,
                COALESCE(nhap.tongNhap, 0) AS tongNhap,
                COALESCE(xuat.tongXuat, 0) AS tongXuat,
                nvl.soLuongTonKho AS tonKho
            FROM nvl
            LEFT JOIN (
                SELECT maNVL, SUM(soLuongNhap) AS tongNhap
                FROM phieunhapnvl
                WHERE ngayNhap BETWEEN ? AND ?
                GROUP BY maNVL
            ) AS nhap ON nhap.maNVL = nvl.maNVL
            LEFT JOIN (
                SELECT maNVL, SUM(soLuongXuat) AS tongXuat
                FROM phieuxuatnvl
                WHERE ngayLap BETWEEN ? AND ?
                GROUP BY maNVL
            ) AS xuat ON xuat.maNVL = nvl.maNVL
            WHERE 1=1
        ";

        $types = "ssss";
        $params = [$start, $end, $start, $end];

        // ✅ Lọc theo tên NVL nếu có
        if (!empty($tenNVL)) {
            $query .= " AND nvl.tenNVL LIKE ?";
            $types .= "s";
            $params[] = "%{$tenNVL}%";
        }

        $query .= " GROUP BY nvl.maNVL, nvl.tenNVL, nvl.donViTinh, nvl.soLuongTonKho";

        // ✅ Lọc theo loại phiếu (nếu người dùng chọn)
        if ($loai === 'nhap') {
            $query .= " HAVING tongNhap > 0";
        } elseif ($loai === 'xuat') {
            $query .= " HAVING tongXuat > 0";
        }

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("❌ Lỗi prepare: " . $this->conn->error . "<br>⚠️ SQL: " . $query);
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $stmt->close();
        return $data;
    }

    // ✅ Xuất toàn bộ dữ liệu NVL (phục vụ CSV)
    public function layTatCaKhoNVL() {
        $sql = "
            SELECT 
                maNVL, tenNVL, donViTinh, soLuongTonKho AS tonKho
            FROM nvl
        ";

        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
?>
