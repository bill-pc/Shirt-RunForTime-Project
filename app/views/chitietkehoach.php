<?php require 'app/views/layouts/header.php'; ?>
<?php require 'app/views/layouts/nav.php'; ?>

<div class="main-layout-wrapper">
<?php require 'app/views/layouts/sidebar.php'; ?>

<main class="main-content">

<style>
.task-box {
    background: #fff;
    padding: 25px;
    margin: 20px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}
.task-box h2 {
    color: #0d1a44;
    font-weight: 700;
    margin-bottom: 15px;
}
table.task-table {
    width: 100%;
    border-collapse: collapse;
}
table.task-table th, 
table.task-table td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    text-align: center;
}
table.task-table th {
    background: #eef3ff;
    color: #1f3c88;
    font-weight: 600;
}
table.task-table tr:hover {
    background: #f7f9ff;
}
</style>

<div class="task-box">
    <h2>Chi tiết kế hoạch: <?= $plan['tenKHSX'] ?></h2>

    <table class="task-table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tiêu đề</th>
                <th>Mô tả</th>
                <th>Xưởng thực hiện</th>
                <th>Trạng thái</th>
                <th>Ngày hết hạn</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(empty($tasks)) { 
                echo "<tr><td colspan='6'>Không có công việc</td></tr>";
            } 
            else {
                $i=1;
                foreach ($tasks as $t): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $t['tieuDe'] ?></td>
                    <td><?= $t['moTa'] ?></td>
                    <td><?= $t['tenXuong'] ?></td>
                    <td><?= $t['trangThai'] ?></td>
                    <td><?= $t['ngayHetHan'] ?></td>
                </tr>
            <?php endforeach; } ?>
        </tbody>
    </table>

    <br>
    <a href="index.php?page=xemcongviec" class="btn btn-secondary">⬅ Quay lại</a>
</div>

</main>
</div>

<?php require 'app/views/layouts/footer.php'; ?>