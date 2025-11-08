<?php
require_once 'ketNoi.php';

class TaoDonHangSanXuatModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    /**
     * Lấy danh sách tất cả sản phẩm
     */
    public function getDanhSachSanPham() {
        $sql = "SELECT maSanPham, tenSanPham, donVi 
                FROM san_pham 
                ORDER BY tenSanPham";
        
        $result = $this->conn->query($sql);
        
        if (!$result) {
            error_log("Lỗi truy vấn danh sách sản phẩm: " . $this->conn->error);
            return [];
        }
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Lưu đơn hàng sản xuất mới
     * @param array $data Dữ liệu từ form
     * @return bool|int Trả về maDonHang nếu thành công, false nếu thất bại
     */
    public function luuDonHang($data) {
        // Validate dữ liệu
        $maDonHang = isset($data['maDonHang']) ? trim($data['maDonHang']) : '';
        $maSanPham = isset($data['sanPham']) ? (int)$data['sanPham'] : 0;
        $soLuong = isset($data['soLuong']) ? (int)$data['soLuong'] : 0;
        $ngayGiao = isset($data['ngayGiao']) ? $data['ngayGiao'] : '';
        $ghiChu = isset($data['ghiChu']) ? trim($data['ghiChu']) : '';

        // Kiểm tra dữ liệu bắt buộc
        if (empty($maDonHang) || $maSanPham <= 0 || $soLuong <= 0 || empty($ngayGiao)) {
            error_log("Dữ liệu không hợp lệ khi lưu đơn hàng");
            return false;
        }

        // Lấy thông tin sản phẩm để lấy đơn vị
        $sanPham = $this->getSanPhamById($maSanPham);
        if (!$sanPham) {
            error_log("Không tìm thấy sản phẩm với mã: " . $maSanPham);
            return false;
        }

        // Tạo tên đơn hàng từ mã đơn hàng và số lượng
        $tenDonHang = $maDonHang . ' - SL: ' . $soLuong;
        
        // Địa chỉ nhận mặc định (vì form không có, có thể thay đổi sau)
        $diaChiNhan = 'Nội bộ';
        
        // Trạng thái mặc định
        $trangThai = 'Chờ duyệt';

        // Chuẩn bị câu lệnh SQL
        $sql = "INSERT INTO donhangsanxuat 
                (tenDonHang, donVi, diaChiNhan, trangThai, ngayGiao, maSanPham) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            error_log("Lỗi chuẩn bị câu lệnh SQL: " . $this->conn->error);
            return false;
        }

        $donVi = $sanPham['donVi'] ?? 'Cái';
        
        $stmt->bind_param("sssssi", 
            $tenDonHang, 
            $donVi, 
            $diaChiNhan, 
            $trangThai, 
            $ngayGiao, 
            $maSanPham
        );

        if (!$stmt->execute()) {
            error_log("Lỗi thực thi lưu đơn hàng: " . $stmt->error);
            $stmt->close();
            return false;
        }

        $maDonHangMoi = $this->conn->insert_id;
        $stmt->close();

        // Nếu có ghi chú, có thể lưu vào bảng khác hoặc thêm cột ghiChu vào bảng
        // Tạm thời bỏ qua vì bảng không có cột ghiChu

        return $maDonHangMoi;
    }

    /**
     * Lấy thông tin sản phẩm theo ID
     */
    private function getSanPhamById($maSanPham) {
        $sql = "SELECT maSanPham, tenSanPham, donVi 
                FROM san_pham 
                WHERE maSanPham = ?";
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param("i", $maSanPham);
        
        if (!$stmt->execute()) {
            $stmt->close();
            return null;
        }

        $result = $stmt->get_result();
        $sanPham = $result->fetch_assoc();
        $stmt->close();

        return $sanPham;
    }

    /**
     * Kiểm tra mã đơn hàng đã tồn tại chưa
     */
    public function kiemTraMaDonHangTonTai($maDonHang) {
        $sql = "SELECT COUNT(*) as count 
                FROM donhangsanxuat 
                WHERE tenDonHang LIKE ?";
        
        $stmt = $this->conn->prepare($sql);
        
        if (!$stmt) {
            return false;
        }

        $pattern = $maDonHang . '%';
        $stmt->bind_param("s", $pattern);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row['count'] > 0;
    }
}
?>

