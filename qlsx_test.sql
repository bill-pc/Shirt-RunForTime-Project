-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2025 at 10:34 PM
-- Server version: 8.0.43
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qlsx_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `baocaoloi`
--

CREATE TABLE `baocaoloi` (
  `maBaoCao` int NOT NULL,
  `tenBaoCao` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `loaiLoi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hinhAnh` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '0',
  `thoiGian` date DEFAULT NULL,
  `moTa` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `maThietBi` int DEFAULT NULL,
  `maND` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `baocaoloi`
--

INSERT INTO `baocaoloi` (`maBaoCao`, `tenBaoCao`, `loaiLoi`, `hinhAnh`, `thoiGian`, `moTa`, `maThietBi`, `maND`) VALUES
(49, 'Báo cáo sự cố - Máy may hãng A - Nguyễn Văn An', 'phancung', NULL, '2025-11-08', '', 9, 6),
(50, 'Báo cáo sự cố - Máy ép nhiệt - TranKienQuoc', 'phancung', NULL, '2025-11-08', '', 7, 1),
(51, 'Báo cáo sự cố - Máy may D - TranKienQuoc', 'phancung', NULL, '2025-11-09', '', 10, 1),
(52, 'Báo cáo sự cố - Máy cắt vải - TranKienQuoc', 'phancung', NULL, '2025-11-09', '', 8, 1),
(53, 'Báo cáo sự cố - Máy may hãng A - TranKienQuoc', 'phanmem', NULL, '2025-11-09', '', 9, 1),
(54, 'Báo cáo sự cố - Máy ép nhiệt - TranKienQuoc', 'phanmem', 'uploads/img1763087644_hinh-nen-hoa-mau-don-1.jpg', '2025-11-14', '', 7, 1),
(55, 'Báo cáo sự cố - Máy cắt vải - TranKienQuoc', 'khac', 'uploads/img/1763087805_z5274512085563_3acd4ad5b0faf289efc6542709efbac3.jpg', '2025-11-14', '', 8, 1),
(56, 'Báo cáo sự cố - Máy ép nhiệt - TranKienQuoc', 'phancung', 'uploads/img/1763089681_TheSV.jpg', '2025-11-14', '', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `calamviec`
--

CREATE TABLE `calamviec` (
  `maCa` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `tenCa` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `gioBatDau` time NOT NULL,
  `gioKetThuc` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calamviec`
--

INSERT INTO `calamviec` (`maCa`, `tenCa`, `gioBatDau`, `gioKetThuc`) VALUES
('CA_CHIEU', '', '13:00:00', '17:30:00'),
('CA_SANG', '', '07:30:00', '11:30:00'),
('CA_TOI', '', '18:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `chitietkehoachsanxuat`
--

CREATE TABLE `chitietkehoachsanxuat` (
  `maCTKHSX` int NOT NULL,
  `maKHSX` int NOT NULL,
  `maGNTP` int DEFAULT NULL,
  `maXuong` int NOT NULL,
  `maNVL` int NOT NULL,
  `tenNVL` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `loaiNVL` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `soLuongNVL` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitietkehoachsanxuat`
--

INSERT INTO `chitietkehoachsanxuat` (`maCTKHSX`, `maKHSX`, `maGNTP`, `maXuong`, `maNVL`, `tenNVL`, `loaiNVL`, `soLuongNVL`) VALUES
(2, 1, 2, 1, 1, 'Vải cotton loại 1', 'Vải', 20),
(3, 1, 2, 2, 2, 'Nút áo trơn', 'Phụ kiện', 200),
(4, 2, 2, 1, 1, 'Vải cotton loại 1', 'Vải', 300),
(5, 2, 2, 2, 3, 'Chỉ đen mỏng ', 'Chỉ', 300),
(6, 3, 3, 1, 1, 'Vải cotton loại 1', 'Vải', 120),
(7, 3, 3, 2, 3, 'Chỉ đen mỏng ', 'Chỉ', 230),
(8, 3, 3, 2, 2, 'Nút áo xám', 'Phụ kiện', 340),
(11, 10, NULL, 1, 1, 'Vải cotton', 'Vải', 23),
(12, 10, NULL, 2, 2, 'Nút áo', 'Phụ kiện', 89);

-- --------------------------------------------------------

--
-- Table structure for table `chitietphieuxuatnvl`
--

CREATE TABLE `chitietphieuxuatnvl` (
  `maCTPX` int NOT NULL,
  `maNVL` int NOT NULL,
  `tenNVL` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soLuong` int NOT NULL,
  `maPhieu` int NOT NULL,
  `maXuong` int NOT NULL,
  `ghiChu` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chitietphieuyeucaukiemtrachatluong`
--

CREATE TABLE `chitietphieuyeucaukiemtrachatluong` (
  `maCTPKT` int NOT NULL,
  `maSanPham` int NOT NULL,
  `tenSanPham` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `soLuong` int NOT NULL DEFAULT '0',
  `donViTinh` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `maYC` int NOT NULL,
  `trangThaiSanPham` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Chờ kiểm tra',
  `soLuongDat` int DEFAULT '0',
  `soLuongHong` int DEFAULT '0',
  `ghiChu` text COLLATE utf8mb4_general_ci,
  `ngayKiemTra` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitietphieuyeucaukiemtrachatluong`
--

INSERT INTO `chitietphieuyeucaukiemtrachatluong` (`maCTPKT`, `maSanPham`, `tenSanPham`, `soLuong`, `donViTinh`, `maYC`, `trangThaiSanPham`, `soLuongDat`, `soLuongHong`, `ghiChu`, `ngayKiemTra`) VALUES
(1, 4, 'Áo sơ mi xanh', 200, 'Cái', 4, 'Đã kiểm tra', 180, 20, '', '2025-12-06 02:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_lichlamviec`
--

CREATE TABLE `chitiet_lichlamviec` (
  `maLichLam` int NOT NULL,
  `maND` char(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ngayLam` date NOT NULL,
  `maCa` char(10) COLLATE utf8mb3_unicode_ci NOT NULL,
  `maXuong` char(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `chitiet_lichlamviec`
--

INSERT INTO `chitiet_lichlamviec` (`maLichLam`, `maND`, `ngayLam`, `maCa`, `maXuong`) VALUES
(1, '1', '2025-11-14', 'CA_SANG', '1'),
(2, '1', '2025-11-14', 'CA_CHIEU', '1'),
(3, '1', '2025-11-15', 'CA_SANG', '1'),
(4, '1', '2025-11-15', 'CA_CHIEU', '1'),
(5, '1', '2025-11-16', 'CA_SANG', '1'),
(6, '1', '2025-11-16', 'CA_CHIEU', '1'),
(7, '1', '2025-11-16', 'CA_TOI', '1'),
(8, '1', '2025-11-17', 'CA_SANG', '1'),
(9, '1', '2025-11-17', 'CA_CHIEU', '1'),
(10, '1', '2025-11-18', 'CA_SANG', '1'),
(11, '1', '2025-11-18', 'CA_CHIEU', '1'),
(12, '1', '2025-11-19', 'CA_SANG', '1'),
(13, '1', '2025-11-19', 'CA_CHIEU', '1'),
(14, '1', '2025-11-19', 'CA_TOI', '1');

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_phieuyeucaucapnvl`
--

CREATE TABLE `chitiet_phieuyeucaucapnvl` (
  `maCTPhieuYCCC` int NOT NULL,
  `tenNVL` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nhaCungCap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soLuong` int NOT NULL,
  `donViTinh` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `maYCCC` int NOT NULL,
  `maNVL` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitiet_phieuyeucaucapnvl`
--

INSERT INTO `chitiet_phieuyeucaucapnvl` (`maCTPhieuYCCC`, `tenNVL`, `nhaCungCap`, `soLuong`, `donViTinh`, `maYCCC`, `maNVL`) VALUES
(36, 'Vải cotton', NULL, 20, 'Tấm', 24, 1),
(37, 'Nút áo', NULL, 200, 'Cái', 24, 2),
(38, 'Vải cotton', NULL, 20, 'Tấm', 25, 1),
(39, 'Nút áo', NULL, 200, 'Cái', 25, 2),
(40, 'Vải cotton', NULL, 300, 'Tấm', 26, 1),
(41, 'Chỉ may đen', NULL, 300, 'Cuộn', 26, 3),
(42, 'Vải cotton', NULL, 20, 'Tấm', 27, 1),
(43, 'Nút áo', NULL, 200, 'Cái', 27, 2),
(44, 'Vải cotton', NULL, 300, 'Tấm', 28, 1),
(45, 'Chỉ may đen', NULL, 300, 'Cuộn', 28, 3),
(46, 'Vải cotton', NULL, 20, 'Tấm', 29, 1),
(47, 'Nút áo', NULL, 200, 'Cái', 29, 2),
(48, 'Vải cotton', NULL, 20, 'Tấm', 30, 1),
(49, 'Nút áo', NULL, 200, 'Cái', 30, 2);

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_phieuyeucaunhapkhonvl`
--

CREATE TABLE `chitiet_phieuyeucaunhapkhonvl` (
  `maChiTiet_YCNK` int NOT NULL,
  `maYCNK` int NOT NULL,
  `maNVL` int NOT NULL,
  `tenNVL` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soLuong` int DEFAULT NULL,
  `donViTinh` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nhaCungCap` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `soLuongTonKho` int NOT NULL,
  `soLuongCanNhap` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitiet_phieuyeucaunhapkhonvl`
--

INSERT INTO `chitiet_phieuyeucaunhapkhonvl` (`maChiTiet_YCNK`, `maYCNK`, `maNVL`, `tenNVL`, `soLuong`, `donViTinh`, `nhaCungCap`, `soLuongTonKho`, `soLuongCanNhap`) VALUES
(2, 1, 1, 'nút áo', 200, 'Cái', '', 100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `congviec`
--

CREATE TABLE `congviec` (
  `maCongViec` int NOT NULL,
  `tieuDe` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `moTa` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `trangThai` varchar(30) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Đang thực hiện',
  `ngayHetHan` date NOT NULL,
  `maKHSX` int NOT NULL,
  `maXuong` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donhangsanxuat`
--

CREATE TABLE `donhangsanxuat` (
  `maDonHang` int NOT NULL,
  `tenDonHang` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tenSanPham` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `soLuongSanXuat` int NOT NULL,
  `donVi` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `diaChiNhan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `trangThai` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ngayGiao` date NOT NULL,
  `maSanPham` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donhangsanxuat`
--

INSERT INTO `donhangsanxuat` (`maDonHang`, `tenDonHang`, `tenSanPham`, `soLuongSanXuat`, `donVi`, `diaChiNhan`, `trangThai`, `ngayGiao`, `maSanPham`) VALUES
(1, ' DHSX1', 'Áo sơ mi hoa cúc', 2000, 'Cai', 'Nguyen Oanh', 'Đã xuất kho', '2025-10-31', 1),
(2, 'DHSX2', 'Áo sơ mi xanh dương', 1000, 'Cái', 'ABC', 'Đã xuất kho', '2025-10-31', 2),
(3, 'DHSX4', 'Áo sơ mi tay ngắn', 3500, 'Cái', 'Nguyễn Văn Bảo', 'Đang thực hiện', '2025-11-28', 3),
(5, 'DHSX5', 'Áo sơ mi 1', 200, 'Cái', '58 Quang Trung, Gò Vấp', 'Đang thực hiện', '2025-12-06', 4),
(6, 'DHSX6', 'Áo sơ mi tay ngắn', 200, 'Cái', 'iuowqiueoq', 'Đang thực hiện', '2025-12-11', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ghinhanthanhphamtheongay`
--

CREATE TABLE `ghinhanthanhphamtheongay` (
  `maGhiNhan` int NOT NULL,
  `maNhanVien` int NOT NULL,
  `maSanPham` int NOT NULL,
  `soLuongSPHoanThanh` int NOT NULL,
  `ngayLam` date NOT NULL,
  `maKHSX` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ghinhanthanhphamtheongay`
--

INSERT INTO `ghinhanthanhphamtheongay` (`maGhiNhan`, `maNhanVien`, `maSanPham`, `soLuongSPHoanThanh`, `ngayLam`, `maKHSX`) VALUES
(2, 1, 1, 20, '2025-10-28', 1),
(3, 1, 1, 30, '2025-10-29', 1),
(4, 1, 1, 25, '2025-10-31', 1),
(5, 1, 1, 40, '2025-11-03', 1),
(6, 15, 1, 25, '2025-11-04', 1),
(7, 7, 1, 35, '2025-10-30', 1),
(8, 8, 1, 20, '2025-12-05', 1),
(9, 7, 1, 15, '2025-12-05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kehoachsanxuat`
--

CREATE TABLE `kehoachsanxuat` (
  `maKHSX` int NOT NULL,
  `tenKHSX` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `maDonHang` int NOT NULL,
  `maSanPham` int NOT NULL,
  `thoiGianBatDau` date NOT NULL,
  `thoiGianKetThuc` date NOT NULL,
  `trangThai` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Chờ duyệt',
  `maND` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kehoachsanxuat`
--

INSERT INTO `kehoachsanxuat` (`maKHSX`, `tenKHSX`, `maDonHang`, `maSanPham`, `thoiGianBatDau`, `thoiGianKetThuc`, `trangThai`, `maND`) VALUES
(1, 'KHSX1', 1, 1, '2025-10-01', '2025-10-31', 'Đã duyệt', 1),
(2, 'KHSX2', 2, 2, '2025-10-09', '2025-10-31', 'Đã duyệt', 1),
(3, 'KHSX3', 3, 3, '2025-10-01', '2025-11-06', 'Đã duyệt', 1),
(4, 'KHSX cho ĐH 5', 5, 4, '2025-11-26', '2025-12-06', 'Chờ duyệt', 1),
(5, 'KHSX cho ĐH 5', 5, 3, '2025-11-26', '2025-12-06', 'Chờ duyệt', 1),
(6, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Chờ duyệt', 1),
(7, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Chờ duyệt', 1),
(8, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Chờ duyệt', 1),
(9, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Chờ duyệt', 1),
(10, 'KHSX cho ĐH 6', 6, 3, '2025-12-01', '2025-12-11', 'Chờ duyệt', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kho`
--

CREATE TABLE `kho` (
  `maKho` int NOT NULL,
  `tenKho` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `diaChi` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kho`
--

INSERT INTO `kho` (`maKho`, `tenKho`, `diaChi`) VALUES
(1, 'Kho Nguyên Vật Liệu', NULL),
(2, 'Kho Thành Phẩm', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lichsupheduyet`
--

CREATE TABLE `lichsupheduyet` (
  `id` int NOT NULL,
  `maKHSX` int NOT NULL,
  `hanhDong` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ghiChu` text COLLATE utf8mb4_general_ci,
  `nguoiThucHien` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `thoiGian` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lichsupheduyet`
--

INSERT INTO `lichsupheduyet` (`id`, `maKHSX`, `hanhDong`, `ghiChu`, `nguoiThucHien`, `thoiGian`) VALUES
(1, 1, 'Đã duyệt', '', 'TranKienQuoc', '2025-11-08 14:13:17'),
(2, 2, 'Từ chối', '', 'TranKienQuoc', '2025-11-08 14:13:42'),
(3, 1, 'Đã duyệt', '', 'TranKienQuoc', '2025-11-14 09:49:26');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `maND` int NOT NULL,
  `hoTen` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `gioiTinh` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `ngaySinh` date DEFAULT NULL,
  `chucVu` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phongBan` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `soDienThoai` varchar(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `diaChi` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `maTK` int NOT NULL,
  `trangThai` tinyint(1) DEFAULT '1',
  `hinhAnh` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`maND`, `hoTen`, `gioiTinh`, `ngaySinh`, `chucVu`, `phongBan`, `soDienThoai`, `email`, `diaChi`, `maTK`, `trangThai`, `hinhAnh`) VALUES
(1, 'TranKienQuoc', 'Nam', '2004-10-12', 'Giám đốc', '', '0346512104', 'trankienquoc@gmail.com', '54/12 Quang Trung, Gò Vấp', 1, 1, 'avatar1.png'),
(6, 'Nguyễn Văn B', 'Nam', NULL, 'Trưởng phòng', 'QLNVL', '0901234567', 'an.nguyen@company.com', '123 Võ Văn Tần, Q.3, TP.HCM', 2, 1, ''),
(7, 'Trần Thị Bình', 'Nữ', NULL, 'Nhân viên', 'Xưởng may', '0987654321', 'binh.tran@company.com', '456 Lê Lợi, Q.1, TP.HCM', 3, 1, ''),
(8, 'Lê Minh Cường', 'Nam', NULL, 'Kỹ thuật viên', 'Xưởng cắt', '0912345678', 'cuong.le@company.com', '789 Nguyễn Trãi, Q.5, TP.HCM', 4, 1, ''),
(15, 'Mai Van Vu', 'Nam', NULL, 'Nhân viên xưởng Cắt', '', '12222222222', '1232221@gmail.com', '581 Nguyen Oanh', 10, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `nvl`
--

CREATE TABLE `nvl` (
  `maNVL` int NOT NULL,
  `tenNVL` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `loaiNVL` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soLuongTonKho` int NOT NULL DEFAULT '0',
  `donViTinh` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `moTa` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `maKho` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nvl`
--

INSERT INTO `nvl` (`maNVL`, `tenNVL`, `loaiNVL`, `soLuongTonKho`, `donViTinh`, `moTa`, `maKho`) VALUES
(1, 'Vải cotton', 'Vải', 100, 'Tấm', '2m x 3m', NULL),
(2, 'Nút áo', 'Phụ kiện', 1000, 'Cái', 'Nút áo trắng', NULL),
(3, 'Chỉ may đen', 'Chỉ', 500, 'Cuộn', 'Chỉ may màu trắng', 1),
(4, 'Nút áo', 'Phụ kiện', 200, 'Cái', 'Nút áo màu đen', 1),
(5, 'Vải cotton', 'Vải', 300, 'Tấm', 'Vải cotton trắng', 1),
(6, 'Chỉ may trắng', 'Chỉ', 3000, 'Cuộn', 'Chỉ may màu trắng, mỏng', 1);

-- --------------------------------------------------------

--
-- Table structure for table `phieunhapnvl`
--

CREATE TABLE `phieunhapnvl` (
  `maPNVL` int NOT NULL,
  `tenPNVL` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nguoiLap` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `nhaCungCap` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `ngayNhap` date NOT NULL,
  `maYCNK` int NOT NULL,
  `maNVL` int DEFAULT NULL,
  `soLuongNhap` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieunhapnvl`
--

INSERT INTO `phieunhapnvl` (`maPNVL`, `tenPNVL`, `nguoiLap`, `nhaCungCap`, `ngayNhap`, `maYCNK`, `maNVL`, `soLuongNhap`) VALUES
(1, 'Phiếu nhập nguyên vật liệu', 'ông a', 'abc', '2025-10-30', 1, 1, 0),
(6, 'phieu nhap kho', 'avd', ' sdsd', '2025-10-23', 2, 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `phieuxuatnvl`
--

CREATE TABLE `phieuxuatnvl` (
  `maPhieu` int NOT NULL,
  `tenPhieu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tenNguoiLap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `ngayLap` date NOT NULL,
  `maND` int NOT NULL,
  `maYCCC` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieuxuatthanhpham`
--

CREATE TABLE `phieuxuatthanhpham` (
  `maPhieuXuat` int NOT NULL,
  `maDonHang` int NOT NULL,
  `maSanPham` int NOT NULL,
  `soLuongXuat` int NOT NULL,
  `ngayXuat` date NOT NULL,
  `ghiChu` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieuxuatthanhpham`
--

INSERT INTO `phieuxuatthanhpham` (`maPhieuXuat`, `maDonHang`, `maSanPham`, `soLuongXuat`, `ngayXuat`, `ghiChu`) VALUES
(1, 1, 1, 5, '2025-10-30', ''),
(2, 2, 2, 200, '2025-11-03', '');

-- --------------------------------------------------------

--
-- Table structure for table `phieuyeucaucungcapnvl`
--

CREATE TABLE `phieuyeucaucungcapnvl` (
  `maYCCC` int NOT NULL,
  `ngayLap` date NOT NULL,
  `trangThai` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Chờ duyệt',
  `tenNguoiLap` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `maND` int NOT NULL,
  `maKHSX` int NOT NULL,
  `tenPhieu` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ghiChu` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieuyeucaucungcapnvl`
--

INSERT INTO `phieuyeucaucungcapnvl` (`maYCCC`, `ngayLap`, `trangThai`, `tenNguoiLap`, `maND`, `maKHSX`, `tenPhieu`, `ghiChu`) VALUES
(30, '2025-11-21', 'Chờ duyệt', 'TranKienQuoc', 1, 1, 'Yêu cầu NVL cho KHSX1', '');

-- --------------------------------------------------------

--
-- Table structure for table `phieuyeucaukiemtrachatluong`
--

CREATE TABLE `phieuyeucaukiemtrachatluong` (
  `maYC` int NOT NULL,
  `tenPhieu` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `maSanPham` int NOT NULL,
  `trangThai` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `ngayLap` date NOT NULL,
  `tenNguoiLap` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `maND` int NOT NULL,
  `maKHSX` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieuyeucaukiemtrachatluong`
--

INSERT INTO `phieuyeucaukiemtrachatluong` (`maYC`, `tenPhieu`, `maSanPham`, `trangThai`, `ngayLap`, `tenNguoiLap`, `maND`, `maKHSX`) VALUES
(4, 'Phiếu KTCL1', 4, 'Đã duyệt', '2025-11-12', 'Trần Kiến Quốc', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `phieuyeucaunhapkhonvl`
--

CREATE TABLE `phieuyeucaunhapkhonvl` (
  `maYCNK` int NOT NULL,
  `tenPhieu` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `ngayLap` date NOT NULL,
  `trangThai` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Chờ duyệt',
  `tenNguoiLap` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `maKHSX` int NOT NULL,
  `maND` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieuyeucaunhapkhonvl`
--

INSERT INTO `phieuyeucaunhapkhonvl` (`maYCNK`, `tenPhieu`, `ngayLap`, `trangThai`, `tenNguoiLap`, `maKHSX`, `maND`) VALUES
(1, 'Phiếu NK1', '2025-11-04', 'Chờ duyệt', 'Trần Kiến Quốc', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
--

CREATE TABLE `san_pham` (
  `maSanPham` int NOT NULL,
  `tenSanPham` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `loaiSanPham` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `soLuongTon` int NOT NULL DEFAULT '0',
  `donVi` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `moTa` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `trangThaiSanPham` tinyint(1) DEFAULT NULL,
  `maKho` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`maSanPham`, `tenSanPham`, `loaiSanPham`, `soLuongTon`, `donVi`, `moTa`, `trangThaiSanPham`, `maKho`) VALUES
(1, 'Áo sơ mi trắng', 'Áo', 5, 'Cái', 'Áo sơ mi trắng có thêu hoa cúc', 1, NULL),
(2, 'Áo sơ mi xanh dương', 'Áo', 100, 'Cái', 'Áo tay dài, mỏng, thoáng mát', 0, 1),
(3, 'Áo sơ mi tay ngắn', 'Áo', 550, 'Cái', 'Tay ngắn, màu trắng', NULL, 2),
(4, 'Áo sơ mi 1', NULL, 0, 'Cái', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `maTK` int NOT NULL,
  `tenDangNhap` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `matKhau` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `trangThai` varchar(20) COLLATE utf8mb4_general_ci DEFAULT 'Hoạt động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoan`
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
(13, 'duy', '1', 'Hoạt động');

-- --------------------------------------------------------

--
-- Table structure for table `thietbi`
--

CREATE TABLE `thietbi` (
  `maThietBi` int NOT NULL,
  `tenThietBi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `viTri` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `trangThai` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `maXuong` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `thietbi`
--

INSERT INTO `thietbi` (`maThietBi`, `tenThietBi`, `viTri`, `trangThai`, `maXuong`) VALUES
(7, 'Máy ép nhiệt', '2', 'Đang hoạt động', 1),
(8, 'Máy cắt vải', '2', 'Đang hoạt động', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xuong`
--

CREATE TABLE `xuong` (
  `maXuong` int NOT NULL,
  `tenXuong` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `xuong`
--

INSERT INTO `xuong` (`maXuong`, `tenXuong`) VALUES
(1, 'Xưởng cắt'),
(2, 'Xưởng may');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baocaoloi`
--
ALTER TABLE `baocaoloi`
  ADD PRIMARY KEY (`maBaoCao`),
  ADD KEY `FK_BCLOI_THIETBI` (`maThietBi`),
  ADD KEY `FK_BCLOI_NGUOIDUNG` (`maND`);

--
-- Indexes for table `calamviec`
--
ALTER TABLE `calamviec`
  ADD PRIMARY KEY (`maCa`);

--
-- Indexes for table `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  ADD PRIMARY KEY (`maCTKHSX`),
  ADD KEY `FK_CTKHSX_KHSX` (`maKHSX`),
  ADD KEY `FK_CTKHSX_GNTP` (`maGNTP`),
  ADD KEY `FK_CTKHSX_XUONG` (`maXuong`),
  ADD KEY `FK_CTKHSX_NVL` (`maNVL`);

--
-- Indexes for table `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  ADD PRIMARY KEY (`maCTPX`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_NVL` (`maNVL`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_Xuong` (`maXuong`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_Phieu` (`maPhieu`);

--
-- Indexes for table `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  ADD PRIMARY KEY (`maCTPKT`),
  ADD KEY `FK_CTPKT_SanPham` (`maSanPham`),
  ADD KEY `FK_CTPKT_PhieuYCKTCL` (`maYC`);

--
-- Indexes for table `chitiet_phieuyeucaucapnvl`
--
ALTER TABLE `chitiet_phieuyeucaucapnvl`
  ADD PRIMARY KEY (`maCTPhieuYCCC`),
  ADD KEY `FK_ChiTiet_Phieu` (`maYCCC`),
  ADD KEY `FK_ChiTiet_NVL` (`maNVL`);

--
-- Indexes for table `chitiet_phieuyeucaunhapkhonvl`
--
ALTER TABLE `chitiet_phieuyeucaunhapkhonvl`
  ADD PRIMARY KEY (`maChiTiet_YCNK`),
  ADD KEY `maYCNK` (`maYCNK`),
  ADD KEY `maNVL` (`maNVL`);

--
-- Indexes for table `congviec`
--
ALTER TABLE `congviec`
  ADD PRIMARY KEY (`maCongViec`),
  ADD KEY `fk_kehoach_congviec` (`maKHSX`),
  ADD KEY `fk_congviec_xuong` (`maXuong`);

--
-- Indexes for table `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  ADD PRIMARY KEY (`maDonHang`),
  ADD KEY `FK_DONHANG_SANPHAM` (`maSanPham`);

--
-- Indexes for table `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  ADD PRIMARY KEY (`maGhiNhan`),
  ADD KEY `FK_GNTP_NGUOIDUNG` (`maNhanVien`),
  ADD KEY `FK_GNTP_SANPHAM` (`maSanPham`),
  ADD KEY `fk_ghinhanthanhphamtheongay_khsx` (`maKHSX`);

--
-- Indexes for table `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  ADD PRIMARY KEY (`maKHSX`),
  ADD KEY `FK_KHSX_NGUOIDUNG` (`maND`),
  ADD KEY `FK_KeHoachSanXuat_DonHangSanXuat` (`maDonHang`);

--
-- Indexes for table `kho`
--
ALTER TABLE `kho`
  ADD PRIMARY KEY (`maKho`);

--
-- Indexes for table `lichsupheduyet`
--
ALTER TABLE `lichsupheduyet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maKHSX` (`maKHSX`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`maND`),
  ADD KEY `FK_NGUOIDUNG_TAIKHOAN` (`maTK`);

--
-- Indexes for table `nvl`
--
ALTER TABLE `nvl`
  ADD PRIMARY KEY (`maNVL`),
  ADD KEY `fk_nvl_kho` (`maKho`);

--
-- Indexes for table `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  ADD PRIMARY KEY (`maPNVL`),
  ADD UNIQUE KEY `phieuyeucaunhapkhonvl` (`maYCNK`),
  ADD KEY `fk_phieunhapnvl_nvl` (`maNVL`);

--
-- Indexes for table `phieuxuatnvl`
--
ALTER TABLE `phieuxuatnvl`
  ADD PRIMARY KEY (`maPhieu`),
  ADD KEY `FK_PhieuXuatNVL_NguoiDung` (`maND`),
  ADD KEY `fk_phieuxuat_yccc` (`maYCCC`);

--
-- Indexes for table `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  ADD PRIMARY KEY (`maPhieuXuat`),
  ADD KEY `maDonHang` (`maDonHang`),
  ADD KEY `maSanPham` (`maSanPham`);

--
-- Indexes for table `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  ADD PRIMARY KEY (`maYCCC`),
  ADD KEY `FK_PhieuYeuCauCungCapNVL_NguoiDung` (`maND`),
  ADD KEY `FK_PhieuYeuCauCungCapNVL_KHSX` (`maKHSX`);

--
-- Indexes for table `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  ADD PRIMARY KEY (`maYC`),
  ADD KEY `FK_PhieuYCKTCL_SanPham` (`maSanPham`),
  ADD KEY `FK_KTCL_ND` (`maND`),
  ADD KEY `FK_KTCL_KHSX` (`maKHSX`);

--
-- Indexes for table `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD PRIMARY KEY (`maYCNK`),
  ADD KEY `FK_YCNK_KHSX` (`maKHSX`),
  ADD KEY `FK_YCNK_ND` (`maND`);

--
-- Indexes for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`maSanPham`),
  ADD KEY `fk_sanpham_kho` (`maKho`);

--
-- Indexes for table `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`maTK`),
  ADD UNIQUE KEY `tenDangNhap` (`tenDangNhap`);

--
-- Indexes for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD PRIMARY KEY (`maThietBi`),
  ADD KEY `fk_thietbi_xuong` (`maXuong`);

--
-- Indexes for table `xuong`
--
ALTER TABLE `xuong`
  ADD PRIMARY KEY (`maXuong`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baocaoloi`
--
ALTER TABLE `baocaoloi`
  MODIFY `maBaoCao` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  MODIFY `maCTKHSX` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  MODIFY `maCTPX` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  MODIFY `maCTPKT` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chitiet_phieuyeucaucapnvl`
--
ALTER TABLE `chitiet_phieuyeucaucapnvl`
  MODIFY `maCTPhieuYCCC` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `chitiet_phieuyeucaunhapkhonvl`
--
ALTER TABLE `chitiet_phieuyeucaunhapkhonvl`
  MODIFY `maChiTiet_YCNK` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `congviec`
--
ALTER TABLE `congviec`
  MODIFY `maCongViec` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  MODIFY `maDonHang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  MODIFY `maGhiNhan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  MODIFY `maKHSX` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `kho`
--
ALTER TABLE `kho`
  MODIFY `maKho` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lichsupheduyet`
--
ALTER TABLE `lichsupheduyet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `maND` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nvl`
--
ALTER TABLE `nvl`
  MODIFY `maNVL` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  MODIFY `maPNVL` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `phieuxuatnvl`
--
ALTER TABLE `phieuxuatnvl`
  MODIFY `maPhieu` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  MODIFY `maPhieuXuat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  MODIFY `maYCCC` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  MODIFY `maYC` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  MODIFY `maYCNK` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `maSanPham` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `maTK` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `thietbi`
--
ALTER TABLE `thietbi`
  MODIFY `maThietBi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `xuong`
--
ALTER TABLE `xuong`
  MODIFY `maXuong` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  ADD CONSTRAINT `FK_CTKHSX_GNTP` FOREIGN KEY (`maGNTP`) REFERENCES `ghinhanthanhphamtheongay` (`maGhiNhan`),
  ADD CONSTRAINT `FK_CTKHSX_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_CTKHSX_NVL` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`),
  ADD CONSTRAINT `FK_CTKHSX_XUONG` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`);

--
-- Constraints for table `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  ADD CONSTRAINT `FK_ChiTietPhieuXuatNVL_Phieu` FOREIGN KEY (`maPhieu`) REFERENCES `phieuxuatnvl` (`maPhieu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  ADD CONSTRAINT `FK_CTPKT_PhieuYCKTCL` FOREIGN KEY (`maYC`) REFERENCES `phieuyeucaukiemtrachatluong` (`maYC`),
  ADD CONSTRAINT `FK_CTPKT_SanPham` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Constraints for table `congviec`
--
ALTER TABLE `congviec`
  ADD CONSTRAINT `fk_congviec_xuong` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`),
  ADD CONSTRAINT `fk_kehoach_congviec` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`);

--
-- Constraints for table `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  ADD CONSTRAINT `FK_DONHANG_SANPHAM` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Constraints for table `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  ADD CONSTRAINT `fk_ghinhanthanhphamtheongay_khsx` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_GNTP_NGUOIDUNG` FOREIGN KEY (`maNhanVien`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `FK_GNTP_SANPHAM` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Constraints for table `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  ADD CONSTRAINT `FK_KeHoachSanXuat_DonHangSanXuat` FOREIGN KEY (`maDonHang`) REFERENCES `donhangsanxuat` (`maDonHang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_KHSX_NGUOIDUNG` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`);

--
-- Constraints for table `lichsupheduyet`
--
ALTER TABLE `lichsupheduyet`
  ADD CONSTRAINT `lichsupheduyet_ibfk_1` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`);

--
-- Constraints for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `FK_NGUOIDUNG_TAIKHOAN` FOREIGN KEY (`maTK`) REFERENCES `taikhoan` (`maTK`);

--
-- Constraints for table `nvl`
--
ALTER TABLE `nvl`
  ADD CONSTRAINT `fk_nvl_kho` FOREIGN KEY (`maKho`) REFERENCES `kho` (`maKho`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  ADD CONSTRAINT `fk_phieunhapnvl_nvl` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`);

--
-- Constraints for table `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  ADD CONSTRAINT `phieuxuatthanhpham_ibfk_1` FOREIGN KEY (`maDonHang`) REFERENCES `donhangsanxuat` (`maDonHang`),
  ADD CONSTRAINT `phieuxuatthanhpham_ibfk_2` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Constraints for table `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  ADD CONSTRAINT `FK_PhieuYeuCauCungCapNVL_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_PhieuYeuCauCungCapNVL_NguoiDung` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`);

--
-- Constraints for table `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  ADD CONSTRAINT `FK_KTCL_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_KTCL_ND` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `FK_PhieuYCKTCL_SanPham` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Constraints for table `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD CONSTRAINT `FK_YCNK_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_YCNK_ND` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`);

--
-- Constraints for table `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `fk_sanpham_kho` FOREIGN KEY (`maKho`) REFERENCES `kho` (`maKho`);

--
-- Constraints for table `thietbi`
--
ALTER TABLE `thietbi`
  ADD CONSTRAINT `fk_thietbi_xuong` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
