<?php require 'app/views/layouts/header.php'; ?>
<?php require 'app/views/layouts/nav.php'; ?>

<style>
.main-content { padding: 20px; background:#f6f8fb; }
.title { font-size:22px; font-weight:700; color:#0d1a44; margin-bottom:15px; }

.filter-box { display:flex; gap:10px; margin-bottom:15px; }
.filter-box input {
    padding:7px 12px;
    border:1px solid #ccc;
    border-radius:6px;
    width:260px;
}

.btn { padding:8px 14px; border-radius:6px; border:none; color:#fff; cursor:pointer; }
.btn-blue { background:#007bff; }
.btn-green { background:#28a745; }

.table-wrapper {
    background:#fff; border-radius:8px; padding:15px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

table { width:100%; border-collapse:collapse; margin-top:10px; }
th, td { padding:10px; border:1px solid #e1e4eb; text-align:center; }
th { background:#eef3ff; font-weight:600; }

.top-actions { text-align:right; margin-bottom:10px; }

.chart-box {
    background:#fff;
    margin-top:30px;
    padding:15px;
    border-radius:8px;
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
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
            <input type="text" name="search"
                placeholder="Tìm theo tên sản phẩm..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

            <button class="btn btn-blue">Tìm kiếm</button>
        </div>
    </form>

    <div class="table-wrapper">

        <!-- Nút CSV -->
        <div class="top-actions">
            <a class="btn btn-green"
               href="index.php?page=export_thongke&search=<?= urlencode($_GET['search'] ?? '') ?>">
               Xuất CSV
            </a>
        </div>

        <!-- Bảng -->
        <table>
            <thead>
                <tr>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn vị</th>
                    <th>Tổng SL</th>
                    <th>Tổng xuất</th>
                    <th>Tồn Kho</th>

                </tr>
            </thead>

            <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?= $row['maSanPham'] ?></td>
                    <td><?= $row['tenSanPham'] ?></td>
                    <td><?= $row['donVi'] ?></td>
                    <td><?= $row['tongSL'] ?></td>
                    <td><?= $row['tongXuat'] ?></td>
                    <td><?= $row['tonKho'] ?></td>

                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- BIỂU ĐỒ -->
    <div class="chart-box">
        <canvas id="chartTP"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    const labels = <?= json_encode(array_column($data, 'tenSanPham')) ?>;

    const tongSL  = <?= json_encode(array_column($data, 'tongSL')) ?>;
const tongXuat = <?= json_encode(array_column($data, 'tongXuat')) ?>;
const tonKho = <?= json_encode(array_column($data, 'tonKho')) ?>;

new Chart(document.getElementById('chartTP'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            { label: "Tổng SL", data: tongSL, backgroundColor:"#4CAF50" },
            { label: "Tổng xuất", data: tongXuat, backgroundColor:"#F44336" },
            { label: "Tồn Kho", data: tonKho, backgroundColor:"#2196F3" }
        ]
    }
});


    </script>

</main>
</div>

<?php require 'app/views/layouts/footer.php'; ?>
