<?php
// Đường dẫn đúng từ /app/models/
require_once 'ketNoi.php';

class PhieuYeuCauModel {
    private $conn;

    public function __construct() {
        // Tên file của bạn có thể là ketNoi.php, phải đảm bảo nó chứa class Database
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function createPhieuYeuCau($data) {
        $conn = $this->conn;

        // --- Dữ liệu Phiếu Chính ---
        $tenPhieu = isset($data['tenPhieu']) ? trim($data['tenPhieu']) : 'Phiếu không tên';
        $nguoiLap = isset($data['nguoiLap']) && trim($data['nguoiLap']) !== '' ? trim($data['nguoiLap']) : null;
        $maKHSX = isset($data['maKHSX']) ? intval($data['maKHSX']) : 0;
        $maND = 1; // Giá trị tạm thời (cần lấy từ SESSION)
        $ngayLap = date('Y-m-d');
        $trangThai = "Chờ duyệt";

        if (empty($tenPhieu) || $maKHSX <= 0) {
            error_log("Dữ liệu phiếu chính không hợp lệ.");
            return false;
        }

        // --- Dữ liệu Chi tiết NVL ---
        $danhSachMaNVL = isset($data['maNVL']) && is_array($data['maNVL']) ? $data['maNVL'] : [];
        $danhSachTenNVL = isset($data['tenNVL']) && is_array($data['tenNVL']) ? $data['tenNVL'] : [];
        $danhSachSoLuong = isset($data['soLuong']) && is_array($data['soLuong']) ? $data['soLuong'] : [];
        // Lấy đơn vị tính từ POST (đã thêm hidden input trong View)
        $danhSachDonViTinh = isset($data['donViTinh']) && is_array($data['donViTinh']) ? $data['donViTinh'] : [];

        // Kiểm tra khớp số lượng mảng
        if (empty($danhSachMaNVL) ||
            count($danhSachMaNVL) !== count($danhSachTenNVL) ||
            count($danhSachMaNVL) !== count($danhSachSoLuong) ||
            count($danhSachMaNVL) !== count($danhSachDonViTinh)) {
             error_log("Dữ liệu NVL chi tiết không khớp số lượng phần tử.");
             return false;
        }


        // === Bắt đầu Transaction ===
        $conn->begin_transaction();

        try {
            // 1. INSERT vào bảng chính (phieuyeucaucungcapnvl)
            $sql1 = "INSERT INTO phieuyeucaucungcapnvl (tenPhieu, tenNguoiLap, ngayLap, maKHSX, maND, trangThai)
                     VALUES (?, ?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($sql1);
            if (!$stmt1) throw new Exception("Lỗi chuẩn bị câu lệnh 1: " . $conn->error);
            $stmt1->bind_param("sssiss", $tenPhieu, $nguoiLap, $ngayLap, $maKHSX, $maND, $trangThai);

            if (!$stmt1->execute()) throw new Exception("Lỗi thực thi câu lệnh 1: " . $stmt1->error);
            $maYCCC = $conn->insert_id;
            $stmt1->close();
            if ($maYCCC <= 0) throw new Exception("Không lấy được ID phiếu.");

            // 2. INSERT vào bảng chi tiết (chitiet_phieuyeucaucapnvl)
            // CẬP NHẬT: Thêm cột donViTinh
            $sql2 = "INSERT INTO chitiet_phieuyeucaucapnvl
                         (maYCCC, maNVL, tenNVL, soLuong, donViTinh)
                     VALUES (?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
             if (!$stmt2) throw new Exception("Lỗi chuẩn bị câu lệnh 2: " . $conn->error);

            // Lặp qua từng NVL
            for ($i = 0; $i < count($danhSachMaNVL); $i++) {
                $currentMaNVL = intval($danhSachMaNVL[$i]);
                $currentTenNVL = trim($danhSachTenNVL[$i]);
                $currentSoLuong = intval($danhSachSoLuong[$i]);
                // Lấy đơn vị tính
                $currentDonViTinh = trim($danhSachDonViTinh[$i]);

                if ($currentMaNVL > 0 && $currentSoLuong > 0) {
                    // CẬP NHẬT: Kiểu dữ liệu 'iisis' (int, int, string, int, string)
                    $stmt2->bind_param("iisis",
                        $maYCCC,
                        $currentMaNVL,
                        $currentTenNVL,
                        $currentSoLuong,
                        $currentDonViTinh // <-- Thêm biến ĐVT
                    );
                    if (!$stmt2->execute()) {
                        throw new Exception("Lỗi thực thi câu lệnh 2 cho NVL mã {$currentMaNVL}: " . $stmt2->error);
                    }
                }
            }
            $stmt2->close();

            // === Commit Transaction ===
            $conn->commit();
            return true;

        } catch (Exception $e) {
            // === Rollback Transaction ===
            $conn->rollback();
            error_log("Lỗi Transaction khi tạo phiếu yêu cầu NVL: " . $e->getMessage());
            // In lỗi ra màn hình để debug (CHỈ KHI CẦN, NHỚ XÓA SAU NÀY)
            echo "<h1>LỖI CSDL CHI TIẾT:</h1><pre>" . $e->getMessage() . "</pre>";
            return false;
        }
    }
}
?>