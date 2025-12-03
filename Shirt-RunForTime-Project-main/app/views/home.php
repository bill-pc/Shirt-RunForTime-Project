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

        /* 🌟 Trang chào mừng khi chưa đăng nhập */
        /* 🌟 Khối chứa toàn bộ vùng chào mừng */
        .welcome-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
            background: #ffffffff;
            animation: fadeIn 0.8s ease-in-out;
        }

        /* 🌟 Thẻ chính hiển thị nội dung */
        .welcome-card {
            background: #cfd1d5ff;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            padding: 60px 50px;
            max-width: 650px;
            width: 100%;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .welcome-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* 🌟 Tiêu đề và nội dung */
        .welcome-card h1 {
            color: #085da7;
            font-size: 2em;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .welcome-card p {
            color: #555;
            font-size: 1.1em;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        /* 🌟 Nút đăng nhập */
        .login-btn {
            background: linear-gradient(45deg, #007bff, #0056d2);
            color: white;
            border: none;
            padding: 12px 35px;
            border-radius: 30px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background: linear-gradient(45deg, #0069d9, #004bb5);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.4);
        }

        /* 🌟 Hiệu ứng xuất hiện mượt */
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


        /* 🌟 Dashboard */
        .dashboard-container {
            flex: 1;
            padding: 30px 40px;
            background-color: #f5f7fa;
        }

        .dashboard-title {
            font-size: 1.8em;
            font-weight: 700;
            color: #085da7;
            margin-bottom: 10px;
        }

        .dashboard-subtitle {
            font-size: 1em;
            color: #555;
            margin-bottom: 25px;
        }

        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .card {
            background-color: #fff;
            padding: 25px 20px;
            border-radius: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s ease, box-shadow 0.3s ease;
            text-align: left;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        }

        .card h3 {
            color: #343a40;
            font-size: 1.05em;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1.8em;
            color: #007bff;
            font-weight: bold;
            margin: 5px 0;
        }

        .card small {
            font-size: 0.85em;
            color: #6c757d;
        }

        /* 🌟 Biểu đồ */
        .dashboard-chart {
            margin-top: 40px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        .chart-title {
            color: #085da7;
            font-size: 1.2em;
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }

        canvas {
            width: 100% !important;
            max-width: 100%;
            height: 400px !important;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <?php include 'app/views/layouts/header.php'; ?>
    <?php include 'app/views/layouts/nav.php'; ?>

    <div class="main-container">
        <?php include 'app/views/layouts/sidebar.php'; ?>

        <?php if (!$isLoggedIn): ?>
            <!-- 🟢 Giao diện chưa đăng nhập -->
            <div class="welcome-container">
                <div class="welcome-card">
                    <h1>👋 Chào mừng đến với Hệ thống Quản lý Sản Xuất</h1>
                    <p>Quản lý kế hoạch, nguyên vật liệu và sản xuất chỉ trong một nền tảng!</p>

                    <button class="login-btn" onclick="window.location.href='index.php?page=login'">
                        🔐 Đăng nhập ngay
                    </button>


                </div>
            </div>


        <?php else: ?>
            <!-- 🔹 Giao diện khi đã đăng nhập -->
            <div class="dashboard-container">
                <h1 class="dashboard-title">👋 Chào mừng bạn trở lại, <?= $_SESSION['user']['hoTen'] ?? '' ?>!</h1>
                <p class="dashboard-subtitle">Dưới đây là tổng quan về hoạt động sản xuất hôm nay:</p>

                <div class="dashboard-stats">
                    <div class="card">
                        <h3>📋 Kế hoạch sản xuất</h3>
                        <p><?= $thongKe['tongKHSX'] ?? 0 ?> kế hoạch</p>
                        <small>✅ Đã duyệt: <?= $thongKe['daDuyet'] ?? 0 ?> | ⏳ Chờ duyệt:
                            <?= $thongKe['choDuyet'] ?? 0 ?></small>
                    </div>

                    <div class="card">
                        <h3>📦 Nguyên vật liệu</h3>
                        <p><?= $thongKe['tongNVL'] ?? 0 ?> loại NVL</p>
                        <small>Quản lý kho NVL và tồn kho</small>
                    </div>

                    <div class="card">
                        <h3>🚚 Đơn hàng sản xuất</h3>
                        <p><?= $thongKe['tongDonHang'] ?? 0 ?> đơn hàng</p>
                        <small>Cập nhật tiến độ giao hàng</small>
                    </div>

                    <div class="card">
                        <h3>⚙️ Thiết bị</h3>
                        <p><?= $thongKe['tongThietBi'] ?? 0 ?> thiết bị</p>
                        <small>Theo dõi tình trạng hoạt động xưởng</small>
                    </div>
                </div>

                <div class="dashboard-chart">
                    <h2 class="chart-title">📈 Biểu đồ năng suất theo ngày</h2>
                    <canvas id="chartNangSuat"></canvas>
                </div>
            </div>

            <script>
                const labels = <?= json_encode(array_column($duLieuBieuDo ?? [], 'ngay')) ?>;
                const dataValues = <?= json_encode(array_map('intval', array_column($duLieuBieuDo ?? [], 'tongSoLuong'))) ?>;
                const ctx = document.getElementById('chartNangSuat').getContext('2d');
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(33, 114, 243, 0.9)');
                gradient.addColorStop(0.7, 'rgba(33, 114, 243, 0.6)');
                gradient.addColorStop(1, 'rgba(33, 114, 243, 0.3)');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels.map(date => new Date(date).toLocaleDateString('vi-VN')),
                        datasets: [{
                            label: 'Sản phẩm hoàn thành',
                            data: dataValues,
                            backgroundColor: gradient,
                            borderRadius: 12,
                            borderSkipped: false,
                            hoverBackgroundColor: '#1b6de1',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: { duration: 1200, easing: 'easeOutQuart' },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0b5ed7',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: '#0b5ed7',
                                borderWidth: 1,
                                padding: 10,
                                displayColors: false
                            },
                            datalabels: {
                                color: '#333',
                                anchor: 'end',
                                align: 'top',
                                font: { size: 13, weight: '600' },
                                formatter: value => value > 0 ? value : ''
                            }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { color: '#495057', font: { size: 13, weight: 500 }, padding: 8 } },
                            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)', lineWidth: 1 }, ticks: { color: '#6c757d', font: { size: 12 } } }
                        }
                    },
                    plugins: [ChartDataLabels]
                });
            </script>
        <?php endif; ?>
    </div>

    <?php include 'app/views/layouts/footer.php'; ?>
</body>

</html>