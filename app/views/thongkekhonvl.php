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
            .btn-success {
    background-color: #cfe9ff;   /* xanh nhạt */
    color: #0d1a44;
}

.btn-success:hover {
    background-color: #b7dcff;
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
                        <label style="font-size:14px;">
                            <input type="checkbox" id="chkAllNVL" name="all_nvl" value="1">
                            Thống kê tất cả nguyên vật liệu
                        </label>
                        <br>
                        <label>Tên NVL:</label><br>
                        <input type="text" name="tenNVL" id="inputTenNVL" placeholder="Nhập tên NVL...">
                        <div style="margin-top:5px;">
    </div>
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
            <div style="text-align:center; margin-top:25px;">
    <form id="formExport" method="GET" action="index.php">
        <input type="hidden" name="page" value="xuatcsv-thongkenvl">
        <input type="hidden" id="csv_all_nvl" name="all_nvl">
        <input type="hidden" id="csv_start_date" name="start_date">
        <input type="hidden" id="csv_end_date" name="end_date">
        <input type="hidden" id="csv_tenNVL" name="tenNVL">
        <input type="hidden" id="csv_loai" name="loai">
        <button type="submit" class="btn btn-success">📄 Xuất CSV</button>
    </form>
</div>

<div style="margin-top:30px;">
<h3 style="text-align:center;">Biểu đồ thống kê nhập - xuất NVL</h3>
<canvas id="chartKhoNVL" height="100"></canvas>
</div>

        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chartInstance = null;

const formThongKe = document.getElementById('formThongKe');
const inputNVL = document.getElementById('inputTenNVL');
const suggestBox = document.getElementById('suggestionsNVL');
const chkAllNVL = document.getElementById('chkAllNVL');

formThongKe.addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    // Nếu tick "Tất cả NVL" thì bỏ tên NVL
    if (chkAllNVL.checked) {
        formData.set('tenNVL', '');
    }

    const res = await fetch('index.php?page=thongke-khonvl', {
        method: 'POST',
        body: formData
    });

    let data = [];
    try {
        data = await res.json();
    } catch (err) {
        console.error('Lỗi parse JSON:', err);
        document.querySelector('#tableKho tbody').innerHTML =
            `<tr><td colspan="6" style="color:red;text-align:center;">Lỗi server</td></tr>`;
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
        renderChart(data);
    } else {
        tbody.innerHTML =
            `<tr><td colspan="6" style="color:gray;text-align:center;">Không có dữ liệu</td></tr>`;
    }

   // Sau khi có `data` từ server

let finalTenNVL = '';
if (!chkAllNVL.checked) {
    finalTenNVL = inputNVL.value.trim();
}
// Nếu để trống và không tick "Tất cả", thì finalTenNVL = '' → toàn bộ → OK

// Gán cho form xuất CSV
document.getElementById('csv_start_date').value = document.getElementById('start_date').value;
document.getElementById('csv_end_date').value = document.getElementById('end_date').value;
document.getElementById('csv_tenNVL').value = finalTenNVL;
document.getElementById('csv_all_nvl').value = chkAllNVL.checked ? '1' : '';
document.getElementById('csv_loai').value = '';
});

/* ================= CHECKBOX TẤT CẢ NVL ================= */
chkAllNVL.addEventListener('change', function() {
    if (this.checked) {
        inputNVL.value = '';
        inputNVL.disabled = true;
        inputNVL.style.background = '#f3f4f6';
    } else {
        inputNVL.disabled = false;
        inputNVL.style.background = '#fff';
    }
});

/* ================= GỢI Ý TÊN NVL ================= */
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

            li.onclick = () => {
                inputNVL.value = item.label;
                suggestBox.style.display = 'none';
            };

            suggestBox.appendChild(li);
        });

        suggestBox.style.display = 'block';
    } else {
        suggestBox.style.display = 'none';
    }
});

/* ================= BIỂU ĐỒ ================= */
function renderChart(data) {
    const labels = data.map(i => i.tenNVL);
    const tongNhap = data.map(i => Number(i.tongNhap));
    const tongXuat = data.map(i => Number(i.tongXuat));
    const tonKho   = data.map(i => Number(i.tonKho));

    const ctx = document.getElementById('chartKhoNVL').getContext('2d');

    if (chartInstance) chartInstance.destroy();

    chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tổng nhập',
                    data: tongNhap
                },
                {
                    label: 'Tổng xuất',
                    data: tongXuat
                },
                {
                    label: 'Tồn kho',
                    data: tonKho
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ctx.dataset.label + ': ' + ctx.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => value.toLocaleString()
                    }
                }
            }
        }
    });
}


/* Ẩn gợi ý khi click ngoài */
document.addEventListener('click', (e) => {
    if (!suggestBox.contains(e.target) && e.target !== inputNVL) {
        suggestBox.style.display = 'none';
    }
});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>
