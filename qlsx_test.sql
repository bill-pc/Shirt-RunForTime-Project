-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy ch?: 127.0.0.1
-- Th?i gian ?ã t?o: Th10 31, 2025 lúc 06:52 AM
-- Phiên b?n máy ph?c v?: 10.4.32-MariaDB
-- Phiên b?n PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- C? s? d? li?u: `qlsx`
--

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `baocaoloi`
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
-- C?u trúc b?ng cho b?ng `calamviec`
--

CREATE TABLE `calamviec` (
  `maCa` varchar(10) NOT NULL,
  `tenCa` varchar(10) NOT NULL,
  `gioBatDau` datetime NOT NULL,
  `gioKetThuc` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `chitietkehoachsanxuat`
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
-- ?ang ?? d? li?u cho b?ng `chitietkehoachsanxuat`
--

INSERT INTO `chitietkehoachsanxuat` (`maCTKHSX`, `maKHSX`, `maGNTP`, `maXuong`, `maNVL`, `tenNVL`, `loaiNVL`, `soLuongNVL`) VALUES
(2, 1, 1, 1, 1, 'V?i cotton lo?i 1', 'V?i', 20),
(3, 1, 1, 2, 2, 'Nút áo tr?n', 'Ph? ki?n', 200);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `chitietphieuxuatnvl`
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
-- ?ang ?? d? li?u cho b?ng `chitietphieuxuatnvl`
--

INSERT INTO `chitietphieuxuatnvl` (`maCTPX`, `maNVL`, `tenNVL`, `soLuong`, `maPhieu`, `maXuong`, `ghiChu`) VALUES
(6, 1, 'V?i cotton', 20, 8, 1, ''),
(7, 2, 'Nút áo', 200, 8, 2, '');

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `chitietphieuyeucaukiemtrachatluong`
--

CREATE TABLE `chitietphieuyeucaukiemtrachatluong` (
  `maCTPKT` int(11) NOT NULL,
  `tenSanPham` varchar(100) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `maYC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `chitiet_phieuyeucaucapnvl`
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
-- ?ang ?? d? li?u cho b?ng `chitiet_phieuyeucaucapnvl`
--

INSERT INTO `chitiet_phieuyeucaucapnvl` (`maCTPhieuYCCC`, `tenNVL`, `nhaCungCap`, `soLuong`, `donViTinh`, `maYCCC`, `maNVL`) VALUES
(34, 'V?i cotton', NULL, 20, 'T?m', 23, 1),
(35, 'Nút áo', NULL, 200, 'Cái', 23, 2);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `chitiet_phieuyeucaunhapkhonvl`
--

CREATE TABLE `chitiet_phieuyeucaunhapkhonvl` (
  `maChiTiet_YCNK` int(11) NOT NULL,
  `maYCNK` int(11) NOT NULL,
  `maNVL` int(11) NOT NULL,
  `tenNVL` varchar(255) DEFAULT NULL,
  `soLuong` int(11) DEFAULT NULL,
  `donViTinh` varchar(50) DEFAULT NULL,
  `nhaCungCap` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `chitiet_phieuyeucaunhapkhonvl`
--

INSERT INTO `chitiet_phieuyeucaunhapkhonvl` (`maChiTiet_YCNK`, `maYCNK`, `maNVL`, `tenNVL`, `soLuong`, `donViTinh`, `nhaCungCap`) VALUES
(1, 2, 2, 'Nút áo', 200, 'Cái', 'Minh Thai');

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `congviec`
--

CREATE TABLE `congviec` (
  `maCongViec` int(11) NOT NULL,
  `tieuDe` varchar(100) NOT NULL,
  `moTa` varchar(200) DEFAULT NULL,
  `trangThai` varchar(30) NOT NULL DEFAULT '?ang th?c hi?n',
  `ngayHetHan` date NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `maXuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `donhangsanxuat`
--

CREATE TABLE `donhangsanxuat` (
  `maDonHang` int(11) NOT NULL,
  `tenDonHang` varchar(100) NOT NULL,
  `donVi` varchar(50) DEFAULT NULL,
  `diaChiNhan` varchar(100) NOT NULL,
  `trangThai` varchar(50) NOT NULL,
  `ngayGiao` date NOT NULL,
  `maSanPham` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `donhangsanxuat`
--

INSERT INTO `donhangsanxuat` (`maDonHang`, `tenDonHang`, `donVi`, `diaChiNhan`, `trangThai`, `ngayGiao`, `maSanPham`) VALUES
(1, ' DHSX1', 'Cai', 'Nguyen Oanh', '?ã xu?t kho', '2025-10-31', 1),
(2, 'DHSX2', 'Cái', 'ABC', '1', '2025-10-31', 1);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `ghinhanthanhphamtheongay`
--

CREATE TABLE `ghinhanthanhphamtheongay` (
  `maGhiNhan` int(11) NOT NULL,
  `maNhanVien` int(11) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `soLuongSPHoanThanh` int(11) NOT NULL,
  `ngayLam` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `ghinhanthanhphamtheongay`
--

INSERT INTO `ghinhanthanhphamtheongay` (`maGhiNhan`, `maNhanVien`, `maSanPham`, `soLuongSPHoanThanh`, `ngayLam`) VALUES
(1, 1, 1, 20, '2025-10-03');

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `kehoachsanxuat`
--

CREATE TABLE `kehoachsanxuat` (
  `maKHSX` int(11) NOT NULL,
  `tenKHSX` varchar(100) NOT NULL,
  `maDHSX` int(11) NOT NULL,
  `thoiGianBatDau` date NOT NULL,
  `thoiGianKetThuc` date NOT NULL,
  `trangThai` varchar(50) NOT NULL DEFAULT 'Ch? duy?t',
  `maND` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `kehoachsanxuat`
--

INSERT INTO `kehoachsanxuat` (`maKHSX`, `tenKHSX`,`maDHSX`, `thoiGianBatDau`, `thoiGianKetThuc`, `trangThai`, `maND`) VALUES
(1, 'KHSX1',1, '2025-10-01', '2025-10-31', '?ã duy?t', 1),
(2, 'KHSX2',2, '2025-10-09', '2025-10-31', 'Ch? duy?t', 1),
(3, 'KHSX3',1, '2025-10-01', '2025-11-06', '?ã duy?t', 1);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `kho`
--

CREATE TABLE `kho` (
  `maKho` int(11) NOT NULL,
  `tenKho` varchar(100) NOT NULL,
  `diaChi` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `kho`
--

INSERT INTO `kho` (`maKho`, `tenKho`, `diaChi`) VALUES
(1, 'Kho Nguyên V?t Li?u', NULL),
(2, 'Kho Thành Ph?m', NULL);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `nguoidung`
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
-- ?ang ?? d? li?u cho b?ng `nguoidung`
--

INSERT INTO `nguoidung` (`maND`, `hoTen`, `chucVu`, `phongBan`, `soDienThoai`, `email`, `diaChi`, `maTK`, `trangThai`) VALUES
(1, 'TranKienQuoc', 'Giám ??c', '', '0346512104', 'trandjvjdSVds', 'sgarghsrdgsfdr', 1, 1),
(6, 'Nguy?n V?n An', 'Tr??ng phòng', 'QLNVL', '0901234567', 'an.nguyen@company.com', '123 Võ V?n T?n, Q.3, TP.HCM', 2, 1),
(7, 'Tr?n Th? Bình', 'Nhân viên', 'X??ng may', '0987654321', 'binh.tran@company.com', '456 Lê L?i, Q.1, TP.HCM', 3, 1),
(8, 'Lê Minh C??ng', 'K? thu?t viên', 'X??ng c?t', '0912345678', 'cuong.le@company.com', '789 Nguy?n Trãi, Q.5, TP.HCM', 4, 1),
(10, 'Ph?mTh? Dung', 'Nhân viên', 'X??ng may', NULL, 'dung.pham@company.com', NULL, 5, 0);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `nvl`
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
-- ?ang ?? d? li?u cho b?ng `nvl`
--

INSERT INTO `nvl` (`maNVL`, `tenNVL`, `loaiNVL`, `soLuongTonKho`, `donViTinh`, `moTa`, `maKho`) VALUES
(1, 'V?i cotton', 'V?i', 100, 'T?m', '2m x 3m', NULL),
(2, 'Nút áo', 'Ph? ki?n', 1000, 'Cái', 'Nút áo tr?ng', NULL),
(3, 'Ch? may ?en', 'Ph? ki?n', 500, 'Cu?n', 'Ch? may màu tr?ng', 1),
(4, 'Nút áo', 'Ph? ki?n', 200, 'Cái', 'Nút áo màu ?en', 1),
(5, 'V?i cotton', 'V?i', 300, 'T?m', 'V?i cotton tr?ng', 1);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `phieunhapnvl`
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
-- ?ang ?? d? li?u cho b?ng `phieunhapnvl`
--

INSERT INTO `phieunhapnvl` (`maPNVL`, `tenPNVL`, `nguoiLap`, `nhaCungCap`, `ngayNhap`, `maYCNK`, `maNVL`, `soLuongNhap`) VALUES
(1, 'Phi?u nh?p nguyên v?t li?u', 'ông a', 'abc', '2025-10-30', 1, 1, 0),
(6, 'phieu nhap kho', 'avd', ' sdsd', '2025-10-23', 2, 1, 20);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `phieuxuatnvl`
--

CREATE TABLE `phieuxuatnvl` (
  `maPhieu` int(11) NOT NULL,
  `tenPhieu` varchar(100) NOT NULL,
  `tenNguoiLap` varchar(100) DEFAULT NULL,
  `ngayLap` DATE NOT NULL DEFAULT curdate(),
  `maND` int(11) NOT NULL,
  `maYCCC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `phieuxuatnvl`
--

INSERT INTO `phieuxuatnvl` (`maPhieu`, `tenPhieu`, `tenNguoiLap`, `ngayLap`, `maND`, `maYCCC`) VALUES
(8, 'Phi?u xu?t NVL', 'Tr?n Ki?n Qu?c', '2025-10-31', 2, 23);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `phieuxuatthanhpham`
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
-- ?ang ?? d? li?u cho b?ng `phieuxuatthanhpham`
--

INSERT INTO `phieuxuatthanhpham` (`maPhieuXuat`, `maDonHang`, `maSanPham`, `soLuongXuat`, `ngayXuat`, `ghiChu`) VALUES
(1, 1, 1, 5, '2025-10-30', '');

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `phieuyeucaucungcapnvl`
--

CREATE TABLE `phieuyeucaucungcapnvl` (
  `maYCCC` int(11) NOT NULL,
  `ngayLap` date NOT NULL DEFAULT curdate(),
  `trangThai` varchar(50) NOT NULL DEFAULT 'Ch? duy?t',
  `tenNguoiLap` varchar(100) DEFAULT NULL,
  `maND` int(11) NOT NULL,
  `maKHSX` int(11) NOT NULL,
  `tenPhieu` varchar(100) NOT NULL,
  `ghiChu` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `phieuyeucaucungcapnvl`
--

INSERT INTO `phieuyeucaucungcapnvl` (`maYCCC`, `ngayLap`, `trangThai`, `tenNguoiLap`, `maND`, `maKHSX`, `tenPhieu`, `ghiChu`) VALUES
(23, '2025-10-31', '?ang xu?t NVL', 'TranKienQuoc', 1, 1, 'Yêu c?u NVL cho KHSX1', '');

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `phieuyeucaukiemtrachatluong`
--

CREATE TABLE `phieuyeucaukiemtrachatluong` (
  `maYC` int(11) NOT NULL,
  `tenSanPham` varchar(100) NOT NULL,
  `maSanPham` int(11) NOT NULL,
  `soLuong` int(11) NOT NULL DEFAULT 0,
  `trangThaiPhieu` varchar(100) NOT NULL,
  `tenNguoiLap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `phieuyeucaunhapkhonvl`
--

CREATE TABLE `phieuyeucaunhapkhonvl` (
  `maYCNK` varchar(50) NOT NULL,
  `maNVL` int(11) NOT NULL,
  `donViTinh` varchar(50) DEFAULT NULL,
  `ngayLap` date NOT NULL,
  `nhaCungCap` varchar(100) DEFAULT NULL,
  `trangThai` varchar(255) DEFAULT NULL,
  `tenNguoiLap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `phieuyeucaunhapkhonvl`
--

INSERT INTO `phieuyeucaunhapkhonvl` (`maYCNK`, `maNVL`, `donViTinh`, `ngayLap`, `nhaCungCap`, `trangThai`, `tenNguoiLap`) VALUES
('1', 1, 'kg', '2025-10-22', 'abc', NULL, 'avsd');

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `san_pham`
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
-- ?ang ?? d? li?u cho b?ng `san_pham`
--

INSERT INTO `san_pham` (`maSanPham`, `tenSanPham`, `loaiSanPham`, `soLuongTon`, `donVi`, `moTa`, `trangThaiSanPham`, `maKho`) VALUES
(1, 'Áo s? mi tr?ng', 'Áo', 5, 'Cái', 'Áo s? mi tr?ng có thêu hoa cúc', 1, NULL);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `taikhoan`
--

CREATE TABLE `taikhoan` (
  `maTK` int(11) NOT NULL,
  `tenDangNhap` varchar(50) NOT NULL,
  `matKhau` varchar(100) NOT NULL,
  `trangThai` varchar(20) DEFAULT 'Ho?t ??ng'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `taikhoan`
--

INSERT INTO `taikhoan` (`maTK`, `tenDangNhap`, `matKhau`, `trangThai`) VALUES
(1, 'trankienquoc', '12345', 'Ho?t ??ng'),
(2, 'nguyenvanan', '827ccb0eea8a706c4c34a16891f84e7b', 'Ho?t ??ng'),
(3, 'tranthibinh', '827ccb0eea8a706c4c34a16891f84e7b', 'Ho?t ??ng'),
(4, 'leminhcuong', '0ec6e061798a1a86d9afdbdb2475529d', 'Ho?t ??ng'),
(5, 'phamthidung', '827ccb0eea8a706c4c34a16891f84e7b', 'không ho?t ??ng');

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `thietbi`
--

CREATE TABLE `thietbi` (
  `maThietBi` int(11) NOT NULL,
  `tenThietBi` varchar(100) NOT NULL,
  `viTri` varchar(100) DEFAULT NULL,
  `trangThai` varchar(50) DEFAULT NULL,
  `maXuong` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `thietbi`
--

INSERT INTO `thietbi` (`maThietBi`, `tenThietBi`, `viTri`, `trangThai`, `maXuong`) VALUES
(7, 'Máy ép nhi?t', '2', '?ang ho?t ??ng', 1),
(8, 'Máy c?t v?i', '2', '?ang ho?t ??ng', 1);

-- --------------------------------------------------------

--
-- C?u trúc b?ng cho b?ng `xuong`
--

CREATE TABLE `xuong` (
  `maXuong` int(100) NOT NULL,
  `tenXuong` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- ?ang ?? d? li?u cho b?ng `xuong`
--

INSERT INTO `xuong` (`maXuong`, `tenXuong`) VALUES
(1, 'X??ng c?t'),
(2, 'X??ng may');

--
-- Ch? m?c cho các b?ng ?ã ??
--

--
-- Ch? m?c cho b?ng `baocaoloi`
--
ALTER TABLE `baocaoloi`
  ADD PRIMARY KEY (`maBaoCao`),
  ADD KEY `FK_BCLOI_THIETBI` (`maThietBi`);

--
-- Ch? m?c cho b?ng `calamviec`
--
ALTER TABLE `calamviec`
  ADD PRIMARY KEY (`maCa`);

--
-- Ch? m?c cho b?ng `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  ADD PRIMARY KEY (`maCTKHSX`),
  ADD KEY `FK_CTKHSX_KHSX` (`maKHSX`),
  ADD KEY `FK_CTKHSX_DHSX` (`maDHSX`),
  ADD KEY `FK_CTKHSX_GNTP` (`maGNTP`),
  ADD KEY `FK_CTKHSX_XUONG` (`maXuong`),
  ADD KEY `FK_CTKHSX_NVL` (`maNVL`);

--
-- Ch? m?c cho b?ng `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  ADD PRIMARY KEY (`maCTPX`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_NVL` (`maNVL`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_Phieu` (`maPhieu`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_Xuong` (`maXuong`);

--
-- Ch? m?c cho b?ng `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  ADD PRIMARY KEY (`maCTPKT`),
  ADD KEY `FK_CTPKT_SanPham` (`maSanPham`),
  ADD KEY `FK_CTPKT_PhieuYCKTCL` (`maYC`);

--
-- Ch? m?c cho b?ng `chitiet_phieuyeucaucapnvl`
--
ALTER TABLE `chitiet_phieuyeucaucapnvl`
  ADD PRIMARY KEY (`maCTPhieuYCCC`),
  ADD KEY `FK_ChiTiet_Phieu` (`maYCCC`),
  ADD KEY `FK_ChiTiet_NVL` (`maNVL`);

--
-- Ch? m?c cho b?ng `chitiet_phieuyeucaunhapkhonvl`
--
ALTER TABLE `chitiet_phieuyeucaunhapkhonvl`
  ADD PRIMARY KEY (`maChiTiet_YCNK`),
  ADD KEY `maYCNK` (`maYCNK`),
  ADD KEY `maNVL` (`maNVL`);

--
-- Ch? m?c cho b?ng `congviec`
--
ALTER TABLE `congviec`
  ADD PRIMARY KEY (`maCongViec`),
  ADD KEY `fk_kehoach_congviec` (`maKHSX`),
  ADD KEY `fk_congviec_xuong` (`maXuong`);

--
-- Ch? m?c cho b?ng `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  ADD PRIMARY KEY (`maDonHang`),
  ADD KEY `FK_DONHANG_SANPHAM` (`maSanPham`);

--
-- Ch? m?c cho b?ng `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  ADD PRIMARY KEY (`maGhiNhan`),
  ADD KEY `FK_GNTP_NGUOIDUNG` (`maNhanVien`),
  ADD KEY `FK_GNTP_SANPHAM` (`maSanPham`);

--
-- Ch? m?c cho b?ng `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  ADD PRIMARY KEY (`maKHSX`),
  ADD KEY `FK_KHSX_NGUOIDUNG` (`maND`),
  ADD KEY `FK_KHSX_DHSX` (`maDHSX`);

--
-- Ch? m?c cho b?ng `kho`
--
ALTER TABLE `kho`
  ADD PRIMARY KEY (`maKho`);

--
-- Ch? m?c cho b?ng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`maND`),
  ADD KEY `FK_NGUOIDUNG_TAIKHOAN` (`maTK`);

--
-- Ch? m?c cho b?ng `nvl`
--
ALTER TABLE `nvl`
  ADD PRIMARY KEY (`maNVL`),
  ADD KEY `fk_nvl_kho` (`maKho`);

--
-- Ch? m?c cho b?ng `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  ADD PRIMARY KEY (`maPNVL`),
  ADD UNIQUE KEY `phieuyeucaunhapkhonvl` (`maYCNK`),
  ADD KEY `fk_phieunhapnvl_nvl` (`maNVL`);

--
-- Ch? m?c cho b?ng `phieuxuatnvl`
--
ALTER TABLE `phieuxuatnvl`
  ADD PRIMARY KEY (`maPhieu`),
  ADD KEY `FK_PhieuXuatNVL_NguoiDung` (`maND`),
  ADD KEY `fk_phieuxuat_yccc` (`maYCCC`);

--
-- Ch? m?c cho b?ng `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  ADD PRIMARY KEY (`maPhieuXuat`),
  ADD KEY `maDonHang` (`maDonHang`),
  ADD KEY `maSanPham` (`maSanPham`);

--
-- Ch? m?c cho b?ng `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  ADD PRIMARY KEY (`maYCCC`),
  ADD KEY `FK_PhieuYeuCauCungCapNVL_NguoiDung` (`maND`),
  ADD KEY `FK_PhieuYeuCauCungCapNVL_KHSX` (`maKHSX`);

--
-- Ch? m?c cho b?ng `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  ADD PRIMARY KEY (`maYC`),
  ADD KEY `FK_PhieuYCKTCL_SanPham` (`maSanPham`);

--
-- Ch? m?c cho b?ng `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD PRIMARY KEY (`maYCNK`),
  ADD KEY `FK_YCNKNVL_NVL` (`maNVL`);

--
-- Ch? m?c cho b?ng `san_pham`
--
ALTER TABLE `san_pham`
  ADD PRIMARY KEY (`maSanPham`),
  ADD KEY `fk_sanpham_kho` (`maKho`);

--
-- Ch? m?c cho b?ng `taikhoan`
--
ALTER TABLE `taikhoan`
  ADD PRIMARY KEY (`maTK`),
  ADD UNIQUE KEY `tenDangNhap` (`tenDangNhap`);

--
-- Ch? m?c cho b?ng `thietbi`
--
ALTER TABLE `thietbi`
  ADD PRIMARY KEY (`maThietBi`),
  ADD KEY `fk_thietbi_xuong` (`maXuong`);

--
-- Ch? m?c cho b?ng `xuong`
--
ALTER TABLE `xuong`
  ADD PRIMARY KEY (`maXuong`);

--
-- AUTO_INCREMENT cho các b?ng ?ã ??
--

--
-- AUTO_INCREMENT cho b?ng `baocaoloi`
--
ALTER TABLE `baocaoloi`
  MODIFY `maBaoCao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho b?ng `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  MODIFY `maCTKHSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho b?ng `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  MODIFY `maCTPX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho b?ng `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  MODIFY `maCTPKT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho b?ng `chitiet_phieuyeucaucapnvl`
--
ALTER TABLE `chitiet_phieuyeucaucapnvl`
  MODIFY `maCTPhieuYCCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho b?ng `chitiet_phieuyeucaunhapkhonvl`
--
ALTER TABLE `chitiet_phieuyeucaunhapkhonvl`
  MODIFY `maChiTiet_YCNK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho b?ng `congviec`
--
ALTER TABLE `congviec`
  MODIFY `maCongViec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho b?ng `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  MODIFY `maDonHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho b?ng `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  MODIFY `maGhiNhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho b?ng `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  MODIFY `maKHSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho b?ng `kho`
--
ALTER TABLE `kho`
  MODIFY `maKho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho b?ng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `maND` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho b?ng `nvl`
--
ALTER TABLE `nvl`
  MODIFY `maNVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho b?ng `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  MODIFY `maPNVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho b?ng `phieuxuatnvl`
--
ALTER TABLE `phieuxuatnvl`
  MODIFY `maPhieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho b?ng `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  MODIFY `maPhieuXuat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho b?ng `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  MODIFY `maYCCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho b?ng `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  MODIFY `maYC` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho b?ng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `maSanPham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho b?ng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `maTK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho b?ng `thietbi`
--
ALTER TABLE `thietbi`
  MODIFY `maThietBi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho b?ng `xuong`
--
ALTER TABLE `xuong`
  MODIFY `maXuong` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng bu?c cho các b?ng ?ã ??
--

--
-- Các ràng bu?c cho b?ng `baocaoloi`
--
ALTER TABLE `baocaoloi`
  ADD CONSTRAINT `FK_BCLOI_THIETBI` FOREIGN KEY (`maThietBi`) REFERENCES `thietbi` (`maThietBi`);

--
-- Cac rang buoc cho bang kehoachsanxuat 
--
ALTER TABLE `kehoachsanxuat`ALTER
	ADD CONSTRAINT `FK_KHSX_DHSX` FOREIGN KEY (`maDHSX`) REFERENCES `donhangsanxuat` (`maDHSX`);
--
-- Các ràng bu?c cho b?ng `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  ADD CONSTRAINT `FK_CTKHSX_GNTP` FOREIGN KEY (`maGNTP`) REFERENCES `ghinhanthanhphamtheongay` (`maGhiNhan`),
  ADD CONSTRAINT `FK_CTKHSX_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_CTKHSX_NVL` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`),
  ADD CONSTRAINT `FK_CTKHSX_XUONG` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`);

--
-- Các ràng bu?c cho b?ng `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  ADD CONSTRAINT `FK_CTPKT_PhieuYCKTCL` FOREIGN KEY (`maYC`) REFERENCES `phieuyeucaukiemtrachatluong` (`maYC`),
  ADD CONSTRAINT `FK_CTPKT_SanPham` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng bu?c cho b?ng `congviec`
--
ALTER TABLE `congviec`
  ADD CONSTRAINT `fk_congviec_xuong` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`),
  ADD CONSTRAINT `fk_kehoach_congviec` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`);

--
-- Các ràng bu?c cho b?ng `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  ADD CONSTRAINT `FK_DONHANG_SANPHAM` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng bu?c cho b?ng `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  ADD CONSTRAINT `FK_GNTP_NGUOIDUNG` FOREIGN KEY (`maNhanVien`) REFERENCES `nguoidung` (`maND`),
  ADD CONSTRAINT `FK_GNTP_SANPHAM` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng bu?c cho b?ng `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  ADD CONSTRAINT `FK_KHSX_NGUOIDUNG` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`);

--
-- Các ràng bu?c cho b?ng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD CONSTRAINT `FK_NGUOIDUNG_TAIKHOAN` FOREIGN KEY (`maTK`) REFERENCES `taikhoan` (`maTK`);

--
-- Các ràng bu?c cho b?ng `nvl`
--
ALTER TABLE `nvl`
  ADD CONSTRAINT `fk_nvl_kho` FOREIGN KEY (`maKho`) REFERENCES `kho` (`maKho`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng bu?c cho b?ng `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  ADD CONSTRAINT `fk_phieunhapnvl_nvl` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`);

--
-- Các ràng bu?c cho b?ng `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  ADD CONSTRAINT `phieuxuatthanhpham_ibfk_1` FOREIGN KEY (`maDonHang`) REFERENCES `donhangsanxuat` (`maDonHang`),
  ADD CONSTRAINT `phieuxuatthanhpham_ibfk_2` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng bu?c cho b?ng `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  ADD CONSTRAINT `FK_PhieuYeuCauCungCapNVL_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_PhieuYeuCauCungCapNVL_NguoiDung` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`);

--
-- Các ràng bu?c cho b?ng `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  ADD CONSTRAINT `FK_PhieuYCKTCL_SanPham` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng bu?c cho b?ng `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD CONSTRAINT `FK_YCNKNVL_NVL` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`);

--
-- Các ràng bu?c cho b?ng `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `fk_sanpham_kho` FOREIGN KEY (`maKho`) REFERENCES `kho` (`maKho`);

--
-- Các ràng bu?c cho b?ng `thietbi`
--
ALTER TABLE `thietbi`
  ADD CONSTRAINT `fk_thietbi_xuong` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;