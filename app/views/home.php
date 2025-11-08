<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Hệ thống quản lý sản xuất</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <style>
        body {
            background-color: #f5f7fa;
            font-family: "Segoe UI", Roboto, sans-serif;
            margin: 0;
        }

        .welcome-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
            background: #fff;
            animation: fadeIn .8s ease-in-out;
        }

        .welcome-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, .1);
            padding: 50px 40px;
            max-width: 720px;
            width: 100%;
            text-align: center;
        }

        .login-btn {
            background: linear-gradient(45deg, #006bff, #004bd1);
            color: #fff;
            border: none;
            padding: 14px 40px;
            border-radius: 35px;
            font-size: 1.05em;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 123, 255, .35);
            transition: .25s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-container {
            flex: 1;
            min-width: 0;
            /* 🔥 Cho phép nội dung tự co khi màn hình nhỏ */
            padding: 30px 20px;
            overflow-x: hidden;
            /* 🔥 Ngăn không cho tràn ngang */
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .card {
            background: #fff;
            padding: 25px 20px;
            border-radius: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .08);
        }

        .panel {
            background: #fff;
            padding: 22px;
            border-radius: 18px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .08);
        }

        .grid-2-1 {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px 12px;
            border-bottom: 1px solid #eef0f3;
            font-size: 14px;
            color: #333;
        }

        .table th {
            color: #6b7280;
            text-align: left;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
        }

        .b-approved {
            background: #e7f1ff;
            color: #1f74ff;
        }

        .b-running {
            background: #e8fff2;
            color: #1ea25a;
        }

        .b-pending {
            background: #fff5e6;
            color: #b35c00;
        }

        .b-done {
            background: #efe9ff;
            color: #6f3eea;
        }
    </style>
</head>

