<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunForTime - Trang chủ</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'layouts/header.php'; ?>
    <!-- Thanh điều hướng -->
    <?php
    require_once 'layouts/nav.php';
    ?>

    <div class="main-container">
        <!-- Sidebar -->
        <?php require_once 'layouts/sidebar.php';
        ; ?>


        <!-- Nội dung chính -->
        <div class="dashboard-container">
            <h1 class="dashboard-title">👋 Chào mừng bạn đến với Hệ thống Quản lý Sản Xuất</h1>
            <p class="dashboard-subtitle">Chọn danh mục bên trái để bắt đầu công việc của bạn.</p>

            <div class="dashboard-stats">
                <div class="card">
                    <h3>🧵 Đơn hàng đang sản xuất</h3>
                    <p>12</p>
                </div>
                <div class="card">
                    <h3>🏭 Tiến độ hoàn thành</h3>
                    <p>76%</p>
                </div>
                <div class="card">
                    <h3>👷‍♂️ Số công nhân đang làm việc</h3>
                    <p>58</p>
                </div>
                <div class="card">
                    <h3>⚙️ Báo cáo sự cố hôm nay</h3>
                    <p>3</p>
                </div>
            </div>

            <div class="dashboard-chart">
                <h2>📈 Biểu đồ năng suất</h2>
                <img src="public/images/chart-placeholder.png" alt="Biểu đồ năng suất" />
            </div>
        </div>
    </div>

    <!-- Đặt script ở cuối để DOM đã sẵn sàng -->
    <script src="/public/js/main.js"></script>
    <script src="/public/js/congnhan.js"></script>
    <?php include 'layouts/footer.php'; ?>
</body>

</html>