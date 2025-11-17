<?php
// app/views/ghiNhanThanhPham.php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper">
    <?php require_once 'app/views/layouts/sidebar.php'; ?>

    <main class="main-content">
        <div class="container" style="max-width: 1000px; margin: 0 auto; padding: 20px;">
            
            <h2 class="main-title" style="text-align: center; font-size: 1.5em; margin-bottom: 30px; color: #085da7;">
                GHI NHẬN THÀNH PHẨM HẰNG NGÀY
            </h2>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px 15px; border-radius: 5px; margin-bottom: 20px;">
                    <strong>Thành công!</strong> Đã lưu ghi nhận thành phẩm.
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error" style="background-color: #f8d7da; color: #721c24; padding: 12px 15px; border-radius: 5px; margin-bottom: 20px;">
                    <strong>Lỗi!</strong> Vui lòng điền đầy đủ thông tin hoặc kiểm tra lại.
                </div>
            <?php endif; ?>

            <div class="card" style="background-color: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px; margin-bottom: 30px;">
                <form method="POST" action="index.php?page=luu-ghi-nhan-tp" id="formGhiNhan">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                        
                        <div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="required">1. Chọn Kế hoạch sản xuất (Đã duyệt)</label>
                                <select name="maKHSX" id="maKHSX" class="form-control" required>
                                    <option value="">-- Chọn KHSX --</option>
                                    <?php foreach ($danhSachKHSX as $khsx): ?>
                                        <option value="<?= $khsx['maKHSX'] ?>"><?= htmlspecialchars($khsx['tenKHSX']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="required">2. Sản phẩm (Tự động theo KHSX)</label>
                                <input type="text" id="tenSanPham" class="form-control" readonly placeholder="Chọn KHSX để hiển thị sản phẩm">
                                <input type="hidden" name="maSanPham" id="maSanPham">
                            </div>
                        </div>

                        <div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="required">3. Chọn Nhân viên</label>
                                <select name="maNhanVien" id="maNhanVien" class="form-control" required>
                                    <option value="">-- Chọn nhân viên --</option>
                                    <?php foreach ($danhSachNhanVien as $nv): ?>
                                        <option value="<?= $nv['maND'] ?>"><?= htmlspecialchars($nv['hoTen']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="required">4. Xưởng (Tự động theo NV)</label>
                                <input type="text" id="tenXuong" class="form-control" readonly placeholder="Chọn nhân viên để hiển thị xưởng">
                            </div>
                        </div>

                        <div>
                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="required">5. Số lượng hoàn thành</label>
                                <input type="number" name="soLuong" class="form-control" placeholder="Nhập số lượng" required min="1">
                            </div>

                            <div class="form-group" style="margin-bottom: 20px;">
                                <label class="required">6. Ngày làm</label>
                                <input type="date" name="ngayLam" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="button-group" style="margin-top: 10px; text-align: center;">
                        <button type="submit" class="btn btn-primary" style="padding: 12px 50px; font-size: 1.1em; background-color: #085da7; border: none; border-radius: 5px; color: white; cursor: pointer;">
                            Lưu Ghi Nhận
                        </button>
                    </div>
                </form>
            </div>

            <div class="card" style="background-color: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 30px;">
                <h3 style="color: #085da7; margin-bottom: 20px; font-size: 1.2em;">Đã Ghi Nhận Hôm Nay (<?= date('d/m/Y') ?>)</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f8f9fa;">
                            <th style="border: 1px solid #dee2e6; padding: 10px;">Kế hoạch</th>
                            <th style="border: 1px solid #dee2e6; padding: 10px;">Sản phẩm</th>
                            <th style="border: 1px solid #dee2e6; padding: 10px;">Nhân viên</th>
                            <th style="border: 1px solid #dee2e6; padding: 10px;">Xưởng</th>
                            <th style="border: 1px solid #dee2e6; padding: 10px;">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($danhSachHomNay)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 15px; color: #6c757d; border: 1px solid #dee2e6;">Chưa có ghi nhận nào hôm nay.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($danhSachHomNay as $row): ?>
                                <tr>
                                    <td style="border: 1px solid #dee2e6; padding: 10px;"><?= htmlspecialchars($row['tenKHSX']) ?></td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px;"><?= htmlspecialchars($row['tenSanPham']) ?></td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px;"><?= htmlspecialchars($row['tenNhanVien']) ?></td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px;"><?= htmlspecialchars($row['tenXuong']) ?></td>
                                    <td style="border: 1px solid #dee2e6; padding: 10px; text-align: center; font-weight: bold;"><?= htmlspecialchars($row['soLuongSPHoanThanh']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<style>
    .form-control { width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-size: 1em; background-color: #fff; }
    .form-control[readonly] { background-color: #e9ecef; cursor: not-allowed; }
    .required::after { content: " *"; color: #dc3545; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Xử lý khi chọn KHSX
    document.getElementById('maKHSX').addEventListener('change', async function() {
        const maKHSX = this.value;
        const tenSanPhamInput = document.getElementById('tenSanPham');
        const maSanPhamInput = document.getElementById('maSanPham');

        // Reset
        tenSanPhamInput.value = 'Đang tải...';
        maSanPhamInput.value = '';

        if (!maKHSX) {
            tenSanPhamInput.value = 'Chọn KHSX để hiển thị sản phẩm';
            return;
        }

        try {
            const res = await fetch(`index.php?page=ajax-get-sp-theo-khsx&maKHSX=${maKHSX}`);
            const sanPham = await res.json();

            if (sanPham && sanPham.maSanPham) {
                tenSanPhamInput.value = sanPham.tenSanPham;
                maSanPhamInput.value = sanPham.maSanPham;
            } else {
                tenSanPhamInput.value = 'Không tìm thấy sản phẩm cho KHSX này';
            }
        } catch (err) {
            console.error(err);
            tenSanPhamInput.value = 'Lỗi khi tải sản phẩm';
        }
    });

    // 2. Xử lý khi chọn Nhân Viên
    document.getElementById('maNhanVien').addEventListener('change', async function() {
        const maND = this.value;
        const tenXuongInput = document.getElementById('tenXuong');

        // Reset
        tenXuongInput.value = 'Đang tải...';

        if (!maND) {
            tenXuongInput.value = 'Chọn nhân viên để hiển thị xưởng';
            return;
        }

        try {
            const res = await fetch(`index.php?page=ajax-get-xuong-nv&maND=${maND}`);
            const xuong = await res.json();

            if (xuong && xuong.phongBan) {
                tenXuongInput.value = xuong.phongBan;
            } else {
                tenXuongInput.value = 'Không tìm thấy xưởng cho nhân viên này';
            }
        } catch (err) {
            console.error(err);
            tenXuongInput.value = 'Lỗi khi tải xưởng';
        }
    });

});
</script>

<?php require_once 'app/views/layouts/footer.php'; ?>