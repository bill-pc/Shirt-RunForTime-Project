<?php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper_1">
    <?php require_once 'app/views/layouts/sidebar.php'; ?>

    <main class="main-content">
        <h2 class="main-title">THÔNG TIN CÁ NHÂN</h2>

        <div class="profile-layout">
            <!-- Cột trái -->
            <div class="profile-left">
                <div class="avatar-placeholder">👤</div>
                <div class="name-box">
                    <?php echo htmlspecialchars($user['hoTen'] ?? 'Không rõ'); ?>
                </div>
            </div>

            <!-- Cột phải -->
            <div class="profile-right">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Mã tài khoản</label>
                        <div class="input-box"><?php echo htmlspecialchars($user['maTK'] ?? ''); ?></div>
                    </div>

                    <div class="form-group">
                        <label>Chức vụ</label>
                        <div class="input-box"><?php echo htmlspecialchars($user['chucVu'] ?? ''); ?></div>
                    </div>

                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <div class="input-box"><?php echo htmlspecialchars($user['soDienThoai'] ?? ''); ?></div>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-box"><?php echo htmlspecialchars($user['email'] ?? ''); ?></div>
                    </div>

                    <div class="form-group full-width">
                        <label>Địa chỉ</label>
                        <div class="input-box"><?php echo htmlspecialchars($user['diaChi'] ?? ''); ?></div>
                    </div>
                </div>

                <div class="profile-footer">
                    <a href="index.php" class="btn-reject">← Thoát</a>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>
