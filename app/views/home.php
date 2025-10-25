
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
        <?php require_once 'layouts/sidebar.php';; ?>


        <!-- Nội dung chính -->
        <div class="content">
            <h1>Chào mừng bạn đến với hệ thống quản lý!</h1>
            <p>Hãy chọn danh mục chức năng bên trái để bắt đầu làm việc.</p>
        </div>
    </div>

    <!-- Đặt script ở cuối để DOM đã sẵn sàng -->
    <script src="/public/js/main.js"></script>
    <script src="/public/js/congnhan.js"></script>
<?php include 'layouts/footer.php'; ?>
</body>
</html>
