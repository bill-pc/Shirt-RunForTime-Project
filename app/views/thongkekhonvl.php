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
                        <input type="date" id="start_date" name="start_date" required>
                    </div>
                    <div>
                        <label>Thời gian kết thúc:</label><br>
                        <input type="date" id="end_date" name="end_date" required>
                    </div>
                    <div>
                        <label>Tên NVL:</label><br>
                        <input type="text" name="tenNVL" id="inputTenNVL" placeholder="Nhập tên NVL...">
<ul id="suggestionsNVL" 
    style="position:absolute; background:white; border:1px solid #ccc; list-style:none; padding:0; margin-top:0; width:200px; max-height:150px; overflow-y:auto; display:none; z-index:10;"></ul>

                    </div>
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
            <div>
                <form id="formExport" method="GET" action="index.php">
    <input type="hidden" name="page" value="thongke-nvl-xuatcsv">
    <input type="hidden" id="csv_start_date" name="start_date" value="">
    <input type="hidden" id="csv_end_date" name="end_date" value="">
    <input type="hidden" id="csv_tenNVL" name="tenNVL" value="">
    <input type="hidden" id="csv_loai" name="loai" value="">
    <button type="submit" class="btn btn-success">📄 Xuất CSV</button>
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

    let data = [];
    try {
        data = await res.json();
    } catch (err) {
        console.error('Lỗi khi parse JSON:', err);
        const tbody = document.querySelector('#tableKho tbody');
        tbody.innerHTML = `<tr><td colspan="6" style="color:red;text-align:center;">Lỗi server, kiểm tra log.</td></tr>`;
        return;
    }

    const tbody = document.querySelector('#tableKho tbody');
    tbody.innerHTML = '';

    if (Array.isArray(data) && data.length > 0) {
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

    // Cập nhật dữ liệu ẩn cho form xuất CSV
    document.getElementById('csv_start_date').value = document.getElementById('start_date').value;
    document.getElementById('csv_end_date').value = document.getElementById('end_date').value;
    document.getElementById('csv_tenNVL').value = document.getElementById('inputTenNVL').value;
});

// --- Gợi ý tên NVL khi nhập ---
const inputNVL = document.getElementById('inputTenNVL');
const suggestBox = document.getElementById('suggestionsNVL');

inputNVL.addEventListener('input', async function() {
    const keyword = this.value.trim();
    if (keyword.length < 1) {
        suggestBox.style.display = 'none';
        return;
    }

    const res = await fetch(`index.php?page=search&type=nvl&keyword=${encodeURIComponent(keyword)}`);
    const data = await res.json();

    suggestBox.innerHTML = '';
    if (Array.isArray(data) && data.length > 0) {
        data.forEach(item => {
            const li = document.createElement('li');
            li.textContent = item.label;
            li.style.padding = '5px 10px';
            li.style.cursor = 'pointer';
            li.addEventListener('click', () => {
                inputNVL.value = item.label;
                suggestBox.style.display = 'none';
            });
            li.addEventListener('mouseover', () => li.style.background = '#f0f0f0');
            li.addEventListener('mouseout', () => li.style.background = '');
            suggestBox.appendChild(li);
        });
        suggestBox.style.display = 'block';
    } else {
        suggestBox.style.display = 'none';
    }
});

// Ẩn gợi ý khi click ngoài
document.addEventListener('click', (e) => {
    if (!suggestBox.contains(e.target) && e.target !== inputNVL) {
        suggestBox.style.display = 'none';
    }
});
</script>
<?php require_once 'app/views/layouts/footer.php'; ?>
