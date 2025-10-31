<?php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper">
    <?php require_once 'app/views/layouts/sidebar.php'; ?>

    <main class="main-content">

        <h2 class="main-title" style="text-align:center; font-size: 1.5em; margin-bottom: 20px;">
            ĐĂNG NHẬP HỆ THỐNG
        </h2>

        <section class="login-section" style="display:flex; justify-content:center; align-items:center;">
            <div class="login-box" 
                style="background:#fff; padding:40px 50px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.1); width:100%; max-width:400px;">

                <form action="index.php?page=login-process" method="POST">
                    <div style="text-align:center; margin-bottom:25px;">
                        
                        <p style="color:#666; font-size:0.9em;">Hệ Thống Quản Lý Nhà Máy Sản Xuất Áo Sơ Mi</p>
                    </div>

                    <div style="margin-bottom:15px;">
                        <label for="username" style="display:block; text-align:left; font-weight:bold;">Tên Đăng Nhập</label>
                        <input type="text" id="username" name="username" placeholder="Nhập tên đăng nhập" required
                            style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                    </div>

                    <div style="margin-bottom:15px;">
                        <label for="password" style="display:block; text-align:left; font-weight:bold;">Mật Khẩu</label>
                        <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required
                            style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.9em; margin-bottom:15px;">
                        <label><input type="checkbox" name="remember"> Ghi nhớ tôi</label>
                        <a href="#" style="color:#007bff; text-decoration:none;">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" 
                        style="width:100%; background:#000; color:#fff; border:none; border-radius:6px; padding:10px; font-weight:bold; cursor:pointer;">
                        Đăng Nhập
                    </button>
                </form>

                <p style="text-align:center; font-size:0.8em; color:#666; margin-top:25px;">
                    © 2025 Hệ Thống Quản Lý Nhà Máy
                </p>
            </div>
        </section>
    </main>
</div>

<!-- Modal thông báo đăng nhập -->
<div class="modal-overlay" id="login-fail-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000;">
    <div class="modal-content" 
        style="background:white; padding:30px 40px; border-radius:10px; text-align:center; box-shadow:0 4px 15px rgba(0,0,0,0.2);">
        <p style="font-size:1.1em; font-weight:bold; color:#c0392b; margin-bottom:20px;">
            ❌ Sai tên đăng nhập hoặc mật khẩu!
        </p>
        <button id="btn-login-fail-close" 
            style="background:#f0f0f0; color:#333; border:1px solid #ccc; padding:8px 20px; border-radius:5px; cursor:pointer;">
            X | Đóng
        </button>
    </div>
</div>

<?php
require_once 'app/views/layouts/footer.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById('login-fail-modal');
    const btnClose = document.getElementById('btn-login-fail-close');
    const urlParams = new URLSearchParams(window.location.search);

    // Nếu có thông báo lỗi (ví dụ: ?error=1)
    if (urlParams.has('error') && urlParams.get('error') === '1') {
        modal.style.display = 'flex';
        const newUrl = window.location.pathname + window.location.search.replace(/&?error=1/, '').replace(/\?$/, '');
        window.history.replaceState({ path: newUrl }, '', newUrl);
    }

    btnClose.addEventListener('click', () => modal.style.display = 'none');
    modal.addEventListener('click', e => { if (e.target === modal) modal.style.display = 'none'; });
});
</script>