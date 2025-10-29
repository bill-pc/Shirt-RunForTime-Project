<nav class="navigation">
    <div class="nav-links">
        <a href="?page=home" class="nav-button">Trang chủ</a>
        <a href="#" class="nav-button">Giới thiệu</a>

        <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        ?>

        <!-- Nếu đã đăng nhập, bật dropdown bình thường -->
        <?php if(isset($_SESSION['user'])): ?>
            <button class="nav-button" id="menuDanhMuc">Danh mục</button>
        <?php else: ?>
            <!-- Nếu chưa đăng nhập, bấm alert -->
            <button class="nav-button" onclick="alert('Vui lòng đăng nhập để sử dụng danh mục chức năng!')">Danh mục</button>
        <?php endif; ?>

        <!-- Dropdown danh mục -->
        <div class="dropdown" id="dropdownDanhMuc">
            <button class="dropdown-item" data-section="tongquan"><i class="fa-solid fa-chart-line"></i> Tổng quan & Báo cáo</button>
            <button class="dropdown-item" data-section="nhansu"><i class="fa-solid fa-users"></i> Nhân sự</button>
            <button class="dropdown-item" data-section="sanxuat"><i class="fa-solid fa-industry"></i> Sản xuất</button>
            <button class="dropdown-item" data-section="khoNVL"><i class="fa-solid fa-boxes-stacked"></i> Kho nguyên liệu</button>
            <button class="dropdown-item" data-section="xuong"><i class="fa-solid fa-gears"></i> Xưởng sản xuất</button>
            <button class="dropdown-item" data-section="qc"><i class="fa-solid fa-clipboard-check"></i> Kiểm tra chất lượng</button>
            <button class="dropdown-item" data-section="khoTP"><i class="fa-solid fa-truck"></i> Kho thành phẩm</button>
            <button class="dropdown-item" data-section="congnhan"><i class="fa-solid fa-person-digging"></i> Công việc & Báo cáo</button>
        </div>
    </div>

    <div class="auth-section">
        <?php
        if (isset($_SESSION['user'])) {
            $tenHienThi = htmlspecialchars($_SESSION['user']['hoTen'] ?? 'Người dùng');
            echo '<a href="index.php?page=logout" class="nav-button">Đăng xuất</a>';
        } else {
            echo '<a href="index.php?page=login" class="nav-button">Đăng nhập</a>';
        }
        ?>
    </div>

    <!-- Đồng bộ PHP session với JS -->
    <script>
        if(<?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>){
            localStorage.setItem('isLoggedIn', 'true');
        } else {
            localStorage.removeItem('isLoggedIn');
        }
    </script>
</nav>
