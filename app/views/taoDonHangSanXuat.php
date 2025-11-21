<?php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper">
    <?php require_once 'app/views/layouts/sidebar.php'; ?>

    <main class="main-content">
        <div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
            <h2 class="main-title" style="text-align: center; font-size: 1.5em; margin-bottom: 30px; color: #085da7;">
                TẠO ĐƠN HÀNG SẢN XUẤT
            </h2>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 12px 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <strong>Lỗi!</strong> <?= isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'Đã xảy ra lỗi khi lưu đơn hàng.' ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                    <strong>Thành công!</strong> Đơn hàng sản xuất đã được tạo thành công.
                </div>
            <?php endif; ?>

            <div class="card" style="background-color: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px;">
                <form method="POST" action="index.php?page=luu-don-hang-san-xuat" id="formTaoDonHang">
                    <h3 style="color: #085da7; margin-bottom: 20px; font-size: 1.2em;">Thông Tin Đơn Hàng</h3>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="tenSanPham" class="required" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            Sản Phẩm 
                        </label>
                        <input 
                            type="text" 
                            id="tenSanPham" 
                            name="tenSanPham" 
                            class="form-control" 
                            list="danhSachSanPham"
                            placeholder="Nhập tên sản phẩm"
                            required
                            autocomplete="off"
                            style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 1em; transition: border-color 0.3s;"
                            onfocus="this.style.borderColor='#085da7'"
                            onblur="this.style.borderColor='#ddd'"
                        >
                        <datalist id="danhSachSanPham">
                            <?php if (!empty($danhSachSanPham)): ?>
                                <?php foreach ($danhSachSanPham as $sp): ?>
                                    <option value="<?= htmlspecialchars($sp['tenSanPham']) ?>"></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </datalist>
                        <input type="hidden" id="sanPhamId" name="sanPhamId">
                        <small style="color: #6c757d; display: block; margin-top: 6px;">Bạn có thể nhập tên sản phẩm mới nếu chưa có trong hệ thống.</small>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="soLuong" class="required" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            Số Lượng 
                        </label>
                        <input 
                            type="number" 
                            id="soLuong" 
                            name="soLuong" 
                            class="form-control" 
                            placeholder="Nhập số lượng" 
                            required
                            min="1"
                            style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 1em; transition: border-color 0.3s;"
                            onfocus="this.style.borderColor='#085da7'"
                            onblur="this.style.borderColor='#ddd'"
                        >
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="ngayGiao" class="required" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            Ngày Giao 
                        </label>
                        <input 
                            type="date" 
                            id="ngayGiao" 
                            name="ngayGiao" 
                            class="form-control" 
                            required
                            min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                            style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 1em; transition: border-color 0.3s;"
                            onfocus="this.style.borderColor='#085da7'"
                            onblur="this.style.borderColor='#ddd'"
                        >
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="diaChiNhan" class="required" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            Địa Chỉ Nhận 
                        </label>
                        <input 
                            type="text" 
                            id="diaChiNhan" 
                            name="diaChiNhan" 
                            class="form-control" 
                            placeholder="Nhập địa chỉ nhận hàng" 
                            required
                            style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 1em; transition: border-color 0.3s;"
                            onfocus="this.style.borderColor='#085da7'"
                            onblur="this.style.borderColor='#ddd'"
                        >
                    </div>

                    <div class="form-group" style="margin-bottom: 30px;">
                        <label for="ghiChu" style="display: block; margin-bottom: 8px; font-weight: 600; color: #333;">
                            Ghi Chú
                        </label>
                        <textarea 
                            id="ghiChu" 
                            name="ghiChu" 
                            class="form-control" 
                            placeholder="Nhập ghi chú (tùy chọn)"
                            rows="4"
                            style="width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 1em; font-family: inherit; resize: vertical; transition: border-color 0.3s;"
                            onfocus="this.style.borderColor='#085da7'"
                            onblur="this.style.borderColor='#ddd'"
                        ></textarea>
                    </div>

                    <div class="button-group" style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 30px;">
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            onclick="window.location.href='index.php?page=home'"
                            style="padding: 12px 30px; background-color: #6c757d; color: white; border: none; border-radius: 5px; font-size: 1em; cursor: pointer; transition: background-color 0.3s;"
                            onmouseover="this.style.backgroundColor='#5a6268'"
                            onmouseout="this.style.backgroundColor='#6c757d'"
                        >
                            Hủy
                        </button>
                        <button 
                            type="submit" 
                            class="btn btn-primary" 
                            id="btnLuu"
                            style="padding: 12px 30px; background-color: #085da7; color: white; border: none; border-radius: 5px; font-size: 1em; font-weight: 600; cursor: pointer; transition: background-color 0.3s;"
                            onmouseover="this.style.backgroundColor='#064a85'"
                            onmouseout="this.style.backgroundColor='#085da7'"
                        >
                            Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ✅ SỬA: Đặt ngày mai làm giá trị mặc định cho ngày giao
    const ngayGiaoInput = document.getElementById('ngayGiao');
    if (ngayGiaoInput && !ngayGiaoInput.value) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1); // Ngày mai
        const year = tomorrow.getFullYear();
        const month = String(tomorrow.getMonth() + 1).padStart(2, '0');
        const day = String(tomorrow.getDate()).padStart(2, '0');
        ngayGiaoInput.value = `${year}-${month}-${day}`;
    }

    // Map dữ liệu sản phẩm để tự động nhận diện khi người dùng nhập
    const danhSachSanPham = <?php echo json_encode($danhSachSanPham ?? [], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;
    const tenSanPhamInput = document.getElementById('tenSanPham');
    const sanPhamIdInput = document.getElementById('sanPhamId');

    const dongBoSanPhamId = () => {
        if (!tenSanPhamInput || !sanPhamIdInput) return;
        const value = tenSanPhamInput.value.trim().toLowerCase();
        const match = danhSachSanPham.find(sp => (sp.tenSanPham || '').toLowerCase() === value);
        sanPhamIdInput.value = match ? match.maSanPham : '';
    };

    if (tenSanPhamInput) {
        tenSanPhamInput.addEventListener('input', dongBoSanPhamId);
    }

    // Validate form trước khi submit
    const form = document.getElementById('formTaoDonHang');
    if (form) {
        form.addEventListener('submit', function(e) {
            const tenSanPham = tenSanPhamInput ? tenSanPhamInput.value.trim() : '';
            const soLuong = document.getElementById('soLuong').value;
            const ngayGiao = document.getElementById('ngayGiao').value;
            const diaChiNhan = document.getElementById('diaChiNhan').value.trim();

            if (!tenSanPham || !soLuong || !ngayGiao || !diaChiNhan) {
                e.preventDefault();
                alert('Vui lòng điền đầy đủ thông tin bắt buộc!');
                return false;
            }

            if (parseInt(soLuong, 10) <= 0) {
                e.preventDefault();
                alert('Số lượng phải lớn hơn 0!');
                return false;
            }

            // ✅ THÊM: Kiểm tra ngày giao phải lớn hơn ngày hiện tại
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);
            const selectedDate = new Date(ngayGiao + 'T00:00:00'); // So sánh đầu ngày
            if (selectedDate <= today) {
                e.preventDefault();
                alert('Ngày giao phải lớn hơn ngày hiện tại!');
                return false;
            }

            dongBoSanPhamId();
            return true;
        });
    }
});
</script>

<style>
.required::after {
    content: " *";
    color: #dc3545;
}

.form-control:focus {
    outline: none;
    border-color: #085da7 !important;
    box-shadow: 0 0 0 0.2rem rgba(8, 93, 167, 0.25);
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 15px !important;
    }
    
    .button-group {
        flex-direction: column;
    }
    
    .button-group button {
        width: 100%;
    }
}
</style>

