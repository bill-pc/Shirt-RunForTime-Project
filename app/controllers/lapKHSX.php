<?php


require_once 'layouts/header.php';
require_once 'layouts/nav.php';


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

            .result-row {
                cursor: pointer;
            }

            .result-row:hover {
                background-color: #f0f0f0;
            }

            .modal-overlay {
                display: none;
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);

                justify-content: center;
                align-items: center;

            }

            .modal-overlay.show {
                display: flex;
            }



            /* --- CSS CHO MODAL POP-UP CHÍNH --- */

            .modal-content {
                background-color: #fff;
                padding: 25px 30px;
                border-radius: 8px;
                width: 600px;
                max-width: 90%;
                position: relative;
                box-shadow: 0 5px 15px rgba(0, 0, 0, .3);
                max-height: 90vh;
                overflow-y: auto;
            }


            /* Nút 'X' để đóng */
            .close-btn {
                position: absolute;
                top: 10px;
                right: 15px;
                font-size: 28px;
                font-weight: bold;
                line-height: 1;
                color: #888;
                border: none;
                background: none;
                cursor: pointer;
            }

            .close-btn:hover {
                color: #000;
            }

            .modal-content .form-group {
                margin-bottom: 15px;
            }

            .modal-content .form-group label {
                display: block;
                font-weight: 600;
                margin-bottom: 5px;
                color: #333;
            }

            .modal-content .form-group b {
                font-size: 1.1em;
                color: #0056b3;
            }

            .modal-content .form-group.inline-group {
                display: flex;
                align-items: baseline;
                /* Căn chỉnh theo dòng chữ */
                margin-bottom: 12px;
                /* Giảm khoảng cách giữa các dòng */
            }

            .modal-content .form-group.inline-group label {
                display: inline;
                /* Sửa từ 'block' thành 'inline' */
                margin-bottom: 0;
                /* Xóa khoảng cách dưới */
                margin-right: 8px;
                /* Thêm khoảng cách bên phải */
                font-weight: 600;
                color: #333;
            }

            .modal-content .form-group.inline-group b {
                font-size: 1.1em;
                color: #0056b3;
                /* Màu xanh */
            }

            .modal-content input[type="date"],
            .modal-content input[type="number"],
            .modal-content select {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                font-size: 1em;
            }

            /* Nút bấm */
            .modal-content .btn-submit {
                background-color: #007bff;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1em;
                font-weight: 600;
            }

            .modal-content .btn-submit:hover {
                background-color: #0056b3;
            }


            .confirm-exit-overlay {
                z-index: 2000;
                background-color: rgba(0, 0, 0, 0.75);
            }

            .confirm-box-content {
                width: 400px;
                padding: 30px;
                text-align: center;
            }

            .confirm-box-content p {
                font-size: 1.1em;
                margin-bottom: 25px;
            }

            .confirm-buttons {
                display: flex;
                justify-content: space-around;
            }

            .confirm-buttons button {
                padding: 10px 25px;
                border: none;
                border-radius: 5px;
                font-size: 1em;
                font-weight: 600;
                cursor: pointer;
            }

            .btn-secondary {
                background-color: #6c757d;
                color: white;
            }

            .btn-secondary:hover {
                background-color: #5a6268;
            }

            .btn-danger {
                background-color: #dc3545;
                color: white;
            }

            .btn-danger:hover {
                background-color: #c82333;
            }

            .filter-group {
                display: flex;
                gap: 15px;
                margin-bottom: 10px;
                align-items: center;
                background: #f8f9fa;
                padding: 10px;
                border-radius: 6px;
            }

            .filter-group label {
                font-weight: 600;
                margin-bottom: 0;
            }

            .filter-group input,
            .filter-group select {
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            /* CSS cho bảng KHSX mới */
            .khsx-list-container {
                margin-top: 30px;
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 8px;
            }

            .khsx-list-container h3 {
                text-align: center;
                color: #085da7;
                margin-bottom: 15px;
            }
        </style>
        <div class="kehoach-form-container">
            <h2><?php echo $pageTitle ?? 'Lập kế hoạch sản xuất'; ?></h2>
            <hr>

            <div class="form-group">
                <label for="search-box">Tìm kiếm Đơn hàng (theo Tên hoặc Mã):</label>
                <input type="text" id="search-box" placeholder="Nhập mã hoặc tên đơn hàng...">
            </div>

            <div class="filter-group">
                <label for="filter-tuNgay">Ngày giao từ:</label>
                <input type="date" id="filter-tuNgay">

                <label for="filter-denNgay">Đến ngày:</label>
                <input type="date" id="filter-denNgay">

                <button id="btn-clear-filters" class="btn-secondary">Xóa lọc</button>

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
                </tbody>
            </table>
        </div>

        <div class="khsx-list-container">
            <h3>Danh sách Kế hoạch sản xuất đã lập</h3>
            <table class="table-results">
                <thead>
                    <tr>
                        <th>Tên Kế hoạch</th>
                        <th>Mã Đơn hàng</th>
                        <th>Bắt đầu</th>
                        <th>Kết thúc</th>
                        <th>Trạng thái</th>
                        <th>Người lập</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($danhSachKHSX)): ?>
                        <?php foreach ($danhSachKHSX as $khsx): ?>
                            <tr>
                                <td><?= htmlspecialchars($khsx['tenKHSX']) ?></td>

                                <td><?= htmlspecialchars($khsx['maDonHang']) ?></td>

                                <td><?= htmlspecialchars($khsx['thoiGianBatDau']) ?></td>
                                <td><?= htmlspecialchars($khsx['thoiGianKetThuc']) ?></td>
                                <td><?= htmlspecialchars($khsx['trangThai']) ?></td>
                                <td><?= htmlspecialchars($khsx['tenNguoiLap']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Chưa có kế hoạch sản xuất nào được lập.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

</div>

<div id="order-modal" class="modal-overlay">
    <div class="modal-content">
        <button id="close-modal-btn" class="close-btn">&times;</button>
        <h3>Lập Kế hoạch cho Đơn hàng</h3>

        <form action="index.php?page=luu-ke-hoach" method="POST">
            <input type="hidden" id="modal-maDonHang" name="maDonHang">

            <div class="form-group inline-group"><label>Mã Đơn Hàng:</label> <b id="modal-maDonHang-display"></b></div>
            <div class="form-group inline-group"><label>Tên Đơn Hàng:</label> <b id="modal-tenDonHang"></b></div>
            <div class="form-group inline-group"><label>Sản phẩm (Gốc):</label> <b id="modal-tenSanPham"></b></div>
            <div class="form-group inline-group"><label>Đơn vị:</label> <b id="modal-donVi"></b></div>
            <div class="form-group inline-group"><label>Ngày Giao:</label> <b id="modal-ngayGiao" style="color: red;"></b></div>

            <div class="form-group">
                <label>Sản lượng TB/ngày (tham khảo):</label>
                <b id="modal-sanLuongTB"></b> <span>sản phẩm</span>
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

            <div class="xuong-block">
                <div class="xuong-header">
                    <h4>Phân công XƯỞNG CẮT</h4>
                </div>
                <div class="xuong-body">
                    <div class="form-group">
                        <label>Giao Sản phẩm:</label>
                        <select name="xuong_cat[maSanPham]" class="product-select" required>
                            <option value="">-- Chọn sản phẩm --</option>
                        </select>
                    </div>
                    <div class="nvl-list-container">
                        <label>Nguyên vật liệu:</label>
                        <div id="xuong-cat-nvl-list"></div> <button type="button" class="btn-add-nvl" data-target="xuong-cat-nvl-list">
                            + Thêm NVL
                        </button>
                    </div>
                </div>
            </div>

            <div class="xuong-block">
                <div class="xuong-header">
                    <h4>Phân công XƯỞNG MAY</h4>
                </div>
                <div class="xuong-body">
                    <div class="form-group">
                        <label>Giao Sản phẩm:</label>
                        <select name="xuong_may[maSanPham]" class="product-select" required>
                            <option value="">-- Chọn sản phẩm --</option>
                        </select>
                    </div>
                    <div class="nvl-list-container">
                        <label>Nguyên vật liệu:</label>
                        <div id="xuong-may-nvl-list"></div> <button type="button" class="btn-add-nvl" data-target="xuong-may-nvl-list">
                            + Thêm NVL
                        </button>
                    </div>
                </div>
            </div>

            <br>
            <button type="submit" class="btn-submit">Lưu Kế hoạch</button>
        </form>
    </div>
</div>

<div id="confirm-exit-modal" class="modal-overlay confirm-exit-overlay">
    <div class="modal-content confirm-box-content">
        <h4>Xác nhận thoát</h4>
        <p>Bạn có chắc chắn muốn đóng biểu mẫu này không? Mọi thông tin chưa lưu sẽ bị mất.</p>
        <div class="confirm-buttons">
            <button id="confirm-exit-no" class="btn btn-secondary">Ở lại</button>
            <button id="confirm-exit-yes" class="btn btn-danger">Thoát</button>
        </div>
    </div>
</div>

<div id="success-modal" class="modal-overlay success-overlay">
    <div class="modal-content success-box-content">
        <h3>Lập kế hoạch thành công</h3>
        <div class="success-buttons">
            <button id="success-yes" class="btn btn-secondary">Đồng ý</button>
        </div>
    </div>
</div>
<?php
require_once 'layouts/footer.php';
?>
<script src="public/js/khsx.js"></script>