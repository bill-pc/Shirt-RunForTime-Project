<?php require 'app/views/layouts/header.php'; ?>
<?php require 'app/views/layouts/nav.php'; ?>

<style>
.main-content { padding: 20px; background: #f6f8fb; border-radius: 10px; }
.title { font-size: 22px; font-weight: 700; margin-bottom: 15px; color: #0d1a44; }
.filter-box { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 15px; }
.filter-box input { padding: 6px 10px; border-radius: 6px; border: 1px solid #ccc; }
.btn { padding: 8px 16px; border: none; border-radius: 6px; color: white; cursor: pointer; }
.btn-blue { background: #007bff; }
.btn-green { background: #28a745; }
.table-box { margin-top: 20px; }
table { width: 100%; border-collapse: collapse; background: #fff; }
th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
th { background: #eef4ff; font-weight: 600; }
.no-data { text-align: center; color: #666; margin-top: 15px; }
.export-box {
    margin-top: 15px;
    text-align: right; /* ĐẨY NÚT SANG PHẢI */
}
</style>

<div class="main-layout-wrapper">
    <?php require 'app/views/layouts/sidebar.php'; ?>
    <main class="main-content">
        <div class="title">Thống kê kho thành phẩm</div>

        
            
       

        <!-- Bảng -->
        <div class="table-box">
            <?php if (empty($data)): ?>
                <div class="no-data">Không có dữ liệu phù hợp</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Đơn vị</th>
                            <th>Số lượng tồn</th>
                            <th>Số lượng xuất</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach ($data as $row): ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= htmlspecialchars($row['maSanPham'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['tenSanPham'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['donVi'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['soLuongTon'] ?? '') ?></td>
                                <td><?= htmlspecialchars($row['soLuongXuat'] ?? '0') ?></td>
                                

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
            <?php endif; ?>
        </div>
        <div class="export-box">
    <a class="btn btn-green"
       href="index.php?page=export_thongke&from=<?= urlencode($_GET['from'] ?? '') ?>&to=<?= urlencode($_GET['to'] ?? '') ?>">
       Xuất báo cáo
    </a>
</div>

    </main>
    
</div>

<?php require 'app/views/layouts/footer.php'; ?>
