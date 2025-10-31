<?php
// Tên file: app/views/kehoachsanxuat/create.php

// 1. Sửa đường dẫn include (giả định file này nằm trong /views/kehoachsanxuat/)
require_once 'layouts/header.php';
require_once 'layouts/nav.php'; // Thanh nav ngang


?>

<div class="main-layout-wrapper">

    <?php
    require_once 'layouts/sidebar.php';
    ?>

    <main class="main-content">
        <style>
            .form-group label {
                font-size: 18px;
                color: #000;
                font-weight: bold;
            }

            .form-group input {
                width: 60%;
                height: 20px;
            }

            .table-results {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }

            .table-results th,
            .table-results td {
                border: 1px solid #ddd;
                padding: 8px;
            }

            .table-results th {
                background-color: #f4f4f4;
            }

            /* Làm cho hàng có thể click được */
            .result-row {
                cursor: pointer;
            }

            .result-row:hover {
                background-color: #f0f0f0;
            }

            .modal-overlay {
                display: none;
                /* Ẩn ban đầu */
                position: fixed;
                /* Che phủ toàn màn hình */
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                /* Lớp mờ */

                /* Căn giữa nội dung */
                justify-content: center;
                align-items: center;
            }

            .modal-overlay.show {
                display: flex;
                /* Hiện modal */
            }

            .modal-content {
                background-color: #fff;
                padding: 20px;
                border-radius: 5px;
                width: 500px;
                max-width: 90%;
                position: relative;
                box-shadow: 0 5px 15px rgba(0, 0, 0, .3);
            }

            .close-btn {
                position: absolute;
                top: 10px;
                right: 15px;
                font-size: 24px;
                font-weight: bold;
                border: none;
                background: none;
                cursor: pointer;
            }
        </style>
        <div class="kehoach-form-container">
            <h2><?php echo $pageTitle ?? 'Lập kế hoạch sản xuất'; ?></h2>
            <hr>
            <div class="form-group">
                <label for="search-box">Tìm kiếm Đơn hàng (theo Tên hoặc Mã):</label>
                <input type="text" id="search-box" placeholder="Nhập mã hoặc tên đơn hàng...">
            </div>

            <table class="table-results">
                <thead>
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Tên Đơn Hàng</th>
                        <th>Ngày Giao</th>
                        <th>Trạng Thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="results-table-body">
                    <?php
                    // SỬA LẠI: Hiển thị 5 đơn hàng mặc định
                    // Biến $danhSachBanDau được gửi từ Controller
                    if (empty($danhSachBanDau)): ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">Không có đơn hàng nào.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($danhSachBanDau as $donHang): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($donHang['maDonHang']); ?></td>
                                <td><?php echo htmlspecialchars($donHang['tenDonHang']); ?></td>
                                <td><?php echo htmlspecialchars($donHang['ngayGiao']); ?></td>
                                <td><?php echo htmlspecialchars($donHang['trangThai']); ?></td>
                                <td>
                                    <button class="btn-chon" data-id="<?php echo $donHang['maDonHang']; ?>">
                                        Chọn
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</div>

<div id="order-modal" class="modal-overlay">
    <style>
        .modal-content
    </style>
    <div class="modal-content">
        <button id="close-modal-btn" class="close-btn">&times;</button>

        <h3>Lập Kế hoạch cho Đơn hàng</h3>

        <form action="index.php?page=luu-ke-hoach" method="POST">

            <input type="hidden" id="modal-maDonHang" name="maDonHang">

            <div class="form-group">
                <label>Mã Đơn Hàng:</label>
                <b id="modal-maDonHang-display"></b>
            </div>
            <div class="form-group">
                <label>Tên Đơn Hàng:</label>
                <b id="modal-tenDonHang"></b>
            </div>
            <div class="form-group">
                <label>Sản phẩm:</label>
                <b id="modal-tenSanPham"></b>
            </div>

            <div class="form-group">
                <label>Trạng thái</label>
                <b id="modal-trangThai"></b>
            </div>

            <div class="form-group">
                <label>Ngày Giao:</label>
                <b id="modal-ngayGiao" style="color: red; font-weight: bold;"></b>
            </div>

            <hr>

            <div class="form-group">
                <label for="ngay_bat_dau_kh">Ngày bắt đầu (Kế hoạch):</label>
                <input type="date" id="ngay_bat_dau_kh" name="ngay_bat_dau" required>
            </div>

            <div class="form-group">
                <label for="ngay_ket_thuc_kh">Ngày kết thúc (Kế hoạch):</label>
                <input type="date" id="ngay_ket_thuc_kh" name="ngay_ket_thuc" required readonly>
            </div>

            <button type="submit" class="btn-submit">Lưu Kế hoạch</button>
        </form>
    </div>
</div>

<?php
require_once 'layouts/footer.php';
?>
<script src="public/js/khsx.js"></script>