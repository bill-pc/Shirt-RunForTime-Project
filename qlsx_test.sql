-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 02, 2025 lúc 04:43 PM
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
  `maThietBi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `calamviec`
--

CREATE TABLE `calamviec` (
  `maCa` varchar(10) NOT NULL,
  `tenCa` varchar(10) NOT NULL,
  `gioBatDau` datetime NOT NULL,
  `gioKetThuc` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 1, 2, 2, 2, 'Nút áo trơn', 'Phụ kiện', 200);

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
(6, 1, 'Vải cotton', 20, 8, 1, ''),
(7, 2, 'Nút áo', 200, 8, 2, ''),
(8, 1, 'Vải cotton', 20, 9, 1, ''),
(9, 2, 'Nút áo', 200, 9, 2, ''),
(10, 1, 'Vải cotton', 20, 10, 1, ''),
(11, 2, 'Nút áo', 200, 10, 2, '');

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
(37, 'Nút áo', NULL, 200, 'Cái', 24, 2);

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
  `nhaCungCap` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chitiet_phieuyeucaunhapkhonvl`
--

INSERT INTO `chitiet_phieuyeucaunhapkhonvl` (`maChiTiet_YCNK`, `maYCNK`, `maNVL`, `tenNVL`, `soLuong`, `donViTinh`, `nhaCungCap`) VALUES
(1, 2, 2, 'Nút áo', 200, 'Cái', 'Minh Thai');

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
  `donVi` varchar(50) DEFAULT NULL,
  `diaChiNhan` varchar(100) NOT NULL,
  `trangThai` varchar(50) NOT NULL,
  `ngayGiao` date NOT NULL,
  `maSanPham` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `donhangsanxuat`
--

INSERT INTO `donhangsanxuat` (`maDonHang`, `tenDonHang`, `donVi`, `diaChiNhan`, `trangThai`, `ngayGiao`, `maSanPham`) VALUES
(1, ' DHSX1', 'Cai', 'Nguyen Oanh', 'Đã xuất kho', '2025-10-31', 1),
(2, 'DHSX2', 'Cái', 'ABC', '1', '2025-10-31', 1);

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
  `maDHSX` int(11) NOT NULL,
  `thoiGianBatDau` date NOT NULL,
  `thoiGianKetThuc` date NOT NULL,
  `trangThai` varchar(50) NOT NULL DEFAULT 'Chờ duyệt',
  `maND` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `kehoachsanxuat`
--

