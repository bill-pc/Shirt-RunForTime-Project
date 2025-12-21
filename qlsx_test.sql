-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 21, 2025 lúc 05:43 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `dlck`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `baocaoloi`
--

CREATE TABLE `baocaoloi` (
  `maBaoCao` int(11) NOT NULL,
  `tenBaoCao` varchar(100) NOT NULL,
  `loaiLoi` varchar(100) DEFAULT NULL,
  `hinhAnh` varchar(255) DEFAULT '0',
  `thoiGian` date DEFAULT NULL,
  `moTa` varchar(255) DEFAULT NULL,
  `maThietBi` int(11) DEFAULT NULL,
  `maND` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `calamviec`
--

CREATE TABLE `calamviec` (
  `maCa` varchar(10) NOT NULL,
  `tenCa` varchar(10) NOT NULL,
  `gioBatDau` time NOT NULL,
  `gioKetThuc` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `calamviec`
--

INSERT INTO `calamviec` (`maCa`, `tenCa`, `gioBatDau`, `gioKetThuc`) VALUES
('CA_CHIEU', '', '13:00:00', '17:30:00'),
('CA_SANG', '', '07:30:00', '11:30:00'),
('CA_TOI', '', '18:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietkehoachsanxuat`
--

CREATE TABLE `chitietkehoachsanxuat` (
  `maCTKHSX` int(11) NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `maGNTP` int(11) DEFAULT NULL,
  `maXuong` int(11) NOT NULL,
  `maNVL` int(11) NOT NULL,
  `tenNVL` varchar(50) NOT NULL,
  `loaiNVL` varchar(50) NOT NULL,
  `soLuongNVL` int(11) NOT NULL,
  `ngayBatDau` date DEFAULT NULL,
  `ngayKetThuc` date DEFAULT NULL,
  `KPI` int(11) DEFAULT NULL,
  `soLuongThanhPham` int(11) DEFAULT NULL,
  `dinhMuc` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietkehoachsanxuat`
--

INSERT INTO `chitietkehoachsanxuat` (`maCTKHSX`, `maKHSX`, `maGNTP`, `maXuong`, `maNVL`, `tenNVL`, `loaiNVL`, `soLuongNVL`, `ngayBatDau`, `ngayKetThuc`, `KPI`, `soLuongThanhPham`, `dinhMuc`) VALUES
(2, 1, 2, 1, 1, 'Vải cotton loại 1', 'Vải', 20, NULL, NULL, NULL, NULL, NULL),
(3, 1, 2, 2, 2, 'Nút áo trơn', 'Phụ kiện', 200, NULL, NULL, NULL, NULL, NULL),
(4, 2, 2, 1, 1, 'Vải cotton loại 1', 'Vải', 300, NULL, NULL, NULL, NULL, NULL),
(5, 2, 2, 2, 3, 'Chỉ đen mỏng ', 'Chỉ', 300, NULL, NULL, NULL, NULL, NULL),
(6, 3, 3, 1, 1, 'Vải cotton loại 1', 'Vải', 120, NULL, NULL, NULL, NULL, NULL),
(7, 3, 3, 2, 3, 'Chỉ đen mỏng ', 'Chỉ', 230, NULL, NULL, NULL, NULL, NULL),
(8, 3, 3, 2, 2, 'Nút áo xám', 'Phụ kiện', 340, NULL, NULL, NULL, NULL, NULL),
(13, 10, NULL, 1, 1, 'Vải cotton', '0', 8000, '2025-12-10', '2025-12-23', 300, 0, 2.00),
(14, 10, NULL, 2, 2, 'Nút áo', '0', 24000, '2025-12-11', '2025-12-26', 250, 0, 6.00),
(15, 10, NULL, 2, 3, 'Chỉ may đen', '0', 4800, '2025-12-11', '2025-12-26', 250, 0, 1.20),
(16, 11, NULL, 1, 1, 'Vải cotton', '0', 2000, '2025-12-12', '2025-12-21', 100, 0, 2.00),
(17, 11, NULL, 2, 2, 'Nút áo', '0', 6000, '2025-12-13', '2025-12-22', 100, 0, 6.00),
(18, 11, NULL, 2, 6, 'Chỉ may trắng', '0', 2500, '2025-12-13', '2025-12-22', 100, 0, 2.50),
(19, 12, NULL, 1, 1, 'Vải cotton', '0', 8800, '2025-12-19', '2026-01-14', 150, 0, 2.20),
(20, 12, NULL, 2, 2, 'Nút áo', '0', 24000, '2025-12-20', '2026-01-15', 150, 0, 6.00),
(21, 12, NULL, 2, 3, 'Chỉ may đen', '0', 24800, '2025-12-20', '2026-01-15', 150, 0, 6.20),
(22, 13, NULL, 1, 1, 'Vải cotton', '0', 11000, '2025-12-17', '2026-01-19', 150, 0, 2.20),
(23, 13, NULL, 2, 2, 'Nút áo', '0', 30000, '2025-12-18', '2026-01-20', 150, 0, 6.00),
(24, 13, NULL, 2, 3, 'Chỉ may đen', '0', 10000, '2025-12-18', '2026-01-20', 150, 0, 2.00),
(25, 14, NULL, 1, 1, 'Vải cotton', '0', 12000, '2025-12-17', '2026-01-05', 300, 0, 2.00),
(26, 14, NULL, 2, 2, 'Nút áo', '0', 36000, '2025-12-18', '2026-01-06', 300, 0, 6.00),
(27, 14, NULL, 2, 3, 'Chỉ may đen', '0', 12000, '2025-12-18', '2026-01-06', 300, 0, 2.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieuxuatnvl`
--

CREATE TABLE `chitietphieuxuatnvl` (
  `maCTPX` int(11) NOT NULL,
  `maNVL` int(11) NOT NULL,
  `tenNVL` varchar(100) DEFAULT NULL,
  `soLuong` int(11) NOT NULL,
  `maPhieu` int(11) NOT NULL,
  `maXuong` int(11) NOT NULL,
  `ghiChu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietphieuxuatnvl`
--

INSERT INTO `chitietphieuxuatnvl` (`maCTPX`, `maNVL`, `tenNVL`, `soLuong`, `maPhieu`, `maXuong`, `ghiChu`) VALUES
(16, 1, 'Vải cotton', 11000, 13, 1, ''),
(17, 2, 'Nút áo', 30000, 13, 2, ''),
(18, 3, 'Chỉ may đen', 10000, 13, 2, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieuyeucaukiemtrachatluong`
--

CREATE TABLE `chitietphieuyeucaukiemtrachatluong` (
  `maCTPKT` int(11) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `tenSanPham` varchar(255) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `soLuongDat` int(11) DEFAULT 0,
  `soLuongHong` int(11) DEFAULT 0,
  `ngayKiemTra` date DEFAULT NULL,
  `donViTinh` varchar(20) NOT NULL,
  `maYC` int(11) NOT NULL,
  `trangThaiSanPham` varchar(50) NOT NULL DEFAULT 'Ch? ki?m tra',
  `ghiChu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietphieuyeucaukiemtrachatluong`
--

INSERT INTO `chitietphieuyeucaukiemtrachatluong` (`maCTPKT`, `maSanPham`, `tenSanPham`, `soLuong`, `soLuongDat`, `soLuongHong`, `ngayKiemTra`, `donViTinh`, `maYC`, `trangThaiSanPham`, `ghiChu`) VALUES
(14, 2, 'Áo sơ mi xanh dương', 1000, 0, 0, NULL, 'Cái', 25, 'Chờ kiểm tra', ''),
(15, 1, 'Áo sơ mi trắng', 2000, 0, 0, NULL, 'Cái', 26, 'Chờ kiểm tra', ''),
(16, 4, 'Áo sơ mi 1', 200, 0, 0, NULL, 'Cái', 27, 'Chờ kiểm tra', ''),
(17, 4, 'Áo sơ mi 1', 200, 199, 1, '2025-12-16', 'Cái', 28, 'Đã kiểm tra', ''),
(18, 3, 'Áo sơ mi tay ngắn', 5000, 4998, 2, '2025-12-16', 'Cái', 29, 'Đã kiểm tra', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiet_lichlamviec`
--

CREATE TABLE `chitiet_lichlamviec` (
  `maLichLam` int(11) NOT NULL,
  `maND` int(10) NOT NULL,
  `ngayLam` date NOT NULL,
  `maCa` char(10) NOT NULL,
  `maXuong` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiet_lichlamviec`
--

INSERT INTO `chitiet_lichlamviec` (`maLichLam`, `maND`, `ngayLam`, `maCa`, `maXuong`) VALUES
(1, 1, '2025-11-14', 'CA_SANG', '1'),
(2, 1, '2025-11-14', 'CA_CHIEU', '1'),
(3, 1, '2025-11-15', 'CA_SANG', '1'),
(4, 1, '2025-11-15', 'CA_CHIEU', '1'),
(5, 1, '2025-11-16', 'CA_SANG', '1'),
(6, 1, '2025-11-16', 'CA_CHIEU', '1'),
(7, 1, '2025-11-16', 'CA_TOI', '1'),
(8, 1, '2025-11-17', 'CA_SANG', '1'),
(9, 1, '2025-11-17', 'CA_CHIEU', '1'),
(10, 1, '2025-11-18', 'CA_SANG', '1'),
(11, 1, '2025-11-18', 'CA_CHIEU', '1'),
(12, 1, '2025-11-19', 'CA_SANG', '1'),
(13, 1, '2025-11-19', 'CA_CHIEU', '1'),
(14, 1, '2025-11-19', 'CA_TOI', '1'),
(15, 1, '2025-12-07', 'CA_SANG', '1'),
(16, 1, '2025-12-10', 'CA_CHIEU', '1'),
(0, 1, '2025-12-17', 'CA_SANG', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiet_nhapkhotp`
--

CREATE TABLE `chitiet_nhapkhotp` (
  `maCTNKTP` int(11) NOT NULL,
  `maPhieu` int(11) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `tenSanPham` varchar(255) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `hanhDong` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiet_nhapkhotp`
--

INSERT INTO `chitiet_nhapkhotp` (`maCTNKTP`, `maPhieu`, `maSanPham`, `tenSanPham`, `soLuong`, `hanhDong`) VALUES
(5, 4, 8, 'Áo sơ mi tím', 125, 'Nhập kho thành phẩm sau khi kiểm tra chất lượng'),
(9, 8, 3, 'Áo sơ mi tay ngắn', 3500, 'Nhập kho thành phẩm sau khi kiểm tra chất lượng'),
(10, 9, 2, 'Áo sơ mi xanh dương', 1000, 'Nhập kho thành phẩm sau khi kiểm tra chất lượng'),
(13, 12, 3, 'Áo sơ mi tay ngắn', 5000, 'Nhập kho thành phẩm sau khi kiểm tra chất lượng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiet_phieuyeucaucapnvl`
--

CREATE TABLE `chitiet_phieuyeucaucapnvl` (
  `maCTPhieuYCCC` int(11) NOT NULL,
  `tenNVL` varchar(100) NOT NULL,
  `nhaCungCap` varchar(100) DEFAULT NULL,
  `soLuong` int(11) NOT NULL,
  `donViTinh` varchar(20) DEFAULT NULL,
  `maYCCC` int(11) NOT NULL,
  `maNVL` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiet_phieuyeucaunhapkhonvl`
--

CREATE TABLE `chitiet_phieuyeucaunhapkhonvl` (
  `maChiTiet_YCNK` int(11) NOT NULL,
  `maYCNK` int(11) NOT NULL,
  `maNVL` int(11) NOT NULL,
  `tenNVL` varchar(255) DEFAULT NULL,
  `soLuong` int(11) DEFAULT NULL,
  `donViTinh` varchar(50) DEFAULT NULL,
  `nhaCungCap` varchar(200) NOT NULL,
  `soLuongTonKho` int(11) NOT NULL,
  `soLuongCanNhap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiet_phieuyeucaunhapkhonvl`
--

INSERT INTO `chitiet_phieuyeucaunhapkhonvl` (`maChiTiet_YCNK`, `maYCNK`, `maNVL`, `tenNVL`, `soLuong`, `donViTinh`, `nhaCungCap`, `soLuongTonKho`, `soLuongCanNhap`) VALUES
(8, 4, 1, 'Vải cotton loại 1', 300, 'Tấm', 'Công ty Sợi Quốc Tế', 443, 300),
(9, 4, 3, 'Chỉ đen mỏng ', 300, 'Cuộn', 'Công ty Vải Việt Nam', 730, 300),
(10, 5, 1, 'Vải cotton', 0, 'Tấm', 'Công ty Vải Việt Nam', 743, 23),
(11, 5, 2, 'Nút áo', 0, 'Cái', 'Công ty Sợi Quốc Tế', 1429, 89),
(12, 6, 1, 'Vải cotton loại 1', 46, 'Tấm', 'Công ty Sợi Quốc Tế', 743, 120),
(13, 6, 3, 'Chỉ đen mỏng ', 127, 'Cuộn', 'Công ty Vải Việt Nam', 1030, 230),
(14, 6, 2, 'Nút áo xám', 197, 'Cái', 'Công ty Vải Cotton Cao Cấp', 1429, 340),
(15, 7, 1, 'Vải cotton', 10921, 'Tấm', 'Công ty Vải Việt Nam', 789, 11000),
(16, 7, 2, 'Nút áo', 29837, 'Cái', 'Công ty Phụ liệu May Mặc', 1626, 30000),
(17, 7, 3, 'Chỉ may đen', 9884, 'Cuộn', 'Công ty Sợi Quốc Tế', 1157, 10000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `congviec`
--

CREATE TABLE `congviec` (
  `maCongViec` int(11) NOT NULL,
  `tieuDe` varchar(100) NOT NULL,
  `moTa` varchar(200) DEFAULT NULL,
  `trangThai` varchar(30) NOT NULL DEFAULT 'Đang thực hiện',
  `ngayHetHan` date NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `maXuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `congviec`
--

INSERT INTO `congviec` (`maCongViec`, `tieuDe`, `moTa`, `trangThai`, `ngayHetHan`, `maKHSX`, `maXuong`) VALUES
(1, 'Cắt vải', 'cắt vải xanh dương', 'Đang thực hiện', '2025-12-23', 1, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhangsanxuat`
--

CREATE TABLE `donhangsanxuat` (
  `maDonHang` int(11) NOT NULL,
  `tenDonHang` varchar(100) NOT NULL,
  `tenSanPham` varchar(200) NOT NULL,
  `soLuongSanXuat` int(11) NOT NULL,
  `donVi` varchar(50) DEFAULT NULL,
  `diaChiNhan` varchar(100) NOT NULL,
  `trangThai` varchar(50) NOT NULL,
  `ngayGiao` date NOT NULL,
  `maSanPham` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhangsanxuat`
--

INSERT INTO `donhangsanxuat` (`maDonHang`, `tenDonHang`, `tenSanPham`, `soLuongSanXuat`, `donVi`, `diaChiNhan`, `trangThai`, `ngayGiao`, `maSanPham`) VALUES
(1, ' DHSX1', 'Áo sơ mi hoa cúc', 2000, 'Cai', 'Nguyen Oanh', 'Chờ xuất kho', '2025-10-31', 1),
(2, 'DHSX2', 'Áo sơ mi xanh dương', 1000, 'Cái', 'ABC', 'Chờ xuất kho', '2025-10-31', 2),
(3, 'DHSX4', 'Áo sơ mi tay ngắn', 3500, 'Cái', 'Nguyễn Văn Bảo', 'Chờ xuất kho', '2025-11-28', 3),
(5, 'DHSX5', 'Áo sơ mi 1', 200, 'Cái', '58 Quang Trung, Gò Vấp', 'Hoàn thành', '2025-12-06', 4),
(6, 'DHSX6', 'Áo sơ mi tay ngắn', 200, 'Cái', 'iuowqiueoq', 'Chờ xuất kho', '2025-12-11', 3),
(7, 'DHSX7', 'Áo sơ mi tím', 10000, 'Cái', '123', 'Đang thực hiện', '2025-12-18', 8),
(8, 'DHSX8', 'Áo sơ mi tay ngắn', 1200, 'Cái', '1234', 'Chờ xuất kho', '2025-12-24', 3),
(9, 'DHSX9', 'Áo sơ mi tay dài custom hoa cúc', 1230, 'Cái', '123 Phường 12 Thành phố HKT', 'Đang thực hiện', '2025-12-31', 10),
(10, 'DHSX10', 'Áo mới cà mau', 1111, 'Cái', '11111', 'Đang thực hiện', '2025-12-17', 11),
(11, 'DHSX11', 'Áo sơ mi trắng', 3000, 'Cái', '58 Quang Trung, Gò Vấp', 'Đang thực hiện', '2026-01-10', 1),
(12, 'DHSX12', 'Áo sơ mi tay ngắn', 5000, 'Cái', '58 Quang Trung, Gò Vấp', 'Đang thực hiện', '2026-01-28', 3),
(13, 'DHSX13', 'Áo sơ mi đỏ', 6000, 'Cái', '58 Quang Trung, Gò Vấp', 'Đang thực hiện', '2026-01-10', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ghinhanthanhphamtheongay`
--

CREATE TABLE `ghinhanthanhphamtheongay` (
  `maGhiNhan` int(11) NOT NULL,
  `maNhanVien` int(11) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `soLuongSPHoanThanh` int(11) NOT NULL,
  `ngayLam` date NOT NULL,
  `maKHSX` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `ghinhanthanhphamtheongay`
--

INSERT INTO `ghinhanthanhphamtheongay` (`maGhiNhan`, `maNhanVien`, `maSanPham`, `soLuongSPHoanThanh`, `ngayLam`, `maKHSX`) VALUES
(2, 1, 1, 20, '2025-10-28', 1),
(3, 1, 1, 30, '2025-10-29', 1),
(4, 1, 1, 25, '2025-10-31', 1),
(5, 1, 1, 40, '2025-11-03', 1),
(6, 15, 1, 25, '2025-11-04', 1),
(7, 7, 1, 35, '2025-10-30', 1),
(8, 8, 1, 20, '2025-12-05', 1),
(9, 7, 1, 15, '2025-12-05', 1),
(32, 7, 5, 500, '2025-12-16', 14),
(33, 7, 5, 5500, '2025-12-16', 14),
(35, 8, 3, 500, '2025-12-16', 13),
(36, 7, 3, 4500, '2025-12-16', 13),
(37, 6, 3, 500, '2025-12-16', 13);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kehoachsanxuat`
--

CREATE TABLE `kehoachsanxuat` (
  `maKHSX` int(11) NOT NULL,
  `tenKHSX` varchar(100) NOT NULL,
  `maDonHang` int(11) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `thoiGianBatDau` date NOT NULL,
  `thoiGianKetThuc` date NOT NULL,
  `trangThai` varchar(50) NOT NULL DEFAULT 'Chờ duyệt',
  `maND` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `kehoachsanxuat`
--

INSERT INTO `kehoachsanxuat` (`maKHSX`, `tenKHSX`, `maDonHang`, `maSanPham`, `thoiGianBatDau`, `thoiGianKetThuc`, `trangThai`, `maND`) VALUES
(1, 'KHSX1', 1, 1, '2025-10-01', '2025-10-31', 'Đã duyệt', 1),
(2, 'KHSX2', 2, 2, '2025-10-09', '2025-10-31', 'Đã duyệt', 1),
(3, 'KHSX3', 3, 3, '2025-10-01', '2025-11-06', 'Đã duyệt', 1),
(4, 'KHSX cho ĐH 5', 5, 4, '2025-11-26', '2025-12-06', 'Đã duyệt', 1),
(5, 'KHSX cho ĐH 5', 5, 3, '2025-11-26', '2025-12-06', 'Chờ duyệt', 1),
(6, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Đã duyệt', 1),
(7, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Chờ duyệt', 1),
(8, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Chờ duyệt', 1),
(9, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Chờ duyệt', 1),
(10, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Đã duyệt', 1),
(11, 'KHSX cho ĐH 11', 11, 0, '2025-12-17', '2026-01-10', 'Chờ duyệt', 1),
(12, 'KHSX cho ĐH 11', 11, 0, '2025-12-18', '2026-01-28', 'Chờ duyệt', 1),
(13, 'KHSX cho ĐH 12', 12, 0, '2025-12-16', '2026-01-28', 'Hoàn thành', 1),
(14, 'KHSX cho ĐH 13', 13, 0, '2025-12-16', '2026-01-10', 'Hoàn thành', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kho`
--

CREATE TABLE `kho` (
  `maKho` int(11) NOT NULL,
  `tenKho` varchar(100) NOT NULL,
  `diaChi` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `kho`
--

INSERT INTO `kho` (`maKho`, `tenKho`, `diaChi`) VALUES
(1, 'Kho Nguyên Vật Liệu', NULL),
(2, 'Kho Thành Phẩm', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lichsupheduyet`
--

CREATE TABLE `lichsupheduyet` (
  `id` int(11) NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `hanhDong` varchar(50) NOT NULL,
  `ghiChu` text DEFAULT NULL,
  `nguoiThucHien` varchar(100) DEFAULT NULL,
  `thoiGian` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lichsupheduyet`
--

INSERT INTO `lichsupheduyet` (`id`, `maKHSX`, `hanhDong`, `ghiChu`, `nguoiThucHien`, `thoiGian`) VALUES
(1, 1, 'Đã duyệt', '', 'TranKienQuoc', '2025-11-08 14:13:17'),
(2, 2, 'Từ chối', '', 'TranKienQuoc', '2025-11-08 14:13:42'),
(3, 1, 'Đã duyệt', '', 'TranKienQuoc', '2025-11-14 09:49:26'),
(4, 10, 'Đã duyệt', '', 'TranKienQuoc', '2025-12-16 11:10:26'),
(5, 6, 'Đã duyệt', '', 'TranKienQuoc', '2025-12-16 13:43:03'),
(6, 13, 'Đã duyệt', '', 'TranKienQuoc', '2025-12-16 20:37:02'),
(7, 14, 'Đã duyệt', '', 'TranKienQuoc', '2025-12-16 23:52:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `maND` int(11) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `gioiTinh` varchar(20) NOT NULL,
  `ngaySinh` date DEFAULT NULL,
  `chucVu` varchar(50) DEFAULT NULL,
  `phongBan` varchar(100) NOT NULL,
  `soDienThoai` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `diaChi` varchar(100) DEFAULT NULL,
  `maTK` int(11) NOT NULL,
  `trangThai` tinyint(1) DEFAULT 1,
  `hinhAnh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`maND`, `hoTen`, `gioiTinh`, `ngaySinh`, `chucVu`, `phongBan`, `soDienThoai`, `email`, `diaChi`, `maTK`, `trangThai`, `hinhAnh`) VALUES
(1, 'TranKienQuoc', 'Nam', '2004-10-12', 'Giám đốc', '', '0346512104', 'trankienquoc@gmail.com', '54/12 Quang Trung, Gò Vấp', 1, 1, 'avatar1.png'),
(6, 'Nguyễn Văn B', 'Nam', '2002-01-12', 'Trưởng phòng', 'Xưởng may', '0901234567', 'an.nguyen@company.com', '123 Võ Văn Tần, Q.3, TP.HCM', 2, 1, ''),
(7, 'Trần Thị Bình', 'Nữ', '2001-04-20', 'Nhân viên', 'Xưởng may', '0987654321', 'binh.tran@company.com', '456 Lê Lợi, Q.1, TP.HCM', 3, 1, ''),
(8, 'Lê Minh Cường', 'Nam', '1994-07-10', 'Kỹ thuật viên', 'Xưởng cắt', '0912345678', 'cuong.le@company.com', '789 Nguyễn Trãi, Q.5, TP.HCM', 4, 1, ''),
(15, 'Mai Van Vu', 'Nam', NULL, 'Nhân viên xưởng Cắt', 'Xưởng cắt', '12222222222', '1232221@gmail.com', '581 Nguyen Oanh', 10, 0, ''),
(17, 'Vũ Mai', '', '1990-03-19', 'Nhân viên xưởng Cắt', 'Xưởng cắt', '1900232323', 'maivu@gmail.com', 'Chu Văn An, Phường 26', 16, 1, ''),
(18, 'Nguyễn Văn C', '', NULL, 'Nhân viên xưởng Cắt', '', '0345456734', 'trankienuoc@gmail.com', '54 Nguyễn Trãi, Hồ Chí Minh', 17, 0, ''),
(100, 'Nguyễn Văn A', 'Nam', '1980-01-15', 'Giám đốc', 'Ban Giám Đốc', '0901234567', 'giamdoc@company.com', '123 Nguyễn Huệ, Q.1, TP.HCM', 100, 1, 'avatar1.png'),
(101, 'Trần Thị B', 'Nữ', '1985-03-20', 'Quản lý nhân sự', 'Phòng Nhân Sự', '0902345678', 'qlnhansu@company.com', '456 Lê Lợi, Q.1, TP.HCM', 101, 1, ''),
(102, 'Lê Văn C', 'Nam', '1982-05-10', 'Quản lý sản xuất', 'Phòng Sản Xuất', '0903456789', 'qlsanxuat@company.com', '789 Hai Bà Trưng, Q.3, TP.HCM', 102, 1, ''),
(103, 'Phạm Thị D', 'Nữ', '1988-07-25', 'Quản lý kho NVL', 'Kho Nguyên Vật Liệu', '0904567890', 'qlkhonvl@company.com', '321 Võ Văn Tần, Q.3, TP.HCM', 103, 1, ''),
(104, 'Hoàng Văn E', 'Nam', '1990-09-12', 'Nhân viên QC', 'Bộ Phận Kiểm Tra Chất Lượng', '0905678901', 'nhanvienqc@company.com', '654 Nguyễn Trãi, Q.5, TP.HCM', 104, 1, ''),
(105, 'Vũ Thị F', 'Nữ', '1987-11-30', 'Quản lý kho TP', 'Kho Thành Phẩm', '0906789012', 'qlkhotp@company.com', '987 Cách Mạng Tháng 8, Q.10, TP.HCM', 105, 1, ''),
(106, 'Đỗ Văn G', 'Nam', '1992-02-18', 'Công nhân', 'Xưởng Cắt', '0907890123', 'congnhancat@company.com', '135 Lý Thường Kiệt, Gò Vấp, TP.HCM', 106, 1, ''),
(107, 'Ngô Thị H', 'Nữ', '1993-04-22', 'Công nhân', 'Xưởng May', '0908901234', 'congnhanmay@company.com', '246 Phan Văn Trị, Bình Thạnh, TP.HCM', 107, 1, ''),
(200, 'Trần Văn Đức', 'Nam', '1988-07-20', 'Quản lý xưởng', 'Xưởng sản xuất', '0909876543', 'tranvanduc.qlx2024@company.com', '456 Đường Lê Lợi, Quận 1, TP.HCM', 200, 1, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhapkhotp`
--

CREATE TABLE `nhapkhotp` (
  `maPhieu` int(11) NOT NULL,
  `maYC` int(11) NOT NULL,
  `ngayKiemTra` date NOT NULL,
  `nguoiLap` varchar(100) NOT NULL,
  `hanhDong` varchar(255) NOT NULL,
  `ngayNK` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhapkhotp`
--

INSERT INTO `nhapkhotp` (`maPhieu`, `maYC`, `ngayKiemTra`, `nguoiLap`, `hanhDong`, `ngayNK`) VALUES
(4, 11, '2025-12-14', 'TranKienQuoc', 'Nhập kho thành phẩm sau khi kiểm tra chất lượng', '0000-00-00'),
(8, 16, '2025-12-16', 'TranKienQuoc', 'Nhập kho thành phẩm sau khi kiểm tra chất lượng', '0000-00-00'),
(9, 25, '2025-12-16', 'TranKienQuoc', 'Nhập kho thành phẩm sau khi kiểm tra chất lượng', '0000-00-00'),
(12, 29, '2025-12-16', 'TranKienQuoc', 'Nhập kho thành phẩm sau khi kiểm tra chất lượng', '0000-00-00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nvl`
--

CREATE TABLE `nvl` (
  `maNVL` int(11) NOT NULL,
  `tenNVL` varchar(100) NOT NULL,
  `loaiNVL` varchar(50) DEFAULT NULL,
  `soLuongTonKho` int(11) NOT NULL DEFAULT 0,
  `donViTinh` varchar(20) DEFAULT NULL,
  `moTa` varchar(255) DEFAULT NULL,
  `maKho` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nvl`
--

INSERT INTO `nvl` (`maNVL`, `tenNVL`, `loaiNVL`, `soLuongTonKho`, `donViTinh`, `moTa`, `maKho`) VALUES
(1, 'Vải cotton', 'Vải', 11710, 'Tấm', '2m x 3m', NULL),
(2, 'Nút áo', 'Phụ kiện', 31463, 'Cái', 'Nút áo trắng', NULL),
(3, 'Chỉ may đen', 'Chỉ', 11041, 'Cuộn', 'Chỉ may màu trắng', 1),
(4, 'Nút áo', 'Phụ kiện', 200, 'Cái', 'Nút áo màu đen', 1),
(5, 'Vải cotton', 'Vải', 300, 'Tấm', 'Vải cotton trắng', 1),
(6, 'Chỉ may trắng', 'Chỉ', 3000, 'Cuộn', 'Chỉ may màu trắng, mỏng', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieunhapnvl`
--

CREATE TABLE `phieunhapnvl` (
  `maPNVL` int(11) NOT NULL,
  `tenPNVL` varchar(100) NOT NULL,
  `nguoiLap` varchar(100) NOT NULL,
  `nhaCungCap` varchar(500) NOT NULL,
  `ngayNhap` date NOT NULL,
  `maYCNK` int(11) NOT NULL,
  `maNVL` int(11) DEFAULT NULL,
  `soLuongNhap` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieunhapnvl`
--

INSERT INTO `phieunhapnvl` (`maPNVL`, `tenPNVL`, `nguoiLap`, `nhaCungCap`, `ngayNhap`, `maYCNK`, `maNVL`, `soLuongNhap`) VALUES
(1, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Vải Việt Nam', '2025-12-16', 2, 1, 23),
(2, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Vải Cotton Cao Cấp', '2025-12-16', 2, 2, 89),
(3, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', '', '2025-12-16', 1, 1, 200),
(4, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Vải Việt Nam', '2025-12-16', 3, 1, 120),
(5, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Vải Việt Nam', '2025-12-16', 3, 3, 230),
(6, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Vải Việt Nam', '2025-12-16', 3, 2, 340),
(7, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Sợi Quốc Tế', '2025-12-16', 4, 1, 300),
(8, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Vải Việt Nam', '2025-12-16', 4, 3, 300),
(9, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Sợi Quốc Tế', '2025-12-16', 6, 1, 46),
(10, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Vải Việt Nam', '2025-12-16', 6, 3, 127),
(11, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Vải Cotton Cao Cấp', '2025-12-16', 6, 2, 197),
(12, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Vải Việt Nam', '2025-12-16', 7, 1, 10921),
(13, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Phụ liệu May Mặc', '2025-12-16', 7, 2, 29837),
(14, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'Công ty Sợi Quốc Tế', '2025-12-16', 7, 3, 9884);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuxuatnvl`
--

CREATE TABLE `phieuxuatnvl` (
  `maPhieu` int(11) NOT NULL,
  `tenPhieu` varchar(100) NOT NULL,
  `tenNguoiLap` varchar(100) DEFAULT NULL,
  `ngayLap` date NOT NULL,
  `maND` int(11) NOT NULL,
  `maYCCC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieuxuatnvl`
--

INSERT INTO `phieuxuatnvl` (`maPhieu`, `tenPhieu`, `tenNguoiLap`, `ngayLap`, `maND`, `maYCCC`) VALUES
(13, 'Xuất NVL KHSX cho ĐH 12', 'TranKienQuoc', '2025-12-16', 1, 31);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuxuatthanhpham`
--

CREATE TABLE `phieuxuatthanhpham` (
  `maPhieuXuat` int(11) NOT NULL,
  `maDonHang` int(11) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `soLuongXuat` int(11) NOT NULL,
  `ngayXuat` date NOT NULL,
  `ghiChu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieuxuatthanhpham`
--

INSERT INTO `phieuxuatthanhpham` (`maPhieuXuat`, `maDonHang`, `maSanPham`, `soLuongXuat`, `ngayXuat`, `ghiChu`) VALUES
(1, 1, 1, 5, '2025-10-30', ''),
(2, 2, 2, 200, '2025-11-03', ''),
(3, 12, 3, 5000, '0000-00-00', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuyeucaucungcapnvl`
--

CREATE TABLE `phieuyeucaucungcapnvl` (
  `maYCCC` int(11) NOT NULL,
  `ngayLap` date NOT NULL,
  `trangThai` varchar(50) NOT NULL DEFAULT 'Chờ duyệt',
  `tenNguoiLap` varchar(100) DEFAULT NULL,
  `maND` int(11) NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `tenPhieu` varchar(100) NOT NULL,
  `ghiChu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieuyeucaucungcapnvl`
--

INSERT INTO `phieuyeucaucungcapnvl` (`maYCCC`, `ngayLap`, `trangThai`, `tenNguoiLap`, `maND`, `maKHSX`, `tenPhieu`, `ghiChu`) VALUES
(30, '2025-11-21', 'Đã duyệt', 'TranKienQuoc', 1, 1, 'Yêu cầu NVL cho KHSX1', ''),
(31, '2025-12-16', 'Đang xuất NVL', 'TranKienQuoc', 1, 13, 'Yêu cầu NVL cho KHSX cho ĐH 12', ''),
(32, '2025-12-21', 'Chờ duyệt', 'TranKienQuoc', 1, 2, 'Yêu cầu NVL cho KHSX2', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuyeucaukiemtrachatluong`
--

CREATE TABLE `phieuyeucaukiemtrachatluong` (
  `maYC` int(11) NOT NULL,
  `tenPhieu` varchar(255) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `trangThai` varchar(100) NOT NULL DEFAULT 'Chờ duyệt',
  `ngayLap` date NOT NULL,
  `tenNguoiLap` varchar(100) NOT NULL,
  `maND` int(11) NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `thoiHanHoanThanh` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieuyeucaukiemtrachatluong`
--

INSERT INTO `phieuyeucaukiemtrachatluong` (`maYC`, `tenPhieu`, `maSanPham`, `trangThai`, `ngayLap`, `tenNguoiLap`, `maND`, `maKHSX`, `thoiHanHoanThanh`) VALUES
(16, 'Phiếu KTCL - KHSX3', 3, 'Chờ duyệt', '2025-12-16', 'TranKienQuoc', 1, 3, '2025-12-01'),
(25, 'Phiếu KTCL - KHSX2', 2, 'Đã nhập kho', '0000-00-00', 'TranKienQuoc', 1, 2, '2025-11-03'),
(26, 'Phiếu KTCL - KHSX1', 1, 'Đã nhập kho', '0000-00-00', 'TranKienQuoc', 1, 1, '2025-11-03'),
(27, 'Phiếu KTCL - KHSX cho ĐH 5', 4, 'Đã duyệt', '0000-00-00', 'TranKienQuoc', 1, 5, '2025-12-09'),
(28, 'Phiếu KTCL - KHSX cho ĐH 5', 4, 'Đã duyệt', '0000-00-00', 'TranKienQuoc', 1, 4, '2025-12-09'),
(29, 'Phiếu KTCL - KHSX cho ĐH 12', 3, 'Đã nhập kho', '0000-00-00', 'TranKienQuoc', 1, 13, '2026-01-31');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuyeucaunhapkhonvl`
--

CREATE TABLE `phieuyeucaunhapkhonvl` (
  `maYCNK` int(11) NOT NULL,
  `tenPhieu` varchar(200) NOT NULL,
  `ngayLap` date NOT NULL,
  `trangThai` varchar(50) NOT NULL DEFAULT 'Chờ duyệt',
  `tenNguoiLap` varchar(100) NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `maND` int(11) NOT NULL,
  `nguoiDuyet` varchar(100) DEFAULT NULL,
  `ngayDuyet` datetime DEFAULT NULL,
  `lyDoTuChoi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieuyeucaunhapkhonvl`
--

INSERT INTO `phieuyeucaunhapkhonvl` (`maYCNK`, `tenPhieu`, `ngayLap`, `trangThai`, `tenNguoiLap`, `maKHSX`, `maND`, `nguoiDuyet`, `ngayDuyet`, `lyDoTuChoi`) VALUES
(4, 'Phiếu yêu cầu nhập kho NVL - KHSX 2', '2025-12-16', 'Đã nhập kho', 'Admin', 2, 1, NULL, NULL, NULL),
(5, 'Phiếu yêu cầu nhập kho NVL - KHSX 10', '2025-12-16', 'Chờ duyệt', 'Admin', 10, 1, NULL, NULL, NULL),
(6, 'Phiếu yêu cầu nhập kho NVL - KHSX 3', '2025-12-16', 'Đã nhập kho', 'Admin', 3, 1, NULL, NULL, NULL),
(7, 'Phiếu yêu cầu nhập kho NVL - KHSX 13', '2025-12-16', 'Đã nhập kho', 'Admin', 13, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `san_pham`
--

CREATE TABLE `san_pham` (
  `maSanPham` int(11) NOT NULL,
  `tenSanPham` varchar(100) NOT NULL,
  `loaiSanPham` varchar(50) DEFAULT NULL,
  `soLuongTon` int(11) NOT NULL DEFAULT 0,
  `donVi` varchar(20) DEFAULT NULL,
  `moTa` varchar(255) DEFAULT NULL,
  `trangThaiSanPham` tinyint(1) DEFAULT NULL,
  `maKho` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `san_pham`
--

INSERT INTO `san_pham` (`maSanPham`, `tenSanPham`, `loaiSanPham`, `soLuongTon`, `donVi`, `moTa`, `trangThaiSanPham`, `maKho`) VALUES
(1, 'Áo sơ mi trắng', 'Áo', 4005, 'Cái', 'Áo sơ mi trắng có thêu hoa cúc', 1, NULL),
(2, 'Áo sơ mi xanh dương', 'Áo', 2415, 'Cái', 'Áo tay dài, mỏng, thoáng mát', 0, 1),
(3, 'Áo sơ mi tay ngắn', 'Áo', 12550, 'Cái', 'Tay ngắn, màu trắng', NULL, 2),
(4, 'Áo sơ mi 1', NULL, 0, 'Cái', NULL, NULL, NULL),
(5, 'Áo sơ mi đỏ', 'Áo', 0, 'Cái', 'Áo sơ mi màu đỏ', 1, NULL),
(6, 'Áo sơ mi vàng', 'Áo', 0, 'Cái', 'Áo sơ mi màu vàng', 1, NULL),
(7, 'Áo sơ mi đen', 'Áo', 0, 'Cái', 'Áo sơ mi màu đen', 1, NULL),
(8, 'Áo sơ mi tím', 'Áo', 125, 'Cái', 'Áo sơ mi màu tím', 1, NULL),
(9, 'Áo sơ mi xám', 'Áo', 0, 'Cái', 'Áo sơ mi màu xám', 1, NULL),
(10, 'Áo sơ mi tay dài custom hoa cúc', NULL, 0, 'Cái', NULL, NULL, NULL),
(11, 'Áo mới cà mau', NULL, 0, 'Cái', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `maTK` int(11) NOT NULL,
  `tenDangNhap` varchar(50) NOT NULL,
  `matKhau` varchar(100) NOT NULL,
  `trangThai` varchar(20) DEFAULT 'Hoạt động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `taikhoan`
--

INSERT INTO `taikhoan` (`maTK`, `tenDangNhap`, `matKhau`, `trangThai`) VALUES
(1, 'trankienquoc', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(2, 'nguyenvanan', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(3, 'tranthibinh', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(4, 'leminhcuong', '0ec6e061798a1a86d9afdbdb2475529d', 'Hoạt động'),
(5, 'phamthidung', '827ccb0eea8a706c4c34a16891f84e7b', 'không hoạt động'),
(6, '122232', '$2y$10$XQb4fwZIMx2LZ5hPjaMjh.8e1G7c/SvHYzfgPL559j8LQQWx/ABeq', 'không hoạt động'),
(7, 'trankienquoc122102004', '$2y$10$f0WVQWevy0D4S6T8kITg0eq/9VdNaRExfvhiVlbW6UDLHE9nbA.BC', 'không hoạt động'),
(8, 'quannguyen2002619', '$2y$10$aZ9Sxi5dp0pjzEnUprxtm.0kVrpRxKgxAbUlmyNr9mioxPZNmB.4.', 'không hoạt động'),
(9, '123333', '$2y$10$xLj2YZBkxMHwuFjxzH0vmutPse/sKDiZ2kOk.fYZ0zgbIahFoMt66', 'không hoạt động'),
(10, '1232221', '$2y$10$.QyQpjQWp3shgDbFMxqjn.zbzs7gAHhf/L10kS5jBO36Wuh.bQCa.', 'không hoạt động'),
(11, 'abc', '$2y$10$/d9jbV7WT4yYuJhyFhv6BONaMEfqkxqHN1RBnKsM600HwwrJ7Z.oO', 'Hoạt động'),
(12, 'QKT', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(13, 'duy', '1', 'Hoạt động'),
(15, 'trang', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(16, 'maivu', '$2y$10$tfkm.PX0OiDg44Zi4xIdv.rYTZ8r55WZ6ajaHf.vrh0FqZqNkQRoi', 'Hoạt động'),
(17, 'trankienuoc', '$2y$10$70U1s26.Nx6NoffcJvG3.OwQfbTNTI5FVRo2bHKYKFKOfAHk2NQYW', 'không hoạt động'),
(100, 'giamdoc', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(101, 'qlnhansu', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(102, 'qlsanxuat', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(103, 'qlkhonvl', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(104, 'nhanvienqc', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(105, 'qlkhotp', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(106, 'congnhancat', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(107, 'congnhanmay', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(200, 'qlxuong', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thietbi`
--

CREATE TABLE `thietbi` (
  `maThietBi` int(11) NOT NULL,
  `tenThietBi` varchar(100) NOT NULL,
  `viTri` varchar(100) DEFAULT NULL,
  `trangThai` varchar(50) DEFAULT NULL,
  `maXuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thietbi`
--

INSERT INTO `thietbi` (`maThietBi`, `tenThietBi`, `viTri`, `trangThai`, `maXuong`) VALUES
(7, 'Máy ép nhiệt', '2', 'Đang hoạt động', 1),
(8, 'Máy cắt vải', '2', 'Đang hoạt động', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xuong`
--

CREATE TABLE `xuong` (
  `maXuong` int(11) NOT NULL,
  `tenXuong` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `xuong`
--

INSERT INTO `xuong` (`maXuong`, `tenXuong`) VALUES
(1, 'Xưởng cắt'),
(2, 'Xưởng may');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `baocaoloi`
--
ALTER TABLE `baocaoloi`
  ADD PRIMARY KEY (`maBaoCao`),
  ADD KEY `FK_BCLOI_THIETBI` (`maThietBi`),
  ADD KEY `FK_BCLOI_NGUOIDUNG` (`maND`);

--
-- Chỉ mục cho bảng `calamviec`
--
ALTER TABLE `calamviec`
  ADD PRIMARY KEY (`maCa`);

--
-- Chỉ mục cho bảng `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  ADD PRIMARY KEY (`maCTKHSX`),
  ADD KEY `FK_CTKHSX_KHSX` (`maKHSX`),
  ADD KEY `FK_CTKHSX_GNTP` (`maGNTP`),
  ADD KEY `FK_CTKHSX_XUONG` (`maXuong`),
  ADD KEY `FK_CTKHSX_NVL` (`maNVL`);

--
-- Chỉ mục cho bảng `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  ADD PRIMARY KEY (`maCTPX`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_NVL` (`maNVL`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_Xuong` (`maXuong`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_Phieu` (`maPhieu`);

--
-- Chỉ mục cho bảng `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  ADD PRIMARY KEY (`maCTPKT`),
  ADD KEY `maYC` (`maYC`);

--
-- Chỉ mục cho bảng `chitiet_nhapkhotp`
--
ALTER TABLE `chitiet_nhapkhotp`
  ADD PRIMARY KEY (`maCTNKTP`),
  ADD KEY `maPhieu` (`maPhieu`),
  ADD KEY `maSanPham` (`maSanPham`);

--
-- Chỉ mục cho bảng `chitiet_phieuyeucaucapnvl`
--
ALTER TABLE `chitiet_phieuyeucaucapnvl`
  ADD PRIMARY KEY (`maCTPhieuYCCC`),
  ADD KEY `FK_ChiTiet_Phieu` (`maYCCC`),
  ADD KEY `FK_ChiTiet_NVL` (`maNVL`);

--
-- Chỉ mục cho bảng `chitiet_phieuyeucaunhapkhonvl`
--
ALTER TABLE `chitiet_phieuyeucaunhapkhonvl`
  ADD PRIMARY KEY (`maChiTiet_YCNK`),
  ADD KEY `maYCNK` (`maYCNK`),
  ADD KEY `maNVL` (`maNVL`);

--
-- Chỉ mục cho bảng `congviec`
--
ALTER TABLE `congviec`
  ADD PRIMARY KEY (`maCongViec`),
  ADD KEY `fk_kehoach_congviec` (`maKHSX`),
  ADD KEY `fk_congviec_xuong` (`maXuong`);

--
-- Chỉ mục cho bảng `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  ADD PRIMARY KEY (`maDonHang`),
  ADD KEY `FK_DONHANG_SANPHAM` (`maSanPham`);

--
-- Chỉ mục cho bảng `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  ADD PRIMARY KEY (`maGhiNhan`),
  ADD KEY `FK_GNTP_NGUOIDUNG` (`maNhanVien`),
  ADD KEY `FK_GNTP_SANPHAM` (`maSanPham`),
  ADD KEY `fk_ghinhanthanhphamtheongay_khsx` (`maKHSX`);

--
-- Chỉ mục cho bảng `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  ADD PRIMARY KEY (`maKHSX`),
  ADD KEY `FK_KHSX_NGUOIDUNG` (`maND`),
  ADD KEY `FK_KeHoachSanXuat_DonHangSanXuat` (`maDonHang`);

--
-- Chỉ mục cho bảng `kho`
--
ALTER TABLE `kho`
  ADD PRIMARY KEY (`maKho`);

--
-- Chỉ mục cho bảng `lichsupheduyet`
--
ALTER TABLE `lichsupheduyet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maKHSX` (`maKHSX`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`maND`),
  ADD KEY `FK_NGUOIDUNG_TAIKHOAN` (`maTK`);

--
-- Chỉ mục cho bảng `nhapkhotp`
--
ALTER TABLE `nhapkhotp`
  ADD PRIMARY KEY (`maPhieu`),
  ADD KEY `maYC` (`maYC`);

--
-- Chỉ mục cho bảng `nvl`
--
ALTER TABLE `nvl`
  ADD PRIMARY KEY (`maNVL`),
  ADD KEY `fk_nvl_kho` (`maKho`);

--
-- Chỉ mục cho bảng `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  ADD PRIMARY KEY (`maPNVL`),
  ADD UNIQUE KEY `phieuyeucaunhapkhonvl` (`maYCNK`,`maNVL`),
  ADD KEY `fk_phieunhapnvl_nvl` (`maNVL`);

--
-- Chỉ mục cho bảng `phieuxuatnvl`
--
ALTER TABLE `phieuxuatnvl`
  ADD PRIMARY KEY (`maPhieu`),
  ADD KEY `FK_PhieuXuatNVL_NguoiDung` (`maND`),
  ADD KEY `fk_phieuxuat_yccc` (`maYCCC`);

--
-- Chỉ mục cho bảng `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  ADD PRIMARY KEY (`maPhieuXuat`),
  ADD KEY `maDonHang` (`maDonHang`),
  ADD KEY `maSanPham` (`maSanPham`);

--
-- Chỉ mục cho bảng `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  ADD PRIMARY KEY (`maYCCC`),
  ADD KEY `FK_PhieuYeuCauCungCapNVL_NguoiDung` (`maND`),
  ADD KEY `FK_PhieuYeuCauCungCapNVL_KHSX` (`maKHSX`);

--
-- Chỉ mục cho bảng `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  ADD PRIMARY KEY (`maYC`),
  ADD KEY `FK_PhieuYCKTCL_SanPham` (`maSanPham`),
  ADD KEY `FK_KTCL_ND` (`maND`),
  ADD KEY `FK_KTCL_KHSX` (`maKHSX`);

--
-- Chỉ mục cho bảng `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD PRIMARY KEY (`maYCNK`),
  ADD KEY `FK_YCNK_KHSX` (`maKHSX`),
  ADD KEY `FK_YCNK_ND` (`maND`);

--
-- Chỉ mục cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`maSanPham`),
  ADD KEY `fk_sanpham_kho` (`maKho`);

--
-- Chỉ mục cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`maTK`),
  ADD UNIQUE KEY `tenDangNhap` (`tenDangNhap`);

--
-- Chỉ mục cho bảng `thietbi`
--
ALTER TABLE `thietbi`
  ADD PRIMARY KEY (`maThietBi`),
  ADD KEY `fk_thietbi_xuong` (`maXuong`);

--
-- Chỉ mục cho bảng `xuong`
--
ALTER TABLE `xuong`
  ADD PRIMARY KEY (`maXuong`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `baocaoloi`
--
ALTER TABLE `baocaoloi`
  MODIFY `maBaoCao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT cho bảng `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  MODIFY `maCTKHSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  MODIFY `maCTPX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  MODIFY `maCTPKT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `chitiet_nhapkhotp`
--
ALTER TABLE `chitiet_nhapkhotp`
  MODIFY `maCTNKTP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `chitiet_phieuyeucaucapnvl`
--
ALTER TABLE `chitiet_phieuyeucaucapnvl`
  MODIFY `maCTPhieuYCCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `chitiet_phieuyeucaunhapkhonvl`
--
ALTER TABLE `chitiet_phieuyeucaunhapkhonvl`
  MODIFY `maChiTiet_YCNK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `congviec`
--
ALTER TABLE `congviec`
  MODIFY `maCongViec` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  MODIFY `maDonHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  MODIFY `maGhiNhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  MODIFY `maKHSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `kho`
--
ALTER TABLE `kho`
  MODIFY `maKho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `lichsupheduyet`
--
ALTER TABLE `lichsupheduyet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `maND` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT cho bảng `nhapkhotp`
--
ALTER TABLE `nhapkhotp`
  MODIFY `maPhieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `nvl`
--
ALTER TABLE `nvl`
  MODIFY `maNVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  MODIFY `maPNVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `phieuxuatnvl`
--
ALTER TABLE `phieuxuatnvl`
  MODIFY `maPhieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  MODIFY `maPhieuXuat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  MODIFY `maYCCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  MODIFY `maYC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  MODIFY `maYCNK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `maSanPham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `maTK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT cho bảng `thietbi`
--
ALTER TABLE `thietbi`
  MODIFY `maThietBi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `xuong`
--
ALTER TABLE `xuong`
  MODIFY `maXuong` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baocaoloi`
--
ALTER TABLE `baocaoloi`
  ADD CONSTRAINT `FK_BCL_ND_ID` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `FK_BCL_THIETBI_ID` FOREIGN KEY (`maThietBi`) REFERENCES `thietbi` (`maThietBi`);

--
-- Các ràng buộc cho bảng `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  ADD CONSTRAINT `FK_CTKHSX_GNTP` FOREIGN KEY (`maGNTP`) REFERENCES `ghinhanthanhphamtheongay` (`maGhiNhan`),
  ADD CONSTRAINT `FK_CTKHSX_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_CTKHSX_NVL` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`),
  ADD CONSTRAINT `FK_CTKHSX_XUONG` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`);

--
-- Các ràng buộc cho bảng `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  ADD CONSTRAINT `FK_ChiTietPhieuXuatNVL_Phieu` FOREIGN KEY (`maPhieu`) REFERENCES `phieuxuatnvl` (`maPhieu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  ADD CONSTRAINT `chitietphieuyeucaukiemtrachatluong_ibfk_1` FOREIGN KEY (`maYC`) REFERENCES `phieuyeucaukiemtrachatluong` (`maYC`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chitiet_nhapkhotp`
--
ALTER TABLE `chitiet_nhapkhotp`
  ADD CONSTRAINT `chitiet_nhapkhotp_ibfk_1` FOREIGN KEY (`maPhieu`) REFERENCES `nhapkhotp` (`maPhieu`) ON DELETE CASCADE,
  ADD CONSTRAINT `chitiet_nhapkhotp_ibfk_2` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng buộc cho bảng `chitiet_phieuyeucaucapnvl`
--
ALTER TABLE `chitiet_phieuyeucaucapnvl`
  ADD CONSTRAINT `FK_CT_NVL_ID` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`),
  ADD CONSTRAINT `FK_CT_YCCC_ID` FOREIGN KEY (`maYCCC`) REFERENCES `phieuyeucaucungcapnvl` (`maYCCC`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `chitiet_phieuyeucaunhapkhonvl`
--
ALTER TABLE `chitiet_phieuyeucaunhapkhonvl`
  ADD CONSTRAINT `FK_CT_YCNK_ID` FOREIGN KEY (`maYCNK`) REFERENCES `phieuyeucaunhapkhonvl` (`maYCNK`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CT_YCNK_NVL` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`);

--
-- Các ràng buộc cho bảng `congviec`
--
ALTER TABLE `congviec`
  ADD CONSTRAINT `fk_congviec_xuong` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`),
  ADD CONSTRAINT `fk_kehoach_congviec` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`);

--
-- Các ràng buộc cho bảng `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  ADD CONSTRAINT `FK_DONHANG_SANPHAM` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng buộc cho bảng `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  ADD CONSTRAINT `FK_GNTP_NGUOIDUNG` FOREIGN KEY (`maNhanVien`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `FK_GNTP_SANPHAM` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`),
  ADD CONSTRAINT `fk_ghinhanthanhphamtheongay_khsx` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`);

--
-- Các ràng buộc cho bảng `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  ADD CONSTRAINT `FK_KHSX_NGUOIDUNG` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `FK_KeHoachSanXuat_DonHangSanXuat` FOREIGN KEY (`maDonHang`) REFERENCES `donhangsanxuat` (`maDonHang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `lichsupheduyet`
--
ALTER TABLE `lichsupheduyet`
  ADD CONSTRAINT `lichsupheduyet_ibfk_1` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`);

--
-- Các ràng buộc cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `FK_NGUOIDUNG_TAIKHOAN` FOREIGN KEY (`maTK`) REFERENCES `taikhoan` (`maTK`);

--
-- Các ràng buộc cho bảng `nvl`
--
ALTER TABLE `nvl`
  ADD CONSTRAINT `fk_nvl_kho` FOREIGN KEY (`maKho`) REFERENCES `kho` (`maKho`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `phieuxuatnvl`
--
ALTER TABLE `phieuxuatnvl`
  ADD CONSTRAINT `FK_PX_ND` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `FK_PX_YCCC` FOREIGN KEY (`maYCCC`) REFERENCES `phieuyeucaucungcapnvl` (`maYCCC`);

--
-- Các ràng buộc cho bảng `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  ADD CONSTRAINT `FK_PXTP_DONHANG` FOREIGN KEY (`maDonHang`) REFERENCES `donhangsanxuat` (`maDonHang`),
  ADD CONSTRAINT `FK_PXTP_SANPHAM` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng buộc cho bảng `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  ADD CONSTRAINT `FK_YCCC_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_YCCC_ND` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`);

--
-- Các ràng buộc cho bảng `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  ADD CONSTRAINT `FK_KTCL_KHSX_NEW` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_KTCL_NGUOIDUNG` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`);

--
-- Các ràng buộc cho bảng `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD CONSTRAINT `FK_YCNK_KHSX_ID` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_YCNK_ND_ID` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
