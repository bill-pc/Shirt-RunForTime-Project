<?php
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
                padding: 40px 50px;
                margin: 20px auto;
                max-width: 950px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            }
            h2 {
                text-align: center;
                color: #0d1a44;
                margin-bottom: 20px;
                font-weight: 700;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }
            th, td {
                border: 1px solid #e2e8f0;
                padding: 8px;
                text-align: center;
            }
            th {
                background-color: #f1f5fb;
                font-weight: 600;
                color: #0d1a44;
            }
            .btn {
                padding: 8px 14px;
                border-radius: 6px;
                font-weight: 600;
                cursor: pointer;
                border: none;
                transition: background 0.2s;
            }
            .btn-primary {
                background-color: #5a8dee;
                color: white;
            }
            .btn-primary:hover {
                background-color: #4076db;
            }
        </style>

        <div class="report-container">
            <h2>Thống kê kho nguyên vật liệu</h2>

            <!-- Form lọc -->
            <form id="formThongKe">
                <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
                    <div>
                        <label>Thời gian bắt đầu:</label><br>
                        <input type="date" name="start_date" required>
                    </div>
                    <div>
                        <label>Thời gian kết thúc:</label><br>
                        <input type="date" name="end_date" required>
                    </div>
                    <div>
                        <label>Tên NVL:</label><br>
                        <input type="text" name="tenNVL" placeholder="Nhập tên NVL...">
                    </div>
                </div>

                <div style="margin-bottom:20px;">
                    <label>Loại báo cáo:</label><br>
                    <input type="radio" name="loai_baocao" value="nhap" required> Nhập
                    <input type="radio" name="loai_baocao" value="xuat"> Xuất
                </div>

                <div style="text-align:center;">
                    <button type="submit" class="btn btn-primary">Thống kê</button>
                </div>
            </form>

            <!-- Bảng kết quả -->
            <table id="tableKho">
                <thead>
                    <tr>
                        <th>Mã NVL</th>
                        <th>Tên NVL</th>
                        <th>Đơn vị tính</th>
                        <th>Tổng nhập</th>
                        <th>Tổng xuất</th>
                        <th>Tồn kho</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="6" style="text-align:center;color:gray;">Không có dữ liệu để hiển thị</td></tr>
                </tbody>
            </table>

            <!-- Nút xuất CSV -->
            <div style="text-align:center; margin-top:15px;">
                <form method="POST" action="index.php?page=thongke_export">
                    <button type="submit" class="btn btn-primary">Xuất báo cáo</button>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
document.getElementById('formThongKe').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const res = await fetch('index.php?page=thongke-khonvl', {
        method: 'POST',
        body: formData
    });
    const data = await res.json();
    const tbody = document.querySelector('#tableKho tbody');
    tbody.innerHTML = '';

    if (data.length > 0) {
        data.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${row.maNVL}</td>
                <td>${row.tenNVL}</td>
                <td>${row.donViTinh}</td>
                <td>${row.tongNhap}</td>
                <td>${row.tongXuat}</td>
                <td>${row.tonKho}</td>
            `;
            tbody.appendChild(tr);
        });
    } else {
        tbody.innerHTML = `<tr><td colspan="6" style="color:gray;text-align:center;">Không có dữ liệu để hiển thị</td></tr>`;
    }
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>
