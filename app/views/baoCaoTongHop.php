<?php
// app/views/baoCaoTongHop.php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper">
    <?php require_once 'app/views/layouts/sidebar.php'; ?>

    <main class="main-content">
        <style>
            .report-container {
                background-color: #fff;
                border-radius: 12px;
                padding: 30px 40px;
                margin: 20px auto;
                max-width: 1200px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            }

            h2 {
                text-align: center;
                color: #0d1a44;
                margin-bottom: 25px;
                font-weight: 700;
            }

            .filter-form {
                display: grid;
                grid-template-columns: 1fr 1fr 1fr 120px;
                gap: 15px;
                align-items: flex-end;
                margin-bottom: 25px;
                padding: 20px;
                background-color: #f8f9fa;
                border-radius: 8px;
            }

            .filter-form label {
                font-weight: 600;
                margin-bottom: 5px;
                display: block;
            }

            .filter-form input,
            .filter-form select {
                width: 100%;
                padding: 9px;
                border: 1px solid #ccc;
                border-radius: 6px;
            }

            .btn-loc {
                padding: 9px;
                border: none;
                border-radius: 6px;
                background-color: #5a8dee;
                color: white;
                font-weight: 600;
                cursor: pointer;
                height: 38px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }

            th,
            td {
                border: 1px solid #e2e8f0;
                padding: 10px;
                text-align: left;
            }

            th {
                background-color: #f1f5fb;
                font-weight: 600;
                color: #0d1a44;
            }

            .badge {
                padding: 3px 8px;
                border-radius: 4px;
                font-size: 0.85em;
                background-color: #e2e8f0;
                color: #333;
            }

            .badge-success {
                background-color: #d1fae5;
                color: #065f46;
            }

            .badge-warning {
                background-color: #fef3c7;
                color: #92400e;
            }

            .badge-danger {
                background-color: #fee2e2;
                color: #991b1b;
            }

            btn-view {
                display: inline-block;
                padding: 5px 12px;
                background-color: #5a8dee;
                color: white !important;
                /* Ghi đè màu link mặc định */
                text-decoration: none;
                border-radius: 5px;
                font-size: 0.9em;
                font-weight: 500;
                transition: background-color 0.2s;
                border: none;
                cursor: pointer;
            }

            .btn-view:hover {
                background-color: #4076db;
            }

            /* CSS Modal (Cửa sổ Pop-up) */
            .modal {
                display: none;
                /* Ẩn mặc định */
                position: fixed;
                z-index: 1000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.5);
                /* Lớp nền mờ */
                justify-content: center;
                align-items: center;
            }

            .modal-content {
                background-color: #fefefe;
                padding: 25px;
                border: 1px solid #888;
                border-radius: 10px;
                width: 800px;
                /* Kích thước modal */
                max-width: 90%;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                animation: fadeIn 0.3s;
            }

            .close-btn {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                border: none;
                background: none;
                cursor: pointer;
                line-height: 1;
            }

            .close-btn:hover,
            .close-btn:focus {
                color: black;
            }

            #modalTitle {
                color: #0d1a44;
                margin-top: 0;
                margin-bottom: 15px;
                border-bottom: 1px solid #ccc;
                padding-bottom: 10px;
            }

            #modalBody {
                max-height: 60vh;
                /* Giới hạn chiều cao, tự động cuộn */
                overflow-y: auto;
            }

            #modalBody table {
                font-size: 0.9em;
            }

            #modalBody table th,
            #modalBody table td {
                padding: 5px;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: scale(0.95);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }
        </style>

        <div class="report-container">
            <h2>BÁO CÁO TỔNG HỢP (Giám đốc)</h2>

            <form method="POST" action="index.php?page=bao-cao-tong-hop" class="filter-form">
                <div>
                    <label for="start_date">Từ ngày</label>
                    <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($filter_values['start']) ?>" required>
                </div>
                <div>
                    <label for="end_date">Đến ngày</label>
                    <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($filter_values['end']) ?>" required>
                </div>
                <div>
                    <label for="loai_bao_cao">Loại báo cáo</label>
                    <select id="loai_bao_cao" name="loai_bao_cao">
                        <option value="all" <?= $filter_values['loai'] == 'all' ? 'selected' : '' ?>>-- Tất cả các phiếu --</option>
                        <option value="baocaoloi" <?= $filter_values['loai'] == 'baocaoloi' ? 'selected' : '' ?>>Báo cáo lỗi</option>
                        <option value="phieunhapnvl" <?= $filter_values['loai'] == 'phieunhapnvl' ? 'selected' : '' ?>>Phiếu nhập NVL</option>
                        <option value="phieuxuatnvl" <?= $filter_values['loai'] == 'phieuxuatnvl' ? 'selected' : '' ?>>Phiếu xuất NVL</option>
                        <option value="phieuxuattp" <?= $filter_values['loai'] == 'phieuxuattp' ? 'selected' : '' ?>>Phiếu xuất TP</option>
                        <option value="yeucaunvl" <?= $filter_values['loai'] == 'yeucaunvl' ? 'selected' : '' ?>>Yêu cầu cung cấp NVL</option>
                        <option value="yeucauqc" <?= $filter_values['loai'] == 'yeucauqc' ? 'selected' : '' ?>>Yêu cầu QC</option>
                        <option value="yeucaunhapkho" <?= $filter_values['loai'] == 'yeucaunhapkho' ? 'selected' : '' ?>>Yêu cầu nhập kho NVL</option>
                        <option value="khsx" <?= $filter_values['loai'] == 'khsx' ? 'selected' : '' ?>>Kế hoạch sản xuất</option>
                        <option value="donhang" <?= $filter_values['loai'] == 'donhang' ? 'selected' : '' ?>>Đơn hàng sản xuất</option>
                        <option value="ghinhanthanhpham" <?= $filter_values['loai'] == 'ghinhanthanhpham' ? 'selected' : '' ?>>Ghi nhận thành phẩm</option>
                    </select>
                </div>
                <button type="submit" class="btn-loc">Lọc</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Loại Phiếu</th>
                        <th>Tên / Mã Phiếu</th>
                        <th>Người Lập</th>
                        <th>Trạng Thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($danhSachBaoCao)): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;color:gray;">Không có dữ liệu cho bộ lọc này.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($danhSachBaoCao as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['ngay_tao']))) ?></td>
                                <td><span class="badge"><?= htmlspecialchars($row['loai_phieu_text']) ?></span></td>
                                <td><?= htmlspecialchars($row['ten_phieu']) ?> (ID: <?= $row['id'] ?>)</td>
                                <td><?= htmlspecialchars($row['nguoi_lap'] ?? 'N/A') ?></td>
                                <td>
                                </td>

                                <td>
                                    <a href="#" class="btn-view"
                                        onclick="event.preventDefault(); showDetails(<?= $row['id'] ?>, '<?= $row['loai_phieu_key'] ?>')">
                                        Xem
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<div id="detailsModal" class="modal">
    <div class="modal-content">
        <button class="close-btn" onclick="closeDetails()">&times;</button>
        <h3 id="modalTitle">Chi tiết Báo cáo</h3>
        <div id="modalBody">
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('detailsModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');

    // Hàm gọi AJAX để lấy chi tiết
    async function showDetails(id, type) {
        modal.style.display = 'flex';
        modalTitle.innerText = `Chi tiết Phiếu (ID: ${id}, Loại: ${type})`;
        modalBody.innerHTML = '<p>Đang tải dữ liệu, vui lòng chờ...</p>';

        try {
            const res = await fetch(`index.php?page=ajax-get-report-details&id=${id}&type=${type}`);
            const data = await res.json();

            if (data.error) {
                modalBody.innerHTML = `<p style="color:red;">Lỗi: ${data.error}</p>`;
                return;
            }

            // Xây dựng HTML từ dữ liệu JSON
            let html = '<h4>Thông tin chung:</h4><ul style="list-style:none; padding-left:0;">';

            // 1. Hiển thị thông tin chung
            if (data.info) {
                for (const key in data.info) {
                    html += `<li style="margin-bottom:5px;"><strong>${key}:</strong> ${data.info[key] || 'N/A'}</li>`;
                }
            }
            html += '</ul>';

            // 2. Hiển thị bảng chi tiết (nếu có)
            if (data.items && data.items.length > 0) {
                html += '<h4 style="margin-top: 15px;">Chi tiết vật phẩm/NVL:</h4>';
                html += '<table style="width:100%; border-collapse: collapse;"><thead><tr style="background:#f0f0f0;">';

                // Tạo tiêu đề bảng (lấy key từ phần tử đầu tiên)
                Object.keys(data.items[0]).forEach(key => {
                    html += `<th style="border:1px solid #ccc; padding: 5px;">${key}</th>`;
                });
                html += '</tr></thead><tbody>';

                // Tạo các dòng dữ liệu
                data.items.forEach(item => {
                    html += '<tr>';
                    Object.values(item).forEach(val => {
                        html += `<td style="border:1px solid #ccc; padding: 5px;">${val || 'N/A'}</td>`;
                    });
                    html += '</tr>';
                });
                html += '</tbody></table>';
            }

            modalBody.innerHTML = html;

        } catch (err) {
            modalBody.innerHTML = `<p style="color:red;">Lỗi kết nối hoặc máy chủ: ${err.message}</p>`;
        }
    }

    // Hàm đóng Modal
    function closeDetails() {
        modal.style.display = 'none';
        modalBody.innerHTML = '';
    }

    // Đóng modal nếu người dùng click ra ngoài
    window.onclick = function(event) {
        if (event.target == modal) {
            closeDetails();
        }
    }
</script>
<?php require_once 'app/views/layouts/footer.php'; ?>