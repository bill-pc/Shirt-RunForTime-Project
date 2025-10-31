<?php
class PheDuyetModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    /* ==============================
       LẤY DANH SÁCH PHIẾU
    ============================== */

    // --- Phiếu cung cấp NVL ---
    public function getAllCapNVL() {
        $sql = "
            SELECT 
                y.maYCCC, 
                y.tenPhieu, 
                y.tenNguoiLap, 
                y.ngayLap, 
                y.trangThai
            FROM phieuyeucaucungcapnvl y
            WHERE y.trangThai = 'Chờ duyệt'
            ORDER BY y.ngayLap DESC
        ";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // --- Phiếu kiểm tra chất lượng ---
    public function getAllKTCL() {
        $sql = "
            SELECT 
                k.maYC, 
                k.tenPhieu, 
                k.tenNguoiLap, 
                k.ngayLap, 
                k.trangThai
            FROM phieuyeucaukiemtrachatluong k
            WHERE k.trangThai = 'Chờ duyệt'
            ORDER BY k.ngayLap DESC
        ";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // --- Phiếu nhập kho ---
    public function getAllNhapKho() {
        $sql = "
            SELECT 
                y.maYCNK, 
                y.tenPhieu, 
                y.tenNguoiLap, 
                y.ngayNhap AS ngayLap, 
                y.trangThai
            FROM phieuyeucaunhapkhonvl y
            WHERE y.trangThai = 'Chờ duyệt'
            ORDER BY y.ngayNhap DESC
        ";
        $result = $this->conn->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /* ==============================
       LẤY CHI TIẾT TỪNG PHIẾU
    ============================== */

    // --- Chi tiết phiếu cung cấp NVL ---
    public function getChiTietCapNVL($maYCCC) {
        $sql = "
            SELECT 
                y.maYCCC,
                y.tenPhieu,
                y.tenNguoiLap,
                y.ngayLap,
                y.trangThai,
                c.tenNVL,
                c.soLuong,
                c.donViTinh,
                c.nhaCungCap
            FROM phieuyeucaucungcapnvl y
            LEFT JOIN chitiet_phieuyeucaucapnvl c 
                ON y.maYCCC = c.maYCCC
            WHERE y.maYCCC = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maYCCC);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        return $data;
    }

    // --- Chi tiết phiếu kiểm tra chất lượng ---
    public function getChiTietKTCL($maYC) {
        $sql = "
            SELECT 
                k.maYC,
                k.tenPhieu,
                k.tenNguoiLap,
                k.ngayLap,
                k.trangThaiPhieu AS trangThai,
                c.tenSanPham,
                c.soLuong,
                c.ketQuaKiemTra
            FROM phieuyeucaukiemtrachatluong k
            LEFT JOIN chitietphieuyeucaukiemtrachatluong c 
                ON k.maYC = c.maYC
            WHERE k.maYC = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maYC);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        return $data;
    }

    // --- Chi tiết phiếu nhập kho ---
    public function getChiTietNhapKho($maYCNK) {
        $sql = "
            SELECT 
                y.maYCNK,
                y.tenPhieu,
                y.tenNguoiLap,
                y.ngayNhap AS ngayLap,
                y.trangThai,
                c.tenNVL,
                c.soLuong,
                c.donViTinh,
                c.nhaCungCap
            FROM phieuyeucaunhapkhonvl y
            LEFT JOIN chitiet_phieuyeucaunhapkhonvl c 
                ON y.maYCNK = c.maYCNK
            WHERE y.maYCNK = ?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maYCNK);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
        return $data;
    }

    /* ==============================
       CẬP NHẬT TRẠNG THÁI
    ============================== */

    public function capNhatTrangThai($loai, $id, $trangThai, $lyDo = null) {
    switch ($loai) {
        case 'capnvl':
            $table = 'phieuyeucaucungcapnvl'; $col = 'maYCCC'; break;
        case 'kiemtra':
            $table = 'phieuyeucaukiemtrachatluong'; $col = 'maYC'; break;
        case 'nhapkho':
            $table = 'phieuyeucaunhapkhonvl'; $col = 'maYCNK'; break;
        default:
            return false;
    }

    // Nếu là từ chối thì ghi lý do vào cột ghiChu
    if ($trangThai === 'Từ chối' && $lyDo) {
        $stmt = $this->conn->prepare("UPDATE $table SET trangThai = ?, ghiChu = ? WHERE $col = ?");
        $stmt->bind_param("ssi", $trangThai, $lyDo, $id);
    } else {
        $stmt = $this->conn->prepare("UPDATE $table SET trangThai = ? WHERE $col = ?");
        $stmt->bind_param("si", $trangThai, $id);
    }

    return $stmt->execute();
}


}
?>