<?php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper">
    <?php require_once 'app/views/layouts/sidebar.php'; ?>
    <main class="main-content">
        <div class="nhanvien-container">
            <h2>Sửa thông tin nhân viên</h2>
            <form method="POST" action="index.php?page=capnhatnv">
                <input type="hidden" name="maND" value="<?= $nhanvien['maND'] ?>">

                <label>Họ tên</label>
                <input type="text" name="hoTen" value="<?= htmlspecialchars($nhanvien['hoTen']) ?>">

                <label>Chức vụ</label>
                <input type="text" name="chucVu" value="<?= htmlspecialchars($nhanvien['chucVu']) ?>">

                <label>Phòng ban</label>
                <input type="text" name="phongBan" value="<?= htmlspecialchars($nhanvien['phongBan']) ?>">

                <label>Địa chỉ</label>
                <input type="text" name="diaChi" value="<?= htmlspecialchars($nhanvien['diaChi']) ?>">

                <label>Email</label>
                <input type="text" name="email" value="<?= htmlspecialchars($nhanvien['email']) ?>">

                <label>Số điện thoại</label>
                <input type="text" name="soDienThoai" value="<?= htmlspecialchars($nhanvien['soDienThoai']) ?>">

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                    <button type="button" onclick="window.history.back()">Hủy</button>
                </div>
            </form>
        </div>
    </main>
</div>

<style>
.nhanvien-container {
    background-color: #fff;
    border-radius: 12px;
    padding: 40px 50px;
    margin: 20px auto;
    max-width: 600px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}
label {
    display: block;
    margin-top: 10px;
    font-weight: 600;
}
input {
    width: 100%;
    padding: 8px;
    border-radius: 6px;
    border: 1px solid #ccc;
}
.form-buttons {
    text-align: center;
    margin-top: 20px;
}
.btn-primary {
    background-color: #007bff;
    color: white;
    padding: 8px 20px;
    border: none;
    border-radius: 6px;
}
</style>

<?php require_once 'app/views/layouts/footer.php'; ?>
