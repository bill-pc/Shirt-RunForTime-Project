<?php
require_once 'app/models/ThanhPhamModel.php';

class ThongKeKhoTPController {
    private $model;

    public function __construct() {
        $this->model = new ThanhPhamModel();
    }

    // Chuẩn hoá định dạng ngày (hỗ trợ dd/mm/yyyy, mm/dd/yyyy, yyyy-mm-dd)
    private function normalizeDate($d) {
        if (!$d) return null;
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)) return $d;
        $dt = DateTime::createFromFormat('d/m/Y', $d);
        if ($dt) return $dt->format('Y-m-d');
        $dt = DateTime::createFromFormat('m/d/Y', $d);
        if ($dt) return $dt->format('Y-m-d');
        return $d;
    }

    public function index() {
        $from = $this->normalizeDate($_GET['from'] ?? null);
        $to   = $this->normalizeDate($_GET['to'] ?? null);
        $data = $this->model->thongKe($from, $to);
        require 'app/views/thongke_sanpham.php';
    }

    public function export() {
        $from = $this->normalizeDate($_GET['from'] ?? null);
        $to   = $this->normalizeDate($_GET['to'] ?? null);
        $file = $this->model->exportCSV($from, $to);
        header("Location: $file");
    }
}
