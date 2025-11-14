<?php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container-lich-lam-viec {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
    }

    .header-lich {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 2px solid #000;
    }

    .header-lich h1 {
        color: #000;
        font-size: 26px;
        margin-bottom: 5px;
    }

    .header-lich p {
        color: #333;
        font-size: 14px;
    }

    .schedule-section {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        border: 2px solid #000;
        text-align: center;
        margin-bottom: 20px;
    }

    .schedule-section h2 {
        color: #000;
        font-size: 18px;
        margin-bottom: 15px;
        border-bottom: 2px solid #000;
        padding-bottom: 8px;
    }

    .schedule-summary {
        font-size: 16px;
        margin-bottom: 20px;
        color: #333;
    }

    .btn-view {
        padding: 12px 24px;
        border-radius: 4px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        border: 2px solid #000;
        background: #fff;
        color: #000;
        transition: all 0.3s;
    }

    .btn-view:hover {
        background: #000;
        color: #fff;
    }

    .details-section {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        border: 2px solid #000;
        display: none;
    }

    .details-section.show {
        display: block;
    }

    .details-section h2 {
        color: #000;
        font-size: 18px;
        margin-bottom: 15px;
        border-bottom: 2px solid #000;
        padding-bottom: 8px;
    }

    .schedule-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .schedule-table th,
    .schedule-table td {
        padding: 12px;
        border: 1px solid #000;
        font-size: 14px;
        text-align: left;
    }

    .schedule-table th {
        background: #f2f2f2;
        font-weight: 600;
    }

    .schedule-table tr:nth-child(even) {
        background: #f9f9f9;
    }

    .btn-close {
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: 2px solid #000;
        background: #fff;
        color: #000;
        transition: all 0.3s;
        margin-top: 20px;
    }

    .btn-close:hover {
        background: #000;
        color: #fff;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .schedule-table {
            font-size: 12px;
        }

        .schedule-table th,
        .schedule-table td {
            padding: 8px;
        }
    }
</style>

<div class="main-layout-wrapper">
    <?php require_once 'app/views/layouts/sidebar.php'; ?>

    <main class="main-content">
        <div class="container-lich-lam-viec">
            <div class="header-lich">
                <h1>Xem Lịch Làm Việc</h1>
            </div>

            <div class="schedule-section">
                <h2>Tóm Tắt Lịch Làm Việc</h2>
                <div class="schedule-summary">
                    <p>Bạn có <strong><?= $tomTat['tongSoCa'] ?? 0 ?> ca làm việc</strong> trong tuần này.</p>
                    <?php if (!empty($tomTat['caGanNhat'])): ?>
                        <p>Ca gần nhất: <strong>
                            <?= htmlspecialchars($tomTat['caGanNhat']['thu']) ?>, 
                            Ngày <?= htmlspecialchars($tomTat['caGanNhat']['ngay']) ?>, 
                            <?= htmlspecialchars($tomTat['caGanNhat']['caLam']) ?> 
                            (<?= htmlspecialchars($tomTat['caGanNhat']['thoiGian']) ?>)
                        </strong></p>
                    <?php else: ?>
                        <p>Ca gần nhất: <strong>Chưa có ca làm việc</strong></p>
                    <?php endif; ?>
                </div>
                <button class="btn-view" onclick="viewSchedule()">Xem Thông Tin</button>
            </div>

            <div class="details-section" id="detailsSection">
                <h2>Ca Làm Việc Chi Tiết (Tuần Từ <?= htmlspecialchars($tuanHienTai['batDau']) ?>)</h2>
                
                <?php if (!empty($lichLamViec)): ?>
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Thứ</th>
                                <th>Ca Làm</th>
                                <th>Thời Gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($lichLamViec as $ca): ?>
                                <tr>
                                    <td><?= htmlspecialchars($ca['ngay']) ?></td>
                                    <td><?= htmlspecialchars($ca['thu']) ?></td>
                                    <td><?= htmlspecialchars($ca['caLam']) ?></td>
                                    <td><?= htmlspecialchars($ca['thoiGian']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p style="text-align: center; padding: 20px; color: #666;">
                        Không có ca làm việc nào trong tuần này.
                    </p>
                <?php endif; ?>
                
                <div style="text-align: center;">
                    <button class="btn-close" onclick="closeSchedule()">Đóng</button>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

<script>
    function viewSchedule() {
        document.getElementById('detailsSection').classList.add('show');
    }

    function closeSchedule() {
        document.getElementById('detailsSection').classList.remove('show');
    }
</script>

