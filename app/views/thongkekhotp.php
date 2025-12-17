<?php require 'app/views/layouts/header.php'; ?>
<?php require 'app/views/layouts/nav.php'; ?>

<style>
.main-content {
    padding: 20px;
    background: #f6f8fb;
}

.title {
    font-size: 22px;
    font-weight: 700;
    color: #0d1a44;
    margin-bottom: 15px;
}

/* Filter */
.filter-box {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}
.filter-box input {
    padding: 7px 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 260px;
}

/* Button */
.btn {
    padding: 8px 14px;
    border-radius: 6px;
    border: none;
    color: #fff;
    cursor: pointer;
}
.btn-blue { background: #007bff; }
.btn-green { background: #28a745; }

/* Table */
.table-wrapper {
    background: #fff;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
th, td {
    padding: 10px;
    border: 1px solid #e1e4eb;
    text-align: center;
}
th {
    background: #eef3ff;
    font-weight: 600;
}
.top-actions {
    text-align: right;
    margin-bottom: 10px;
}

/* Chart */
.chart-box {
    margin-top: 30px;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}
</style>

<div class="main-layout-wrapper">
<?php require 'app/views/layouts/sidebar.php'; ?>

<main class="main-content">

    <div class="title">Thống kê kho thành phẩm</div>

    <!-- Bộ lọc -->
    <form method="GET" action="index.php">
        <input type="hidden" name="page" value="thongke">

        <div class="filter-box">
            <input type="text"
                   name="search"
                   placeholder="Tìm theo tên sản phẩm..."
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button type="submit" class="btn btn-blue">Tìm kiếm</button>
        </div>
    </form>

    <!-- Bảng -->
    <div class="table-wrapper">

        <!-- Nút xuất CSV -->
        <div class="top-actions">
            <a class="btn btn-green"
               href="index.php?page=export_thongke&search=<?= urlencode($_GET['search'] ?? '') ?>">
                Xuất CSV
            </a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn vị</th>
                    <th>Tổng nhập</th>
                    <th>Tổng xuất</th>
                    <th>Tồn kho</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['maSanPham']) ?></td>
                        <td><?= htmlspecialchars($row['tenSanPham']) ?></td>
                        <td><?= htmlspecialchars($row['donVi']) ?></td>
                        <td><?= (int)$row['tongNhap'] ?></td>
                        <td><?= (int)$row['tongXuat'] ?></td>
                        <td><?= (int)$row['tonKho'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- BIỂU ĐỒ THỐNG KÊ -->
    <div class="chart-box">
        <canvas id="chartKhoTP" height="120"></canvas>
    </div>

</main>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = <?= json_encode(array_column($data ?? [], 'tenSanPham')) ?>;
const tongNhap = <?= json_encode(array_column($data ?? [], 'tongNhap')) ?>;
const tongXuat = <?= json_encode(array_column($data ?? [], 'tongXuat')) ?>;
const tonKho   = <?= json_encode(array_column($data ?? [], 'tonKho')) ?>;

if (labels.length > 0) {
    new Chart(document.getElementById('chartKhoTP'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Tổng nhập',
                    data: tongNhap,
                    backgroundColor: '#4CAF50'
                },
                {
                    label: 'Tổng xuất',
                    data: tongXuat,
                    backgroundColor: '#F44336'
                },
                {
                    label: 'Tồn kho',
                    data: tonKho,
                    backgroundColor: '#2196F3'
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
}
</script>

<?php require 'app/views/layouts/footer.php'; ?>
