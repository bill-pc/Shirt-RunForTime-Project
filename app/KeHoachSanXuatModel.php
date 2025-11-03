<?php
// Đường dẫn đúng từ /app/models/
require_once 'ketNoi.php';

class KeHoachSanXuatModel
{
    // Dùng khoảng trắng thường để thụt lề
    private $conn;

    public function __construct($db_connection)
    {
        if ($db_connection) {
            $this->conn = $db_connection;
        } else {
            die("Lỗi: Model không nhận được kết nối CSDL.");
        }
    }

    /* === SỬA HÀM NÀY ĐỂ LỌC KHSX ĐÃ YÊU CẦU NVL === */
    public function getAllPlans()
    {
        $sql = "SELECT
                    kh.maKHSX,
                    kh.tenKHSX,
                    kh.thoiGianBatDau,
                    kh.thoiGianKetThuc,      -- <-- THÊM CỘT NÀY
                    nd.hoTen AS tenNguoiTao  -- <-- THÊM CỘT NÀY (lấy từ bảng nguoidung)
                FROM
                    kehoachsanxuat kh
                LEFT JOIN                       -- Giữ LEFT JOIN để lọc KHSX chưa có phiếu
                    phieuyeucaucungcapnvl pyc ON kh.maKHSX = pyc.maKHSX
                JOIN                            -- Thêm JOIN để lấy tên người tạo
                    nguoidung nd ON kh.maND = nd.maND
                WHERE
                    kh.trangThai = 'Đã duyệt'
                    AND pyc.maYCCC IS NULL";

        $result = $this->conn->query($sql);
        if (!$result) {
            error_log("Lỗi truy vấn KHSX chưa yêu cầu NVL (chi tiết): " . $this->conn->error);
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    /* === KẾT THÚC SỬA === */
    public function getAllPlansAdmin()
    {
        $sql = "SELECT kh.maKHSX, kh.tenKHSX, kh.thoiGianBatDau, kh.trangThai, nd.hoTen AS tenNguoiLap
                FROM kehoachsanxuat kh
                JOIN nguoidung nd ON kh.maND = nd.maND
                ORDER BY kh.maKHSX DESC";

        $result = $this->conn->query($sql);
        if (!$result) {
            error_log("Lỗi truy vấn tất cả KHSX cho admin: " . $this->conn->error);
            return [];
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPlanById($maKHSX)
    {
        // === THÊM thoiGianKetThuc VÀO ĐÂY ===
        $sql = "SELECT kh.tenKHSX, kh.thoiGianKetThuc, nd.hoTen AS tenNguoiLap
                FROM kehoachsanxuat kh
                JOIN nguoidung nd ON kh.maND = nd.maND
                WHERE kh.maKHSX = ?";
        // ===================================

        $stmt = $this->conn->prepare($sql);
        // ... (phần còn lại của hàm giữ nguyên) ...
        if (!$stmt) {
            error_log("Lỗi chuẩn bị truy vấn KHSX ID: " . $this->conn->error);
            return null;
        }
        $stmt->bind_param("i", $maKHSX);
        if (!$stmt->execute()) {
            error_log("Lỗi thực thi truy vấn KHSX ID: " . $stmt->error);
            $stmt->close();
            return null;
        }
        $result = $stmt->get_result();
        if (!$result) {
            error_log("Lỗi lấy kết quả KHSX ID: " . $stmt->error);
            $stmt->close();
            return null;
        }
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data;
    }

    // Hàm getMaterialsForPlan đã lấy loaiNVL rồi, cần thêm donViTinh
    public function getMaterialsForPlan($maKHSX)
    {
        $sql = "SELECT
                    ct.maNVL,
                    nvl.tenNVL,
                    nvl.loaiNVL,
                    nvl.donViTinh, -- <-- THÊM CỘT NÀY TỪ BẢNG NVL
                    ct.soLuongNVL
                FROM
                    chitietkehoachsanxuat ct
                JOIN
                    NVL nvl ON ct.maNVL = nvl.maNVL
                WHERE
                    ct.maKHSX = ?";
        // ... (phần còn lại của hàm giữ nguyên) ...
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Lỗi chuẩn bị truy vấn NVL cho KHSX: " . $this->conn->error);
            return [];
        }
        $stmt->bind_param("i", $maKHSX);
        if (!$stmt->execute()) {
            error_log("Lỗi thực thi truy vấn NVL cho KHSX: " . $stmt->error);
            $stmt->close();
            return [];
        }
        $result = $stmt->get_result();
        if (!$result) {
            error_log("Lỗi lấy kết quả NVL cho KHSX: " . $stmt->error);
            $stmt->close();
            return [];
        }
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $data;
    }

    public function createKHSX($data) {
    $sql = "INSERT INTO kehoachsanxuat (tenKHSX, maDHSX, thoiGianBatDau, thoiGianKetThuc, trangThai, maND)
            VALUES (?, ?, ?, ?, 'Chờ duyệt', ?)";
    
    $stmt = $this->conn->prepare($sql);
    
    // Kiểm tra lỗi Prepare (nếu SQL sai)
    if ($stmt === false) {
        // Ném lỗi nếu SQL có vấn đề
        throw new Exception("Lỗi SQL Prepare: " . $this->conn->error);
    }

    $stmt->bind_param("sissi", 
        $data['tenKHSX'],       
        $data['maDHSX'],        
        $data['thoiGianBatDau'],
        $data['thoiGianKetThuc'],
        $data['maND']           
    );
    
    // THÊM KIỂM TRA EXECUTE()
    if ($stmt->execute()) {
        // Nếu execute thành công, trả về ID
        return $this->conn->insert_id;
    } else {
        
        throw new Exception("Lỗi SQL Execute: " . $stmt->error);
    }
}
    public function createChiTietKHSX($data)
    {
        $sql = "INSERT INTO chitietkehoachsanxuat (maKHSX, maXuong, maSanPham, maNVL, soLuongNVL)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "iiiii",
            $data['maKHSX'],
            $data['maXuong'],
            $data['maSanPham'],
            $data['maNVL'],
            $data['soLuongNVL']
        );

        return $stmt->execute();
    }


    public function getDHSXbyDateRange($ngayBatDau, $ngayKetThuc)
    {
        $sql = "SELECT * FROM donhangsanxuat 
                WHERE ngayTao BETWEEN :ngayBatDau AND :ngayKetThuc
                ORDER BY ngayTao DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':ngayBatDau' => $ngayBatDau,
            ':ngayKetThuc' => $ngayKetThuc
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
