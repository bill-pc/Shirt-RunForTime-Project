<?php
require_once 'ketNoi.php';

class PhieuYeuCauNhapKhoModel {
    private $conn;

    public function __construct() {
        $this->conn = (new KetNoi())->connect();
    }

    // Lấy danh sách phiếu
    public function getAll() {
        $sql = "SELECT * FROM phieuyeucaunhapkhonvl";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) die("❌ Lỗi prepare: " . $this->conn->error);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // ✅ Lưu phiếu yêu cầu nhập kho NVL
    public function createPhieuYeuCauNhapKho($data) {
        $maYCNK = "YCNK" . date("YmdHis");
        $trangThai = "Chờ duyệt";

        $sql = "INSERT INTO phieuyeucaunhapkhonvl (maYCNK, ngayLap, nhaCungCap, tenNguoiLap, trangThai)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) die("❌ Lỗi prepare: " . $this->conn->error);

        $stmt->bind_param(
            "sssss",
            $maYCNK,
            $data['ngayLap'],
            $data['nhaCungCap'],
            $data['nguoiLap'],
            $trangThai
        );

        return $stmt->execute();
    }
}
