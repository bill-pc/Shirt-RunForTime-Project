-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--

-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2025 at 08:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30


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
  `maBaoCao` int(11) NOT NULL,
  `tenBaoCao` varchar(100) NOT NULL,
  `loaiLoi` varchar(100) DEFAULT NULL,
  `hinhAnh` varchar(255) DEFAULT '0',
  `thoiGian` date DEFAULT NULL,
  `moTa` varchar(255) DEFAULT NULL,
  `maThietBi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calamviec`
--

CREATE TABLE `calamviec` (
  `maCa` varchar(10) NOT NULL,
  `tenCa` varchar(10) NOT NULL,
  `gioBatDau` datetime NOT NULL,
  `gioKetThuc` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chitietkehoachsanxuat`
--

CREATE TABLE `chitietkehoachsanxuat` (
  `maCTKHSX` int(11) NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `maGNTP` int(11) NOT NULL,
  `maXuong` int(11) NOT NULL,
  `maNVL` int(11) NOT NULL,
  `tenNVL` varchar(50) NOT NULL,
  `loaiNVL` varchar(50) NOT NULL,
  `soLuongNVL` int(11) NOT NULL
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
(8, 3, 3, 2, 2, 'Nút áo xám', 'Phụ kiện', 340);

-- --------------------------------------------------------

--
-- Table structure for table `chitietphieuxuatnvl`
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
-- Dumping data for table `chitietphieuxuatnvl`
--

INSERT INTO `chitietphieuxuatnvl` (`maCTPX`, `maNVL`, `tenNVL`, `soLuong`, `maPhieu`, `maXuong`, `ghiChu`) VALUES
(16, 1, 'Vải cotton loại 1', 20, 13, 1, ''),
(17, 2, 'Nút áo trơn', 200, 13, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `chitietphieuyeucaukiemtrachatluong`
--

CREATE TABLE `chitietphieuyeucaukiemtrachatluong` (
  `maCTPKT` int(11) NOT NULL,
  `tenSanPham` varchar(100) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `maYC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitietphieuyeucaukiemtrachatluong`
--

INSERT INTO `chitietphieuyeucaukiemtrachatluong` (`maCTPKT`, `tenSanPham`, `maSanPham`, `soLuong`, `maYC`) VALUES
(1, 'Vải cotton loại 1', 1, 20, 1),
(2, 'Nút áo trơn', 1, 200, 1);

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_phieuyeucaucapnvl`
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
(44, 'Vải cotton', NULL, 120, 'Tấm', 28, 1),
(45, 'Chỉ may đen', NULL, 230, 'Cuộn', 28, 3),
(46, 'Nút áo', NULL, 340, 'Cái', 28, 2);

-- --------------------------------------------------------

--
-- Table structure for table `chitiet_phieuyeucaunhapkhonvl`
--

CREATE TABLE `chitiet_phieuyeucaunhapkhonvl` (
  `maChiTiet_YCNK` int(11) NOT NULL,
  `maYCNK` int(11) NOT NULL,
  `maNVL` int(11) NOT NULL,
  `soLuong` int(11) DEFAULT NULL,
  `soLuongTonKho` int(11) DEFAULT NULL,
  `soLuongCanNhap` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chitiet_phieuyeucaunhapkhonvl`
--

INSERT INTO `chitiet_phieuyeucaunhapkhonvl` (`maChiTiet_YCNK`, `maYCNK`, `maNVL`, `soLuong`, `soLuongTonKho`, `soLuongCanNhap`) VALUES
(6, 0, 1, 20, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `congviec`
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

-- --------------------------------------------------------

--
-- Table structure for table `donhangsanxuat`
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
-- Dumping data for table `donhangsanxuat`
--

INSERT INTO `donhangsanxuat` (`maDonHang`, `tenDonHang`, `tenSanPham`, `soLuongSanXuat`, `donVi`, `diaChiNhan`, `trangThai`, `ngayGiao`, `maSanPham`) VALUES
(1, ' DHSX1', 'Áo sơ mi hoa cúc', 2000, 'Cai', 'Nguyen Oanh', 'Đã xuất kho', '2025-10-31', 1),
(2, 'DHSX2', 'Áo sơ mi xanh dương', 1000, 'Cái', 'ABC', 'Đã xuất kho', '2025-10-31', 2),
(3, 'DHSX4', 'Áo sơ mi tay ngắn', 3500, 'Cái', 'Nguyễn Văn Bảo', 'Chờ duyệt', '2025-11-28', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ghinhanthanhphamtheongay`
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
-- Dumping data for table `ghinhanthanhphamtheongay`
--

INSERT INTO `ghinhanthanhphamtheongay` (`maGhiNhan`, `maNhanVien`, `maSanPham`, `soLuongSPHoanThanh`, `ngayLam`, `maKHSX`) VALUES
(2, 1, 1, 20, '2025-10-28', 1),
(3, 1, 1, 30, '2025-10-29', 1),
(4, 1, 1, 25, '2025-10-31', 1),
(5, 1, 1, 40, '2025-11-03', 1),
(6, 15, 1, 25, '2025-11-04', 1),
(7, 7, 1, 35, '2025-10-30', 1);

-- --------------------------------------------------------

--
-- Table structure for table `kehoachsanxuat`
--

CREATE TABLE `kehoachsanxuat` (
  `maKHSX` int(11) NOT NULL,
  `tenKHSX` varchar(100) NOT NULL,
  `maDonHang` int(11) NOT NULL,
  `thoiGianBatDau` date NOT NULL,
  `thoiGianKetThuc` date NOT NULL,
  `ghiChu` text DEFAULT NULL,
  `trangThai` varchar(50) NOT NULL DEFAULT 'Chờ duyệt',
  `maND` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kehoachsanxuat`
--

<<<<<<< HEAD
INSERT INTO `kehoachsanxuat` (`maKHSX`, `tenKHSX`, `thoiGianBatDau`, `thoiGianKetThuc`, `ghiChu`, `trangThai`, `maND`) VALUES
(1, 'KHSX1', '2025-10-01', '2025-10-31', '', 'Đã duyệt', 1),
(2, 'KHSX2', '2025-10-09', '2025-10-31', '', 'Từ chối', 1),
(3, 'KHSX3', '2025-10-01', '2025-11-06', NULL, 'Chờ duyệt', 1);
=======
INSERT INTO `kehoachsanxuat` (`maKHSX`, `tenKHSX`, `maDonHang`, `thoiGianBatDau`, `thoiGianKetThuc`, `trangThai`, `maND`) VALUES
(1, 'KHSX1', 1, '2025-10-01', '2025-10-31', 'Đã duyệt', 1),
(2, 'KHSX2', 2, '2025-10-09', '2025-10-31', 'Đã duyệt', 1),
(3, 'KHSX3', 3, '2025-10-01', '2025-11-06', 'Đã duyệt', 1);
>>>>>>> quoc

-- --------------------------------------------------------

--
-- Table structure for table `kho`
--

CREATE TABLE `kho` (
  `maKho` int(11) NOT NULL,
  `tenKho` varchar(100) NOT NULL,
  `diaChi` varchar(200) DEFAULT NULL
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
  `id` int(11) NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `hanhDong` varchar(50) NOT NULL,
  `ghiChu` text DEFAULT NULL,
  `nguoiThucHien` varchar(100) DEFAULT NULL,
  `thoiGian` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lichsupheduyet`
--

INSERT INTO `lichsupheduyet` (`id`, `maKHSX`, `hanhDong`, `ghiChu`, `nguoiThucHien`, `thoiGian`) VALUES
(1, 1, 'Đã duyệt', '', 'TranKienQuoc', '2025-11-08 14:13:17'),
(2, 2, 'Từ chối', '', 'TranKienQuoc', '2025-11-08 14:13:42');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `maND` int(11) NOT NULL,
  `hoTen` varchar(100) NOT NULL,
  `chucVu` varchar(50) DEFAULT NULL,
  `phongBan` varchar(100) NOT NULL,
  `soDienThoai` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `diaChi` varchar(100) DEFAULT NULL,
  `maTK` int(11) NOT NULL,
  `trangThai` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`maND`, `hoTen`, `chucVu`, `phongBan`, `soDienThoai`, `email`, `diaChi`, `maTK`, `trangThai`) VALUES
(1, 'TranKienQuoc', 'Giám đốc', '', '0346512104', 'trandjvjdSVds', 'sgarghsrdgsfdr', 1, 1),
(6, 'Nguyễn Văn B', 'Trưởng phòng', 'QLNVL', '0901234567', 'an.nguyen@company.com', '123 Võ Văn Tần, Q.3, TP.HCM', 2, 1),
(7, 'Trần Thị Bình', 'Nhân viên', 'Xưởng may', '0987654321', 'binh.tran@company.com', '456 Lê Lợi, Q.1, TP.HCM', 3, 1),
(8, 'Lê Minh Cường', 'Kỹ thuật viên', 'Xưởng cắt', '0912345678', 'cuong.le@company.com', '789 Nguyễn Trãi, Q.5, TP.HCM', 4, 1),
(10, 'PhạmThị Dung', 'Nhân viên', 'Xưởng may', NULL, 'dung.pham@company.com', NULL, 5, 0),
(11, 'Mai Van Vu', 'Nhân viên xưởng May', '', '0345675125', '122232@gmail.com', '58 Nguyen Oanh', 6, 0),
(12, 'Mai Van Vu', 'Nhân viên xưởng Cắt', '', '03657458971', 'trankienquoc122102004@gmail.com', 'Quang Trung', 7, 0),
(13, 'Mai Van Vu', 'Nhân viên xưởng Cắt', '', '1231333333', 'quannguyen2002619@gmail.com', '581 Nguyen Oanh g', 8, 0),
(14, 'Mai Van Vu', 'Nhân viên xưởng Cắt', '', '1234567890', '123333@gmail.com', '581 Nguyen Oanh', 9, 0),
(15, 'Mai Van Vu', 'Nhân viên xưởng Cắt', '', '12222222222', '1232221@gmail.com', '581 Nguyen Oanh', 10, 0),
(16, 'Mai vu 12', 'Nhân viên xưởng Cắt', '', '12345678956', 'abc@gmail.com', '58 Nguyen Oanh', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nvl`
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
-- Dumping data for table `nvl`
--

INSERT INTO `nvl` (`maNVL`, `tenNVL`, `loaiNVL`, `soLuongTonKho`, `donViTinh`, `moTa`, `maKho`) VALUES
<<<<<<< HEAD
(1, 'Vải cotton', 'Vải', 20, 'Tấm', '2m x 3m', NULL),
(2, 'Nút áo', 'Phụ kiện', 1000, 'Cái', 'Nút áo trắng', NULL),
(3, 'Chỉ may đen', 'Phụ kiện', 500, 'Cuộn', 'Chỉ may màu trắng', 1),
=======
(1, 'Vải cotton loại 1', 'Vải', 100, 'Tấm', '2m x 3m', NULL),
(2, 'Nút áo trơn', 'Phụ kiện', 1000, 'Cái', 'Nút áo trắng', NULL),
(3, 'Chỉ may đen', 'Chỉ', 500, 'Cuộn', 'Chỉ may màu trắng', 1),
>>>>>>> quoc
(4, 'Nút áo', 'Phụ kiện', 200, 'Cái', 'Nút áo màu đen', 1),
(5, 'Vải cotton', 'Vải', 300, 'Tấm', 'Vải cotton trắng', 1),
(6, 'Chỉ may trắng', 'Chỉ', 3000, 'Cuộn', 'Chỉ may màu trắng, mỏng', 1);

-- --------------------------------------------------------

--
-- Table structure for table `phieunhapnvl`
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
-- Dumping data for table `phieunhapnvl`
--

INSERT INTO `phieunhapnvl` (`maPNVL`, `tenPNVL`, `nguoiLap`, `nhaCungCap`, `ngayNhap`, `maYCNK`, `maNVL`, `soLuongNhap`) VALUES
(1, 'Phiếu nhập nguyên vật liệu', 'ông a', 'abc', '2025-10-30', 1, 1, 0),
(6, 'phieu nhap kho', 'avd', ' sdsd', '2025-10-23', 2, 1, 20),
(7, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'kt', '2025-11-08', 0, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `phieuxuatnvl`
--

CREATE TABLE `phieuxuatnvl` (
  `maPhieu` int(11) NOT NULL,
  `tenPhieu` varchar(100) NOT NULL,
  `tenNguoiLap` varchar(100) DEFAULT NULL,
  `ngayLap` date NOT NULL DEFAULT curdate(),
  `maND` int(11) NOT NULL,
  `maYCCC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieuxuatnvl`
--

INSERT INTO `phieuxuatnvl` (`maPhieu`, `tenPhieu`, `tenNguoiLap`, `ngayLap`, `maND`, `maYCCC`) VALUES
(13, 'Xuất NVL KHSX1', 'TranKienQuoc', '2025-11-06', 1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `phieuxuatthanhpham`
--

CREATE TABLE `phieuxuatthanhpham` (
  `maPhieuXuat` int(11) NOT NULL,
  `maDonHang` int(11) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `soLuongXuat` int(11) NOT NULL,
  `ngayXuat` date DEFAULT curdate(),
  `ghiChu` varchar(255) DEFAULT NULL
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
  `maYCCC` int(11) NOT NULL,
  `ngayLap` date NOT NULL DEFAULT curdate(),
  `trangThai` varchar(50) NOT NULL DEFAULT 'Chờ duyệt',
  `tenNguoiLap` varchar(100) DEFAULT NULL,
  `maND` int(11) NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `tenPhieu` varchar(100) NOT NULL,
  `ghiChu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieuyeucaucungcapnvl`
--

INSERT INTO `phieuyeucaucungcapnvl` (`maYCCC`, `ngayLap`, `trangThai`, `tenNguoiLap`, `maND`, `maKHSX`, `tenPhieu`, `ghiChu`) VALUES
(27, '2025-11-05', 'Đang xuất NVL', 'TranKienQuoc', 1, 1, 'Yêu cầu NVL cho KHSX1', ''),
(28, '2025-11-06', 'Đã duyệt', 'TranKienQuoc', 1, 3, 'Yêu cầu NVL cho KHSX3', '');

-- --------------------------------------------------------

--
-- Table structure for table `phieuyeucaukiemtrachatluong`
--

CREATE TABLE `phieuyeucaukiemtrachatluong` (
  `maYC` int(11) NOT NULL,
  `tenSanPham` varchar(100) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `maKHSX` int(11) DEFAULT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `trangThaiPhieu` varchar(100) NOT NULL,
  `tenNguoiLap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieuyeucaukiemtrachatluong`
--

INSERT INTO `phieuyeucaukiemtrachatluong` (`maYC`, `tenSanPham`, `maSanPham`, `maKHSX`, `soLuong`, `trangThaiPhieu`, `tenNguoiLap`) VALUES
(1, 'Vải cotton loại 1', 1, 1, 220, 'Chờ kiểm tra', 'Hệ thống');

-- --------------------------------------------------------

--
-- Table structure for table `phieuyeucaunhapkhonvl`
--

CREATE TABLE `phieuyeucaunhapkhonvl` (
  `maYCNK` varchar(50) NOT NULL,
  `maKHSX` int(11) DEFAULT NULL,
  `ngayLap` date NOT NULL,
  `nhaCungCap` varchar(100) DEFAULT NULL,
  `ghiChu` text DEFAULT NULL,
  `trangThai` varchar(255) DEFAULT NULL,
  `tenNguoiLap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phieuyeucaunhapkhonvl`
--

INSERT INTO `phieuyeucaunhapkhonvl` (`maYCNK`, `maKHSX`, `ngayLap`, `nhaCungCap`, `ghiChu`, `trangThai`, `tenNguoiLap`) VALUES
('YCNK251108083745', 1, '2025-11-08', 'NCC001', '', 'Đã nhập kho', '');

-- --------------------------------------------------------

--
-- Table structure for table `san_pham`
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
-- Dumping data for table `san_pham`
--

INSERT INTO `san_pham` (`maSanPham`, `tenSanPham`, `loaiSanPham`, `soLuongTon`, `donVi`, `moTa`, `trangThaiSanPham`, `maKho`) VALUES
(1, 'Áo sơ mi trắng', 'Áo', 5, 'Cái', 'Áo sơ mi trắng có thêu hoa cúc', 1, NULL),
(2, 'Áo sơ mi xanh dương', 'Áo', 100, 'Cái', 'Áo tay dài, mỏng, thoáng mát', 0, 1),
(3, 'Áo sơ mi tay ngắn', 'Áo', 550, 'Cái', 'Tay ngắn, màu trắng', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `taikhoan`
--

CREATE TABLE `taikhoan` (
  `maTK` int(11) NOT NULL,
  `tenDangNhap` varchar(50) NOT NULL,
  `matKhau` varchar(100) NOT NULL,
  `trangThai` varchar(20) DEFAULT 'Hoạt động'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taikhoan`
--

INSERT INTO `taikhoan` (`maTK`, `tenDangNhap`, `matKhau`, `trangThai`) VALUES
(1, 'trankienquoc', '12345', 'Hoạt động'),
(2, 'nguyenvanan', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(3, 'tranthibinh', '827ccb0eea8a706c4c34a16891f84e7b', 'Hoạt động'),
(4, 'leminhcuong', '0ec6e061798a1a86d9afdbdb2475529d', 'Hoạt động'),
(5, 'phamthidung', '827ccb0eea8a706c4c34a16891f84e7b', 'không hoạt động'),
(6, '122232', '$2y$10$XQb4fwZIMx2LZ5hPjaMjh.8e1G7c/SvHYzfgPL559j8LQQWx/ABeq', 'không hoạt động'),
(7, 'trankienquoc122102004', '$2y$10$f0WVQWevy0D4S6T8kITg0eq/9VdNaRExfvhiVlbW6UDLHE9nbA.BC', 'không hoạt động'),
(8, 'quannguyen2002619', '$2y$10$aZ9Sxi5dp0pjzEnUprxtm.0kVrpRxKgxAbUlmyNr9mioxPZNmB.4.', 'không hoạt động'),
(9, '123333', '$2y$10$xLj2YZBkxMHwuFjxzH0vmutPse/sKDiZ2kOk.fYZ0zgbIahFoMt66', 'không hoạt động'),
(10, '1232221', '$2y$10$.QyQpjQWp3shgDbFMxqjn.zbzs7gAHhf/L10kS5jBO36Wuh.bQCa.', 'không hoạt động'),
(11, 'abc', '$2y$10$/d9jbV7WT4yYuJhyFhv6BONaMEfqkxqHN1RBnKsM600HwwrJ7Z.oO', 'Hoạt động');

-- --------------------------------------------------------

--
-- Table structure for table `thietbi`
--

CREATE TABLE `thietbi` (
  `maThietBi` int(11) NOT NULL,
  `tenThietBi` varchar(100) NOT NULL,
  `viTri` varchar(100) DEFAULT NULL,
  `trangThai` varchar(50) DEFAULT NULL,
  `maXuong` int(100) NOT NULL
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
  `maXuong` int(100) NOT NULL,
  `tenXuong` varchar(50) NOT NULL
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
  ADD KEY `FK_BCLOI_THIETBI` (`maThietBi`);

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
  ADD KEY `maKHSX` (`maKHSX`);

--
-- Indexes for table `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD PRIMARY KEY (`maYCNK`),
  ADD KEY `maKHSX` (`maKHSX`);

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
  MODIFY `maBaoCao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  MODIFY `maCTKHSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  MODIFY `maCTPX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  MODIFY `maCTPKT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chitiet_phieuyeucaucapnvl`
--
ALTER TABLE `chitiet_phieuyeucaucapnvl`
  MODIFY `maCTPhieuYCCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `chitiet_phieuyeucaunhapkhonvl`
--
ALTER TABLE `chitiet_phieuyeucaunhapkhonvl`
  MODIFY `maChiTiet_YCNK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `congviec`
--
ALTER TABLE `congviec`
  MODIFY `maCongViec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  MODIFY `maDonHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  MODIFY `maGhiNhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  MODIFY `maKHSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kho`
--
ALTER TABLE `kho`
  MODIFY `maKho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lichsupheduyet`
--
ALTER TABLE `lichsupheduyet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `maND` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nvl`
--
ALTER TABLE `nvl`
  MODIFY `maNVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  MODIFY `maPNVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `phieuxuatnvl`
--
ALTER TABLE `phieuxuatnvl`
  MODIFY `maPhieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  MODIFY `maPhieuXuat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  MODIFY `maYCCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  MODIFY `maYC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `maSanPham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `maTK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `thietbi`
--
ALTER TABLE `thietbi`
  MODIFY `maThietBi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `xuong`
--
ALTER TABLE `xuong`
  MODIFY `maXuong` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `baocaoloi`
--
ALTER TABLE `baocaoloi`
  ADD CONSTRAINT `FK_BCLOI_THIETBI` FOREIGN KEY (`maThietBi`) REFERENCES `thietbi` (`maThietBi`);

--
-- Constraints for table `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  ADD CONSTRAINT `FK_CTKHSX_GNTP` FOREIGN KEY (`maGNTP`) REFERENCES `ghinhanthanhphamtheongay` (`maGhiNhan`),
  ADD CONSTRAINT `FK_CTKHSX_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_CTKHSX_NVL` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`),
  ADD CONSTRAINT `FK_CTKHSX_XUONG` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`);

--
<<<<<<< HEAD
-- Constraints for table `chitietphieuyeucaukiemtrachatluong`
=======
-- Các ràng buộc cho bảng `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  ADD CONSTRAINT `FK_ChiTietPhieuXuatNVL_Phieu` FOREIGN KEY (`maPhieu`) REFERENCES `phieuxuatnvl` (`maPhieu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `chitietphieuyeucaukiemtrachatluong`
>>>>>>> quoc
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
  ADD CONSTRAINT `FK_GNTP_NGUOIDUNG` FOREIGN KEY (`maNhanVien`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `FK_GNTP_SANPHAM` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`),
  ADD CONSTRAINT `fk_ghinhanthanhphamtheongay_khsx` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`);

--
-- Constraints for table `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  ADD CONSTRAINT `FK_KHSX_NGUOIDUNG` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `FK_KeHoachSanXuat_DonHangSanXuat` FOREIGN KEY (`maDonHang`) REFERENCES `donhangsanxuat` (`maDonHang`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `FK_PhieuYCKTCL_SanPham` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`),
  ADD CONSTRAINT `phieuyeucaukiemtrachatluong_ibfk_1` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`) ON DELETE CASCADE;

--
-- Constraints for table `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD CONSTRAINT `phieuyeucaunhapkhonvl_ibfk_1` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`) ON DELETE CASCADE;

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
