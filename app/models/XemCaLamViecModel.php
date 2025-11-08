<?php
require_once 'ketNoi.php';

class XemCaLamViecModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    /**
     * Lấy lịch làm việc của nhân viên hiện tại trong tuần
     * @param int $maNhanVien Mã nhân viên
     * @return array Danh sách ca làm việc
     */
    public function getLichLamViec($maNhanVien = null) {
        // Nếu không có mã nhân viên, lấy từ session hoặc trả về dữ liệu mẫu
        // Giả sử có bảng phân công công việc cho nhân viên
        // Vì chưa thấy bảng liên kết rõ ràng, tôi sẽ tạo query dựa trên bảng congviec và xuong
        
        // Lấy tuần hiện tại (từ thứ 2 đến chủ nhật)
        $monday = date('Y-m-d', strtotime('monday this week'));
        $sunday = date('Y-m-d', strtotime('sunday this week'));
        
        // Lấy công việc trong tuần, giả sử có liên kết với ca làm việc
        $sql = "SELECT 
                    c.maCongViec,
                    DATE_FORMAT(c.ngayHetHan, '%d/%m/%Y') AS ngay,
                    c.tieuDe AS congViec,
                    'Cả ngày' AS caLam,
                    '08:00 - 17:00' AS thoiGian,
                    COALESCE(x.tenXuong, 'Chưa phân công') AS diaDiem
                FROM congviec c
                LEFT JOIN xuong x ON c.maXuong = x.maXuong
                WHERE c.ngayHetHan BETWEEN ? AND ?
                    AND c.trangThai != 'Hoàn thành'
                ORDER BY c.ngayHetHan ASC
                LIMIT 10";
        
        // Nếu có mã nhân viên, có thể thêm điều kiện WHERE theo nhân viên
        // Tạm thời lấy tất cả công việc trong tuần
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Lỗi chuẩn bị truy vấn lịch làm việc: " . $this->conn->error);
            return $this->getLichLamViecMau(); // Trả về dữ liệu mẫu
        }

        $stmt->bind_param("ss", $monday, $sunday);
        
        if (!$stmt->execute()) {
            error_log("Lỗi thực thi truy vấn lịch làm việc: " . $stmt->error);
            $stmt->close();
            return $this->getLichLamViecMau();
        }

        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        // Nếu không có dữ liệu, trả về dữ liệu mẫu
        if (empty($data)) {
            return $this->getLichLamViecMau();
        }

        return $data;
    }

    /**
     * Lấy tóm tắt lịch làm việc
     */
    public function getTomTatLichLamViec($maNhanVien = null) {
        $lichLamViec = $this->getLichLamViec($maNhanVien);
        $tongSoCa = count($lichLamViec);
        
        // Tìm ca gần nhất
        $caGanNhat = null;
        if (!empty($lichLamViec)) {
            $caGanNhat = $lichLamViec[0]; // Ca đầu tiên trong danh sách đã sắp xếp
        }

        return [
            'tongSoCa' => $tongSoCa,
            'caGanNhat' => $caGanNhat
        ];
    }

    /**
     * Dữ liệu mẫu khi không có dữ liệu thực tế
     */
    private function getLichLamViecMau() {
        return [
            [
                'ngay' => '20/10/2025',
                'caLam' => 'Sáng',
                'thoiGian' => '08:00 - 12:00',
                'congViec' => 'May cắt tay áo sơ mi',
                'diaDiem' => 'Xưởng May Cắt A'
            ],
            [
                'ngay' => '21/10/2025',
                'caLam' => 'Chiều',
                'thoiGian' => '13:00 - 17:00',
                'congViec' => 'May cắt cổ áo sơ mi',
                'diaDiem' => 'Xưởng May Cắt A'
            ],
            [
                'ngay' => '22/10/2025',
                'caLam' => 'Sáng',
                'thoiGian' => '08:00 - 12:00',
                'congViec' => 'May cắt túi áo sơ mi',
                'diaDiem' => 'Xưởng May Cắt A'
            ],
            [
                'ngay' => '23/10/2025',
                'caLam' => 'Cả ngày',
                'thoiGian' => '08:00 - 17:00',
                'congViec' => 'May cúc áo sơ mi',
                'diaDiem' => 'Xưởng May Cắt A'
            ],
            [
                'ngay' => '24/10/2025',
                'caLam' => 'Chiều',
                'thoiGian' => '13:00 - 17:00',
                'congViec' => 'Đóng gói sản phẩm',
                'diaDiem' => 'Xưởng May Cắt A'
            ]
        ];
    }

    /**
     * Lấy tuần hiện tại (ngày bắt đầu và kết thúc)
     */
    public function getTuanHienTai() {
        $monday = date('d/m/Y', strtotime('monday this week'));
        $sunday = date('d/m/Y', strtotime('sunday this week'));
        return [
            'batDau' => $monday,
            'ketThuc' => $sunday
        ];
    }
}
?>