<body>

    <?php include 'app/views/layouts/header.php'; ?>
    <?php include 'app/views/layouts/nav.php'; ?>

    <div class="main-container">

        <?php include 'app/views/layouts/sidebar.php'; ?>

        <?php if (!$isLoggedIn): ?>

            <!-- ============ GIAO DIỆN CHƯA ĐĂNG NHẬP ============ -->
            <div class="welcome-container">
                <div class="welcome-card">
                    <h1 style="font-size:2.2em;font-weight:800;color:#0b63ce;margin-bottom:12px;">👋 Chào mừng bạn đến hệ
                        thống QLSX</h1>
                    <p style="font-size:1.05em;color:#555;line-height:1.6;margin-bottom:28px;">
                        Giải pháp quản lý sản xuất thông minh – theo dõi kế hoạch, nguyên vật liệu và năng suất trong một
                        nền tảng duy nhất.
                    </p>
                    <button class="login-btn" onclick="window.location.href='index.php?page=login'">🔐 Đăng nhập
                        ngay</button>
                </div>
            </div>

        <?php else: ?>

            <!-- ============ DASHBOARD ============ -->
            <div class="dashboard-container">

                <!-- Welcome -->
                <div class="panel" style="margin-bottom:25px;">
                    <h1 style="font-size:1.9em;font-weight:700;color:#0b63ce;margin:0;">
                        👋 Chào mừng bạn, <?= htmlspecialchars($_SESSION['user']['hoTen'] ?? '') ?>!
                    </h1>
                    <p style="color:#666;margin-top:8px;">Dưới đây là tổng quan hoạt động sản xuất hôm nay.</p>
                </div>

                <!-- Cards thống kê -->
                <div class="dashboard-stats">
                    <div class="card" style="background:linear-gradient(135deg,#007bff,#2a73da);color:#fff;">
                        <h3>📋 Kế hoạch sản xuất</h3>
                        <p><?= $thongKe['tongKHSX'] ?? 0 ?></p>
                        <small>✅ Đã duyệt: <?= $thongKe['daDuyet'] ?? 0 ?> | ⏳ Chờ duyệt:
                            <?= $thongKe['choDuyet'] ?? 0 ?></small>
                    </div>

                    <div class="card" style="background:linear-gradient(135deg,#28a745,#56d57a);color:#fff;">
                        <h3>📦 Nguyên vật liệu</h3>
                        <p><?= $thongKe['tongNVL'] ?? 0 ?></p>
                        <small>Quản lý kho NVL</small>
                    </div>

                    <div class="card" style="background:linear-gradient(135deg,#ff9500,#ffb85c);color:#fff;">
                        <h3>🚚 Đơn hàng sản xuất</h3>
                        <p><?= $thongKe['tongDonHang'] ?? 0 ?></p>
                        <small>Cập nhật tiến độ giao hàng</small>
                    </div>

                    <div class="card" style="background:linear-gradient(135deg,#7045d8,#a26bff);color:#fff;">
                        <h3>⚙️ Thiết bị</h3>
                        <p><?= $thongKe['tongThietBi'] ?? 0 ?></p>
                        <small>Theo dõi tình trạng</small>
                    </div>
                </div>

                <!-- Năng suất + KHSX đang triển khai -->
                <div class="grid-2-1" style="margin-top:25px;margin-bottom:25px;">
                    <div class="panel">
                        <h3>📈 Năng suất sản xuất theo ngày</h3>
                        <canvas id="chartNangSuat"></canvas>
                    </div>

                    <div class="panel">
                        <h3>📋 KHSX đang triển khai</h3>
                        <table class="table">
                            <tr>
                                <th>Tên KHSX</th>
                                <th>Đơn hàng</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                            </tr>

                            <?php if (!empty($KHSXDangTrienKhai)): ?>
                                <?php foreach ($KHSXDangTrienKhai as $row): ?>
                                    <tr>
                                        <td><?= $row['tenKHSX'] ?></td>
                                        <td><?= $row['maDonHang'] ?></td>
                                        <td><?= $row['thoiGianBatDau'] ?> – <?= $row['thoiGianKetThuc'] ?></td>
                                        <td>
                                            <?php
                                            $st = trim($row['trangThai']);
                                            $cls = 'b-pending';
                                            if ($st == 'Đã duyệt')
                                                $cls = 'b-approved';
                                            if ($st == 'Đang sản xuất')
                                                $cls = 'b-running';
                                            ?>
                                            <span class="badge <?= $cls ?>"><?= $st ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align:center;">Không có dữ liệu</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

                <!-- Tồn kho + KHSX đã thực hiện -->
                <div class="grid-2-1">
                    <div class="panel">
                        <h3>🏭 Tồn kho NVL (Top 5)</h3>
                        <canvas id="chartTonKho"></canvas>
                    </div>

                    <div class="panel">
                        <h3>✅ KHSX đã thực hiện</h3>
                        <table class="table">
                            <tr>
                                <th>Tên KHSX</th>
                                <th>Đơn hàng</th>
                                <th>Thời gian</th>
                                <th>Trạng thái</th>
                            </tr>

                            <?php if (!empty($KHSXDaThucHien)): ?>
                                <?php foreach ($KHSXDaThucHien as $row): ?>
                                    <tr>
                                        <td><?= $row['tenKHSX'] ?></td>
                                        <td><?= $row['maDonHang'] ?></td>
                                        <td><?= $row['thoiGianBatDau'] ?> – <?= $row['thoiGianKetThuc'] ?></td>
                                        <td>
                                            <span class="badge b-done"><?= $row['trangThai'] ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align:center;">Không có dữ liệu</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </div>

            </div> <!-- END dashboard-container -->

            <!-- Chart -->
            <script>
                const nsLabels = <?= json_encode(array_column($duLieuBieuDo, 'ngay')) ?>;
                const nsValues = <?= json_encode(array_column($duLieuBieuDo, 'tongSoLuong')) ?>;

                new Chart(document.getElementById('chartNangSuat'), {
                    type: 'bar',
                    data: {
                        labels: nsLabels,
                        datasets: [{
                            data: nsValues,
                            backgroundColor: '#1f74ff'
                        }]
                    }
                });

                const nvlLabels = <?= json_encode(array_column($tonKhoNVL, 'tenNVL')) ?>;
                const nvlValues = <?= json_encode(array_column($tonKhoNVL, 'soLuongTonKho')) ?>;

                new Chart(document.getElementById('chartTonKho'), {
                    type: 'bar',
                    data: {
                        labels: nvlLabels,
                        datasets: [{
                            data: nvlValues,
                            backgroundColor: ['#1f74ff', '#ff8d2c', '#20c76a', '#8b4dff', '#ff3e6c']
                        }]
                    }
                });
                document.querySelectorAll('.dropdown-item').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const section = this.dataset.section;
                        loadSidebar(section);
                    });
                });

                function loadSidebar(sectionName) {
                    fetch('loadSidebar.php?section=' + sectionName)
                        .then(res => res.text())
                        .then(html => {
                            document.querySelector('.sidebar').innerHTML = html;
                        });
                }
            </script>

        <?php endif; ?>

    </div>

    <?php include 'app/views/layouts/footer.php'; ?>

</body>

</html>