INSERT INTO `kehoachsanxuat` (`maKHSX`, `tenKHSX`, `maDHSX`, `thoiGianBatDau`, `thoiGianKetThuc`, `trangThai`, `maND`) VALUES
(1, 'KHSX1', 1, '2025-10-01', '2025-10-31', 'Đã duyệt', 1),
(2, 'KHSX2', 1,'2025-10-09', '2025-10-31', 'Đã duyệt', 1),
(3, 'KHSX3', 2,'2025-10-01', '2025-11-06', 'Đã duyệt', 1);

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
(6, 'Nguyễn Văn An', 'Trưởng phòng', 'QLNVL', '0901234567', 'an.nguyen@company.com', '123 Võ Văn Tần, Q.3, TP.HCM', 2, 1),
(7, 'Trần Thị Bình', 'Nhân viên', 'Xưởng may', '0987654321', 'binh.tran@company.com', '456 Lê Lợi, Q.1, TP.HCM', 3, 1),
(8, 'Lê Minh Cường', 'Kỹ thuật viên', 'Xưởng cắt', '0912345678', 'cuong.le@company.com', '789 Nguyễn Trãi, Q.5, TP.HCM', 4, 1),
(10, 'PhạmThị Dung', 'Nhân viên', 'Xưởng may', NULL, 'dung.pham@company.com', NULL, 5, 0),
(11, 'Mai Van Vu', 'Nhân viên xưởng May', '', '0345675125', '122232@gmail.com', '58 Nguyen Oanh', 6, 0),
(12, 'Mai Van Vu', 'Nhân viên xưởng Cắt', '', '03657458971', 'trankienquoc122102004@gmail.com', 'Quang Trung', 7, 0),
(13, 'Mai Van Vu', 'Nhân viên xưởng Cắt', '', '1231333333', 'quannguyen2002619@gmail.com', '581 Nguyen Oanh g', 8, 0),
(14, 'Mai Van Vu', 'Nhân viên xưởng Cắt', '', '1234567890', '123333@gmail.com', '581 Nguyen Oanh', 9, 0),
(15, 'Mai Van Vu', 'Nhân viên xưởng Cắt', '', '12222222222', '1232221@gmail.com', '581 Nguyen Oanh', 10, 1);

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
(1, 'Vải cotton', 'Vải', 100, 'Tấm', '2m x 3m', NULL),
(2, 'Nút áo', 'Phụ kiện', 1000, 'Cái', 'Nút áo trắng', NULL),
(3, 'Chỉ may đen', 'Phụ kiện', 500, 'Cuộn', 'Chỉ may màu trắng', 1),
(4, 'Nút áo', 'Phụ kiện', 200, 'Cái', 'Nút áo màu đen', 1),
(5, 'Vải cotton', 'Vải', 300, 'Tấm', 'Vải cotton trắng', 1);

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
(6, 'phieu nhap kho', 'avd', ' sdsd', '2025-10-23', 2, 1, 20);

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
(8, 'Phiếu xuất NVL', 'Trần Kiến Quốc', '2025-10-31', 2, 23),
(9, 'Phiếu xuất NVL', 'TranKienQuoc', '2025-10-31', 1, 23),
(10, 'Phiếu xuất NVL', 'TranKienQuoc', '2025-11-02', 1, 24);

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
(1, 1, 1, 5, '2025-10-30', '');

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
(24, '2025-11-02', 'Đang xuất NVL', 'TranKienQuoc', 1, 1, 'Yêu cầu NVL cho KHSX1', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieuyeucaukiemtrachatluong`
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
-- Cấu trúc bảng cho bảng `phieuyeucaunhapkhonvl`
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
-- Đang đổ dữ liệu cho bảng `phieuyeucaunhapkhonvl`
--

INSERT INTO `phieuyeucaunhapkhonvl` (`maYCNK`, `maNVL`, `donViTinh`, `ngayLap`, `nhaCungCap`, `trangThai`, `tenNguoiLap`) VALUES
('1', 1, 'kg', '2025-10-22', 'abc', NULL, 'avsd');

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
(1, 'Áo sơ mi trắng', 'Áo', 5, 'Cái', 'Áo sơ mi trắng có thêu hoa cúc', 1, NULL);

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
(10, '1232221', '$2y$10$.QyQpjQWp3shgDbFMxqjn.zbzs7gAHhf/L10kS5jBO36Wuh.bQCa.', 'Hoạt động');

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
(8, 'Máy cắt vải', '2', 'Đang hoạt động', 1);

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
  ADD KEY `FK_BCLOI_THIETBI` (`maThietBi`);

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
  ADD KEY `FK_CTKHSX_DHSX` (`maDHSX`),
  ADD KEY `FK_CTKHSX_GNTP` (`maGNTP`),
  ADD KEY `FK_CTKHSX_XUONG` (`maXuong`),
  ADD KEY `FK_CTKHSX_NVL` (`maNVL`);

--
-- Chỉ mục cho bảng `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  ADD PRIMARY KEY (`maCTPX`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_NVL` (`maNVL`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_Phieu` (`maPhieu`),
  ADD KEY `FK_ChiTietPhieuXuatNVL_Xuong` (`maXuong`);

--
-- Chỉ mục cho bảng `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  ADD PRIMARY KEY (`maCTPKT`),
  ADD KEY `FK_CTPKT_SanPham` (`maSanPham`),
  ADD KEY `FK_CTPKT_PhieuYCKTCL` (`maYC`);

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
  ADD KEY `FK_KHSX_NGUOIDUNG` (`maND`);

--
-- Chỉ mục cho bảng `kho`
--
ALTER TABLE `kho`
  ADD PRIMARY KEY (`maKho`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`maND`),
  ADD KEY `FK_NGUOIDUNG_TAIKHOAN` (`maTK`);

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
  ADD UNIQUE KEY `phieuyeucaunhapkhonvl` (`maYCNK`),
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
  ADD KEY `FK_PhieuYCKTCL_SanPham` (`maSanPham`);

--
-- Chỉ mục cho bảng `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD PRIMARY KEY (`maYCNK`),
  ADD KEY `FK_YCNKNVL_NVL` (`maNVL`);

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
  MODIFY `maBaoCao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  MODIFY `maCTKHSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `chitietphieuxuatnvl`
--
ALTER TABLE `chitietphieuxuatnvl`
  MODIFY `maCTPX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  MODIFY `maCTPKT` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `chitiet_phieuyeucaucapnvl`
--
ALTER TABLE `chitiet_phieuyeucaucapnvl`
  MODIFY `maCTPhieuYCCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT cho bảng `chitiet_phieuyeucaunhapkhonvl`
--
ALTER TABLE `chitiet_phieuyeucaunhapkhonvl`
  MODIFY `maChiTiet_YCNK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `congviec`
--
ALTER TABLE `congviec`
  MODIFY `maCongViec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `donhangsanxuat`
--
ALTER TABLE `donhangsanxuat`
  MODIFY `maDonHang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `ghinhanthanhphamtheongay`
--
ALTER TABLE `ghinhanthanhphamtheongay`
  MODIFY `maGhiNhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `kehoachsanxuat`
--
ALTER TABLE `kehoachsanxuat`
  MODIFY `maKHSX` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `kho`
--
ALTER TABLE `kho`
  MODIFY `maKho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `maND` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `nvl`
--
ALTER TABLE `nvl`
  MODIFY `maNVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  MODIFY `maPNVL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `phieuxuatnvl`
--
ALTER TABLE `phieuxuatnvl`
  MODIFY `maPhieu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  MODIFY `maPhieuXuat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  MODIFY `maYCCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  MODIFY `maYC` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  MODIFY `maSanPham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `taikhoan`
--
ALTER TABLE `taikhoan`
  MODIFY `maTK` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `thietbi`
--
ALTER TABLE `thietbi`
  MODIFY `maThietBi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `xuong`
--
ALTER TABLE `xuong`
  MODIFY `maXuong` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `baocaoloi`
--
ALTER TABLE `baocaoloi`
  ADD CONSTRAINT `FK_BCLOI_THIETBI` FOREIGN KEY (`maThietBi`) REFERENCES `thietbi` (`maThietBi`);

--
-- Các ràng buộc cho bảng `chitietkehoachsanxuat`
--
ALTER TABLE `chitietkehoachsanxuat`
  ADD CONSTRAINT `FK_CTKHSX_GNTP` FOREIGN KEY (`maGNTP`) REFERENCES `ghinhanthanhphamtheongay` (`maGhiNhan`),
  ADD CONSTRAINT `FK_CTKHSX_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_CTKHSX_NVL` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`),
  ADD CONSTRAINT `FK_CTKHSX_XUONG` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`);

--
-- Các ràng buộc cho bảng `chitietphieuyeucaukiemtrachatluong`
--
ALTER TABLE `chitietphieuyeucaukiemtrachatluong`
  ADD CONSTRAINT `FK_CTPKT_PhieuYCKTCL` FOREIGN KEY (`maYC`) REFERENCES `phieuyeucaukiemtrachatluong` (`maYC`),
  ADD CONSTRAINT `FK_CTPKT_SanPham` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

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
  ADD CONSTRAINT `FK_KHSX_DHSX` FOREIGN KEY (`maDHSX`) REFERENCES `donhangsanxuat` (`maDHSX);
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
-- Các ràng buộc cho bảng `phieunhapnvl`
--
ALTER TABLE `phieunhapnvl`
  ADD CONSTRAINT `fk_phieunhapnvl_nvl` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`);

--
-- Các ràng buộc cho bảng `phieuxuatthanhpham`
--
ALTER TABLE `phieuxuatthanhpham`
  ADD CONSTRAINT `phieuxuatthanhpham_ibfk_1` FOREIGN KEY (`maDonHang`) REFERENCES `donhangsanxuat` (`maDonHang`),
  ADD CONSTRAINT `phieuxuatthanhpham_ibfk_2` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng buộc cho bảng `phieuyeucaucungcapnvl`
--
ALTER TABLE `phieuyeucaucungcapnvl`
  ADD CONSTRAINT `FK_PhieuYeuCauCungCapNVL_KHSX` FOREIGN KEY (`maKHSX`) REFERENCES `kehoachsanxuat` (`maKHSX`),
  ADD CONSTRAINT `FK_PhieuYeuCauCungCapNVL_NguoiDung` FOREIGN KEY (`maND`) REFERENCES `nguoidung` (`maND`);

--
-- Các ràng buộc cho bảng `phieuyeucaukiemtrachatluong`
--
ALTER TABLE `phieuyeucaukiemtrachatluong`
  ADD CONSTRAINT `FK_PhieuYCKTCL_SanPham` FOREIGN KEY (`maSanPham`) REFERENCES `san_pham` (`maSanPham`);

--
-- Các ràng buộc cho bảng `phieuyeucaunhapkhonvl`
--
ALTER TABLE `phieuyeucaunhapkhonvl`
  ADD CONSTRAINT `FK_YCNKNVL_NVL` FOREIGN KEY (`maNVL`) REFERENCES `nvl` (`maNVL`);

--
-- Các ràng buộc cho bảng `san_pham`
--
ALTER TABLE `san_pham`
  ADD CONSTRAINT `fk_sanpham_kho` FOREIGN KEY (`maKho`) REFERENCES `kho` (`maKho`);

--
-- Các ràng buộc cho bảng `thietbi`
--
ALTER TABLE `thietbi`
  ADD CONSTRAINT `fk_thietbi_xuong` FOREIGN KEY (`maXuong`) REFERENCES `xuong` (`maXuong`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
