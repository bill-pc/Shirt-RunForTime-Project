<?php
include_once 'ketNoi.php';

class ThongKeNVLModel {
    private $conn;

    public function __construct() {
        $db = new KetNoi();
        $this->conn = $db->connect();
    }

    /**
     * Lấy thống kê kho NVL theo khoảng thời gian, tên NVL, loại (nhap/xuat)
     * Sử dụng:
     *  - phieunhapnvl.ngayNhap và phieunhapnvl.soLuongNhap (tổng nhập)
     *  - chitiet_phieuyeucaunhapkhonvl + phieuyeucaunhapkhonvl (nếu bạn lưu nhập ở chi tiết yêu cầu)
     *  - chitiet_phieuyeucaucapnvl + phieuyeucaucungcapnvl (tổng xuất)
     */
    public function layThongKeKhoNVL($start, $end, $tenNVL = '', $loai = '') {
        // Nếu không có ngày thì trả về mảng rỗng (frontend yêu cầu required nên ít khi rơi vào)
        if (empty($start) || empty($end)) {
            return [];
        }

        $query = "
            SELECT 
                nvl.maNVL,
                nvl.tenNVL,
                nvl.donViTinh,
                -- Tổng nhập: cộng 2 nguồn khả dĩ (bảng phiếu nhập + chi tiết yêu cầu nhập)
                COALESCE(nhap1.tongNhapPN, 0) + COALESCE(nhap2.tongNhapCT, 0) AS tongNhap,
                -- Tổng xuất: từ chi tiết yêu cầu cấp (liên kết với phieuyeucaucungcapnvl)
                COALESCE(xuat.tongXuat, 0) AS tongXuat,
                nvl.soLuongTonKho AS tonKho
            FROM nvl
            LEFT JOIN (
                -- Tổng từ bảng phieunhapnvl
                SELECT maNVL, SUM(soLuongNhap) AS tongNhapPN
                FROM phieunhapnvl
                WHERE ngayNhap BETWEEN ? AND ?
                GROUP BY maNVL
            ) AS nhap1 ON nhap1.maNVL = nvl.maNVL
            LEFT JOIN (
                -- Tổng từ chi tiết phieuyeucaunhap (nếu có)
                SELECT c.maNVL, SUM(c.soLuong) AS tongNhapCT
                FROM chitiet_phieuyeucaunhapkhonvl c
                JOIN phieuyeucaunhapkhonvl p ON p.maYCNK = c.maYCNK
                WHERE p.ngayLap BETWEEN ? AND ?
                GROUP BY c.maNVL
            ) AS nhap2 ON nhap2.maNVL = nvl.maNVL
            LEFT JOIN (
                -- Tổng xuất từ chi tiết phieuyeucaucapnvl (chitiet_phieuyeucaucapnvl) liên kết phieuyeucaucungcapnvl
                SELECT c.maNVL, SUM(c.soLuong) AS tongXuat
                FROM chitiet_phieuyeucaucapnvl c
                JOIN phieuyeucaucungcapnvl p ON p.maYCCC = c.maYCCC
                WHERE p.ngayLap BETWEEN ? AND ?
                GROUP BY c.maNVL
            ) AS xuat ON xuat.maNVL = nvl.maNVL
            WHERE 1=1
        ";

        // 3 subquery * 2 params = 6 params (start,end)
        $types = "ssssss";
        $params = [$start, $end, $start, $end, $start, $end];

        // Lọc theo tên NVL nếu cần
        if (!empty($tenNVL)) {
            $query .= " AND nvl.tenNVL LIKE ?";
            $types .= "s";
            $params[] = "%{$tenNVL}%";
        }

        // Group by các cột cần thiết
        $query .= " GROUP BY nvl.maNVL, nvl.tenNVL, nvl.donViTinh, nvl.soLuongTonKho";

        // Lọc theo loại báo cáo (nhập/xuất)
        if ($loai === 'nhap') {
            $query .= " HAVING (COALESCE(tongNhap,0)) > 0";
        } elseif ($loai === 'xuat') {
            $query .= " HAVING (COALESCE(tongXuat,0)) > 0";
        }

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            // Debug dễ thấy lỗi prepare + SQL
            die('❌ Lỗi prepare: ' . $this->conn->error . "<br>⚠️ SQL: " . $query);
        }

        $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) {
            die('❌ Lỗi execute: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            // đảm bảo kiểu số là number (nếu cần frontend tính toán)
            $row['tongNhap'] = (int)$row['tongNhap'];
            $row['tongXuat'] = (int)$row['tongXuat'];
            $row['tonKho'] = (int)$row['tonKho'];
            $data[] = $row;
        }

        $stmt->close();
        return $data;
    }

    // Xuất CSV toàn bộ NVL
    public function layTatCaKhoNVL() {
        $sql = "SELECT maNVL, tenNVL, donViTinh, soLuongTonKho AS tonKho FROM nvl";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
?>
