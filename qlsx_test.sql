-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 13, 2025 lúc 06:15 PM
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
-- Cơ sở dữ liệu: `qlsx_test`
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

--
-- Đang đổ dữ liệu cho bảng `baocaoloi`
--

INSERT INTO `baocaoloi` (`maBaoCao`, `tenBaoCao`, `loaiLoi`, `hinhAnh`, `thoiGian`, `moTa`, `maThietBi`, `maND`) VALUES
(49, 'Báo cáo sự cố - Máy may hãng A - Nguyễn Văn An', 'phancung', NULL, '2025-11-08', '', 9, 6),
(50, 'Báo cáo sự cố - Máy ép nhiệt - TranKienQuoc', 'phancung', NULL, '2025-11-08', '', 7, 1),
(51, 'Báo cáo sự cố - Máy may D - TranKienQuoc', 'phancung', NULL, '2025-11-09', '', 10, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `calamviec`
--

CREATE TABLE `calamviec` (
  `maCa` varchar(10) NOT NULL,
  `gioBatDau` time NOT NULL,
  `gioKetThuc` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `calamviec`
--

INSERT INTO `calamviec` (`maCa`, `gioBatDau`, `gioKetThuc`) VALUES
('CA_CHIEU', '13:00:00', '17:30:00'),
('CA_SANG', '07:30:00', '11:30:00'),
('CA_TOI', '18:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietkehoachsanxuat`
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
-- Đang đổ dữ liệu cho bảng `chitietkehoachsanxuat`
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
(16, 1, 'Vải cotton loại 1', 20, 13, 1, ''),
(17, 2, 'Nút áo trơn', 200, 13, 2, '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitietphieuyeucaukiemtrachatluong`
--

CREATE TABLE `chitietphieuyeucaukiemtrachatluong` (
  `maCTPKT` int(11) NOT NULL,
  `tenSanPham` varchar(100) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `maYC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitietphieuyeucaukiemtrachatluong`
--

INSERT INTO `chitietphieuyeucaukiemtrachatluong` (`maCTPKT`, `tenSanPham`, `maSanPham`, `soLuong`, `maYC`) VALUES
(1, 'Vải cotton loại 1', 1, 20, 1),
(2, 'Nút áo trơn', 1, 200, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chitiet_lichlamviec`
--

CREATE TABLE `chitiet_lichlamviec` (
  `maLichLam` int(11) NOT NULL,
  `maND` char(10) NOT NULL,
  `ngayLam` date NOT NULL,
  `maCa` char(10) NOT NULL,
  `maXuong` char(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiet_lichlamviec`
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

--
-- Đang đổ dữ liệu cho bảng `chitiet_phieuyeucaucapnvl`
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
-- Cấu trúc bảng cho bảng `chitiet_phieuyeucaunhapkhonvl`
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
-- Đang đổ dữ liệu cho bảng `chitiet_phieuyeucaunhapkhonvl`
--

INSERT INTO `chitiet_phieuyeucaunhapkhonvl` (`maChiTiet_YCNK`, `maYCNK`, `maNVL`, `soLuong`, `soLuongTonKho`, `soLuongCanNhap`) VALUES
(6, 0, 1, 20, 10, 10);

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
(1, ' DHSX1', 'Áo sơ mi hoa cúc', 2000, 'Cai', 'Nguyen Oanh', 'Đã xuất kho', '2025-10-31', 1),
(2, 'DHSX2', 'Áo sơ mi xanh dương', 1000, 'Cái', 'ABC', 'Đang thực hiện', '2025-10-31', 2),
(3, 'DHSX4', 'Áo sơ mi tay ngắn', 3500, 'Cái', 'Nguyễn Văn Bảo', 'Chờ duyệt', '2025-11-28', 3),
(5, 'PX2025-44 - SL: 234', '', 0, 'Cái', 'Nội bộ', 'Chờ duyệt', '2025-11-21', 3);

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
(7, 7, 1, 35, '2025-10-30', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `kehoachsanxuat`
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
(2, 2, 'Từ chối', '', 'TranKienQuoc', '2025-11-08 14:13:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
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
-- Đang đổ dữ liệu cho bảng `nguoidung`
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
(16, 'Mai vu 12', 'Nhân viên xưởng Cắt', '', '12345678956', 'abc@gmail.com', '58 Nguyen Oanh', 11, 0);

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
(1, 'Vải cotton trắng', 'Vải', 300, 'Tấm', 'Vải cotton dùng may áo sơ mi trắng', 1),
(2, 'Nút áo trắng', 'Phụ kiện', 1000, 'Cái', 'Nút áo nhựa trắng', 1),
(3, 'Chỉ may trắng', 'Phụ kiện', 500, 'Cuộn', 'Chỉ may trắng dùng cho áo sơ mi', 1);

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
(1, 'Phiếu nhập nguyên vật liệu', 'ông a', 'abc', '2025-10-30', 1, 1, 0),
(6, 'phieu nhap kho', 'avd', ' sdsd', '2025-10-23', 2, 1, 20),
(7, 'Phiếu nhập nguyên vật liệu', 'TranKienQuoc', 'kt', '2025-11-08', 0, 1, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuxuatnvl`
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
-- Đang đổ dữ liệu cho bảng `phieuxuatnvl`
--

INSERT INTO `phieuxuatnvl` (`maPhieu`, `tenPhieu`, `tenNguoiLap`, `ngayLap`, `maND`, `maYCCC`) VALUES
(13, 'Xuất NVL KHSX1', 'TranKienQuoc', '2025-11-06', 1, 27);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuxuatthanhpham`
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
-- Đang đổ dữ liệu cho bảng `phieuxuatthanhpham`
--

INSERT INTO `phieuxuatthanhpham` (`maPhieuXuat`, `maDonHang`, `maSanPham`, `soLuongXuat`, `ngayXuat`, `ghiChu`) VALUES
(1, 1, 1, 5, '2025-10-30', ''),
(2, 2, 2, 200, '2025-11-03', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuyeucaucungcapnvl`
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
-- Đang đổ dữ liệu cho bảng `phieuyeucaucungcapnvl`
--

INSERT INTO `phieuyeucaucungcapnvl` (`maYCCC`, `ngayLap`, `trangThai`, `tenNguoiLap`, `maND`, `maKHSX`, `tenPhieu`, `ghiChu`) VALUES
(27, '2025-11-05', 'Đang xuất NVL', 'TranKienQuoc', 1, 1, 'Yêu cầu NVL cho KHSX1', ''),
(28, '2025-11-06', 'Đã duyệt', 'TranKienQuoc', 1, 3, 'Yêu cầu NVL cho KHSX3', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuyeucaukiemtrachatluong`
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
-- Đang đổ dữ liệu cho bảng `phieuyeucaukiemtrachatluong`
--

INSERT INTO `phieuyeucaukiemtrachatluong` (`maYC`, `tenSanPham`, `maSanPham`, `maKHSX`, `soLuong`, `trangThaiPhieu`, `tenNguoiLap`) VALUES
(1, 'Vải cotton loại 1', 1, 1, 220, 'Chờ kiểm tra', 'Hệ thống');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuyeucaunhapkhonvl`
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
-- Đang đổ dữ liệu cho bảng `phieuyeucaunhapkhonvl`
--

INSERT INTO `phieuyeucaunhapkhonvl` (`maYCNK`, `maKHSX`, `ngayLap`, `nhaCungCap`, `ghiChu`, `trangThai`, `tenNguoiLap`) VALUES
('YCNK251108083745', 1, '2025-11-08', 'NCC001', '', 'Đã nhập kho', '');

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
(1, 'Áo sơ mi trắng', 'Áo', 5, 'Cái', 'Áo sơ mi trắng có thêu hoa cúc', 1, NULL),
(2, 'Áo sơ mi xanh dương', 'Áo', 100, 'Cái', 'Áo tay dài, mỏng, thoáng mát', 0, 1),
(3, 'Áo sơ mi tay ngắn', 'Áo', 550, 'Cái', 'Tay ngắn, màu trắng', NULL, 2);

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
(11, 'abc', '$2y$10$/d9jbV7WT4yYuJhyFhv6BONaMEfqkxqHN1RBnKsM600HwwrJ7Z.oO', 'không hoạt động');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thietbi`
--

CREATE TABLE `thietbi` (
  `maThietBi` int(11) NOT NULL,
  `tenThietBi` varchar(100) NOT NULL,
  `viTri` varchar(100) DEFAULT NULL,
  `trangThai` varchar(50) DEFAULT NULL,
  `maXuong` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thietbi`
--

INSERT INTO `thietbi` (`maThietBi`, `tenThietBi`, `viTri`, `trangThai`, `maXuong`) VALUES
(7, 'Máy ép nhiệt', '2', 'Đang hoạt động', 1),
(8, 'Máy cắt vải', '2', 'Đang hoạt động', 1),
(9, 'Máy may hãng A', '5', 'Đang hoạt động', 2),
(10, 'Máy may D', '6', 'Đang hoạt động', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `xuong`
--

CREATE TABLE `xuong` (
  `maXuong` int(100) NOT NULL,
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
-- Chỉ mục cho bảng `chitiet_lichlamviec`
--
ALTER TABLE `chitiet_lichlamviec`
  ADD PRIMARY KEY (`maLichLam`),
  ADD UNIQUE KEY `maNguoiDung` (`maND`,`ngayLam`,`maCa`),
  ADD KEY `idx_nv_ngay` (`maND`,`ngayLam`),
  ADD KEY `maCa` (`maCa`),
  ADD KEY `maXuong` (`maXuong`);

--
-- Chỉ mục cho bảng `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  ADD PRIMARY KEY (`maDonHang`),
  ADD KEY `FK_DONHANG_SANPHAM` (`maSanPham`);

--
-- Chỉ mục cho bảng `kho`
--
ALTER TABLE `kho`
  ADD PRIMARY KEY (`maKho`);

--
-- Chỉ mục cho bảng `nvl`
--
ALTER TABLE `nvl`
  ADD PRIMARY KEY (`maNVL`),
  ADD KEY `fk_nvl_kho` (`maKho`);

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
  MODIFY `maBaoCao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT cho bảng `chitiet_lichlamviec`
--
ALTER TABLE `chitiet_lichlamviec`
  MODIFY `maLichLam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  MODIFY `maDonHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `kho`
--
ALTER TABLE `kho`
  MODIFY `maKho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `nvl`
--
ALTER TABLE `nvl`
  MODIFY `maNVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `thietbi`
--
ALTER TABLE `thietbi`
  MODIFY `maThietBi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `xuong`
--
ALTER TABLE `xuong`
  MODIFY `maXuong` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `nvl`
--
ALTER TABLE `nvl`
  ADD CONSTRAINT `fk_nvl_kho` FOREIGN KEY (`maKho`) REFERENCES `kho` (`maKho`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `thietbi`
--
ALTER TABLE `thietbi`
  ADD CONSTRAINT `fk_thietbi_xuong` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
