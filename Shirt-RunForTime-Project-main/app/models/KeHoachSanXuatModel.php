<?php
// Đường dẫn đúng từ /app/models/
require_once 'ketNoi.php';

class KeHoachSanXuatModel
{
    // Dùng khoảng trắng thường để thụt lề
    private $conn;

    public function __construct()
    {
        $database = new KetNoi();
        $this->conn = $database->connect();
    }

    /* === SỬA HÀM NÀY ĐỂ LỌC KHSX ĐÃ YÊU CẦU NVL === */
    public function getAllPlans()
    {
        $sql = "SELECT maKHSX, tenKHSX, thoiGianBatDau, thoiGianKetThuc, trangThai
                FROM kehoachsanxuat
                ORDER BY thoiGianBatDau DESC";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getPlanById($maKHSX)
    {
        $sql = "SELECT kh.tenKHSX, kh.thoiGianKetThuc, nd.hoTen AS tenNguoiLap
                FROM kehoachsanxuat kh
                JOIN nguoidung nd ON kh.maND = nd.maND
                WHERE kh.maKHSX = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maKHSX);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_assoc() : null;
        $stmt->close();
        return $data;
    }

    // Hàm getMaterialsForPlan đã lấy loaiNVL rồi, cầnthêm  donViTinh
    public function getMaterialsForPlan($maKHSX)
    {
        $sql = "SELECT 
                    c.maNVL,
                    c.tenNVL,
                    c.soLuongNVL AS soLuongCan,
                    n.soLuongTonKho,
                    n.donViTinh
                FROM chitietkehoachsanxuat c
                LEFT JOIN nvl n ON c.maNVL = n.maNVL
                WHERE c.maKHSX = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maKHSX);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        $stmt->close();
        return $data;
    }
    public function getAllPlansForNhapKho()
    {
        $sql = "SELECT maKHSX, tenKHSX, thoiGianBatDau, thoiGianKetThuc, trangThai
            FROM kehoachsanxuat
            WHERE trangThai = 'Đã duyệt'";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die('❌ Lỗi prepare: ' . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function getAll()
    {
        $sql = "SELECT * FROM kehoachsanxuat ORDER BY maKHSX DESC";
        $stmt = $this->conn->prepare($sql);

        $data = [];
        if ($stmt && $stmt->num_rows > 0) {
            while ($row = $stmt->fetch()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getDanhSachKHSX($limit = 20)
    {
        // SỬA: Thêm kh.maDonHang vào danh sách cột cần lấy
        $sql = "SELECT 
                    kh.tenKHSX, 
                    kh.maKHSX, 
                    kh.maDonHang, 
                    kh.thoiGianBatDau, 
                    kh.thoiGianKetThuc, 
                    kh.trangThai, 
                    nd.hoTen AS tenNguoiLap
                FROM kehoachsanxuat kh
                LEFT JOIN nguoidung nd ON kh.maND = nd.maND
                ORDER BY kh.thoiGianBatDau DESC
                LIMIT ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Lỗi prepare getDanhSachKHSX: " . $this->conn->error);
            return [];
        }

        $stmt->bind_param("i", $limit);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    public function createKHSX($data)
    {
        // SỬA: Thay maKHSX bằng maDonHang trong câu lệnh SQL
        // Cột maKHSX là tự động tăng (AUTO_INCREMENT) nên không cần insert vào
        $sql = "INSERT INTO kehoachsanxuat (tenKHSX, maDonHang, thoiGianBatDau, thoiGianKetThuc, trangThai, maND)
            VALUES (?, ?, ?, ?, 'Chờ duyệt', ?)";

        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Lỗi SQL Prepare (createKHSX): " . $this->conn->error);
        }

        // SỬA: Thay $data['maKHSX'] bằng $data['maDonHang']
        $stmt->bind_param(
            "sissi",
            $data['tenKHSX'],
            $data['maDonHang'],
            $data['thoiGianBatDau'],
            $data['thoiGianKetThuc'],
            $data['maND']
        );

        if ($stmt->execute()) {
            return $this->conn->insert_id;
        } else {
            throw new Exception("Lỗi SQL Execute (createKHSX): " . $stmt->error);
        }
    }
    public function createChiTietKHSX($dataChiTiet)
    {

        $nvlInfo = $this->getNvlInfo($dataChiTiet['maNVL']);

        $sql = "INSERT INTO chitietkehoachsanxuat 
                (maKHSX, maSanPham, maXuong, maNVL, tenNVL, loaiNVL, soLuongNVL, maGNTP)
                VALUES (?, ?, ?, ?, ?, ?, ?, NULL)";

        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception("Lỗi SQL Prepare (createChiTietKHSX): " . $this->conn->error);
        }

        $stmt->bind_param(
            "iiiissi",
            $dataChiTiet['maKHSX'],
            $dataChiTiet['maSanPham'],
            $dataChiTiet['maXuong'],
            $dataChiTiet['maNVL'],
            $nvlInfo['tenNVL'],
            $nvlInfo['loaiNVL'],
            $dataChiTiet['soLuongNVL']
        );

        return $stmt->execute();
    }

    private function getNvlInfo($maNVL)
    {
        $sql = "SELECT tenNVL, loaiNVL FROM nvl WHERE maNVL = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maNVL);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        return $data ? $data : ['tenNVL' => 'Không rõ', 'loaiNVL' => 'Không rõ'];
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

    public function getKHSXDaDuyet()
    {
        $sql = "SELECT maKHSX, tenKHSX 
                FROM kehoachsanxuat 
                WHERE trangThai = 'Đã duyệt'
                ORDER BY maKHSX DESC";

        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getSanPhamTheoDonHangSanXuat($maKHSX)
    {
        $sql = "SELECT 
                    sp.maSanPham, 
                    sp.tenSanPham
                FROM san_pham sp
                JOIN donhangsanxuat dh ON sp.maSanPham = dh.maSanPham
                JOIN kehoachsanxuat kh ON dh.maDonHang = kh.maDonHang  
                WHERE kh.maKHSX = ?";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) return null;

        $stmt->bind_param("i", $maKHSX);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();

        return $data;
    }

    public function getDS_SanPhamTheoKHSX($maKHSX)
    {
        $sql = "SELECT sp.maSanPham, sp.tenSanPham
                FROM chitietkehoachsanxuat ct
                JOIN san_pham sp ON ct.maSanPham = sp.maSanPham
                WHERE ct.maKHSX = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) return [];

        $stmt->bind_param("i", $maKHSX);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
}
