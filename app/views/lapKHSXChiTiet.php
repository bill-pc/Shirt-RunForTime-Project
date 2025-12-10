<?php
require_once 'layouts/header.php';
require_once 'layouts/nav.php';
?>

<div class="main-layout-wrapper">
    <?php require_once 'layouts/sidebar.php'; ?>

    <main class="main-content">
        <h2 class="page-title">📋 Lập Kế hoạch Sản xuất - Đơn hàng:
            <?= htmlspecialchars($donHang['tenDonHang'] ?? 'Không rõ') ?>
        </h2>

        <!-- Thông tin đơn hàng -->
        <div class="order-info">
            <div><b>Mã Đơn Hàng:</b> <?= htmlspecialchars($donHang['maDonHang']) ?></div>
            <div><b>Sản phẩm:</b> <?= htmlspecialchars($donHang['tenSanPham']) ?></div>
            <div><b>Số lượng sản xuất:</b> <span
                    id="soLuongSanPham"><?= htmlspecialchars($donHang['soLuongSanXuat'] ?? 0) ?></span></div>
            <div><b>Ngày giao:</b> <span id="ngayGiao" style="color:#dc3545;">
                    <?= date('d/m/Y', strtotime($donHang['ngayGiao'])) ?>
                </span>
            </div>
        </div>

        <form action="index.php?page=luu-ke-hoach" method="post">
            <input type="hidden" name="maDonHang" value="<?= htmlspecialchars($donHang['maDonHang']) ?>">

            <!-- Ngày bắt đầu tổng (do bạn chọn) -->
            <div class="plan-row">
                <div class="plan-col">
                    <label class="field-label">Ngày bắt đầu KHSX</label>
                    <input type="date" id="ngay_bat_dau" name="ngay_bat_dau">
                    <small class="field-note">Chọn ngày bắt đầu kế hoạch (mặc định là ngày lập)</small>
                </div>
                <div class="plan-col">
                    <label class="field-label">Ngày kết thúc KHSX</label>
                    <input type="date" id="ngay_ket_thuc" name="ngay_ket_thuc" readonly>
                    <small class="field-note"> Ngày kết thúc KHSX mặc định là ngày giao hàng</small>
                </div>
            </div>

            <!-- Xưởng Cắt -->
            <div class="xuong-block cut">
                <h3 class="xuong-heading">XƯỞNG CẮT ✂️</h3>
                <div class="xuong-body">
                    <div class="row">
                        <label class="field-label">KPI (Sản Phẩm / Ngày)</label>
                        <input type="number" class="cat-kpi" name="xuong_cat[kpi]" min="1" value="" step="1">
                    </div>
                    <div class="kpi-note">
                        <span style="font-size: 15px;">KPI tối thiểu: <b id="cat-kpi-min">—</b></span>
                        <span class="kpi-warning" id="cat-kpi-warn" style="display:none;color:#b02a37;">KPI đã được điều
                            chỉnh lên tối thiểu để kịp tiến độ</span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="field-label">Ngày bắt đầu cắt</label>
                            <input type="date" class="cat-start" name="xuong_cat[ngayBatDau]">
                        </div>
                        <div class="col">
                            <label class="field-label">Hoàn thành cắt vào</label>
                            <input type="date" class="cat-end" name="xuong_cat[ngayKetThuc]">
                        </div>
                    </div>

                    <div class="nvl-section" id="xuong-cat-container">
                        <label class="field-label">Nguyên vật liệu (Cắt)</label>
                        <div class="nvl-row">
                            <select name="xuong_cat[nvl_id][]" required>
                                <option value="">-- Chọn NVL --</option>
                                <?php foreach ($danhSachNVL as $nvl): ?>
                                    <option value="<?= $nvl['maNVL'] ?>"><?= htmlspecialchars($nvl['tenNVL']) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <div class="nvl-inputs">
                                <label class="small-label">Định mức / 1 SP</label>
                                <input type="number" name="xuong_cat[nvl_dinhMuc][]" min="0" step="0.01" value="1"
                                    required>

                                <label class="small-label">Tổng NVL cần</label>
                                <input type="number" name="xuong_cat[nvl_soLuong][]" min="0" value="0" readonly>
                            </div>

                            <button type="button" class="btn-remove-nvl" title="Xóa NVL">&times;</button>
                        </div>

                        <button type="button" class="btn-add-nvl" data-target="xuong-cat-container">+ Thêm NVL</button>
                        <div class="nvl-dates" aria-hidden="true">
                            <small style="font-size: 13px;" id="cat-note-start"></small>
                            <small style="font-size: 13px;" id="cat-note-end"></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Xưởng May -->
            <div class="xuong-block sew">
                <h3 class="xuong-heading">XƯỞNG MAY 👕</h3>
                <div class="xuong-body">
                    <div class="row">
                        <label class="field-label">KPI (Sản Phẩm / Ngày)</label>
                        <input type="number" class="may-kpi" name="xuong_may[kpi]" min="1" value="" step="1">
                    </div>
                    <div class="kpi-note">
                        <span style="font-size: 15px;">KPI tối thiểu: <b id="may-kpi-min">—</b></span>
                        <span class="kpi-warning" id="may-kpi-warn" style="display:none;color:#b02a37;">KPI đã được điều
                            chỉnh lên tối thiểu để kịp tiến độ</span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label class="field-label">Ngày bắt đầu may</label>
                            <input type="date" class="may-start" name="xuong_may[ngayBatDau]">
                        </div>
                        <div class="col">
                            <label class="field-label">Hoàn thành may vào</label>
                            <input type="date" class="may-end" name="xuong_may[ngayKetThuc]">
                        </div>
                    </div>

                    <div class="nvl-section" id="xuong-may-container">
                        <label class="field-label">Nguyên vật liệu (May)</label>
                        <div class="nvl-row">
                            <select name="xuong_may[nvl_id][]" required>
                                <option value="">-- Chọn NVL --</option>
                                <?php foreach ($danhSachNVL as $nvl): ?>
                                    <option value="<?= $nvl['maNVL'] ?>"><?= htmlspecialchars($nvl['tenNVL']) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <div class="nvl-inputs">
                                <label class="small-label">Định mức / 1 SP</label>
                                <input type="number" name="xuong_may[nvl_dinhMuc][]" min="0" value="1" step="0.01"
                                    required>

                                <label class="small-label">Tổng NVL cần</label>
                                <input type="number" name="xuong_may[nvl_soLuong][]" min="0" value="0" readonly>
                            </div>

                            <button type="button" class="btn-remove-nvl" title="Xóa NVL">&times;</button>
                        </div>

                        <button type="button" class="btn-add-nvl" data-target="xuong-may-container">+ Thêm NVL</button>
                        <div class="nvl-dates" aria-hidden="true">
                            <small style="font-size: 13px;" id="may-note-start"></small>
                            <small style="font-size: 13px;" id="may-note-end"></small>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">Lưu Kế hoạch & Phân công</button>
        </form>
    </main>
</div>

<?php require_once 'layouts/footer.php'; ?>

<script>
    /* ====== CẤU HÌNH & HELPER ====== */
    const SO_LUONG = parseInt(document.getElementById('soLuongSanPham').textContent.replace(/\./g, '')) || 0;
    // Lưu ý: Hàm parseDateVN cần xử lý kỹ chuỗi ngày
    const elNgayGiao = document.getElementById('ngayGiao');
    const NGAY_GIAO = parseDateVN(elNgayGiao.textContent.trim());

    /* Helper: Format ngày VN (dd/mm/yyyy) */
    function formatVN(dateStr) {
        if (!dateStr) return "";
        const d = new Date(dateStr);
        // Fix lỗi hiển thị ngày do múi giờ
        return [
            String(d.getDate()).padStart(2, '0'),
            String(d.getMonth() + 1).padStart(2, '0'),
            d.getFullYear()
        ].join('/');
    }

    /* Helper: Parse ngày VN sang Date Obj */
    function parseDateVN(dateStr) {
        if (!dateStr) return null;
        const [d, m, y] = dateStr.split('/');
        return new Date(y, m - 1, d);
    }

    /* Helper: Parse ISO (yyyy-mm-dd) sang Date Obj (Local Time - Fix lỗi lệch ngày) */
    function parseDateISO(dateStr) {
        if (!dateStr) return null;
        const [y, m, d] = dateStr.split('-').map(Number);
        return new Date(y, m - 1, d);
    }

    /* Helper: Date Obj sang ISO (yyyy-mm-dd) */
    function formatISO(dateObj) {
        if (!dateObj) return '';
        const y = dateObj.getFullYear();
        const m = String(dateObj.getMonth() + 1).padStart(2, '0');
        const d = String(dateObj.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    /* Helper: Cộng trừ ngày */
    function addDays(dateObj, delta) {
        if (!dateObj) return null;
        const d = new Date(dateObj.getFullYear(), dateObj.getMonth(), dateObj.getDate());
        d.setDate(d.getDate() + delta);
        return d;
    }

    /* Helper: Tính khoảng cách ngày (bao gồm cả ngày bắt đầu) */
    function diffDaysInclusive(start, end) {
        if (!start || !end) return 0;
        // Reset giờ về 0 để tính chính xác số ngày
        const s = new Date(start.getFullYear(), start.getMonth(), start.getDate());
        const e = new Date(end.getFullYear(), end.getMonth(), end.getDate());
        const ms = e - s;
        return Math.floor(ms / (1000 * 60 * 60 * 24)) + 1;
    }

    /* ====== DOM ELEMENTS ====== */
    const inputNgayKHSX = document.getElementById('ngay_bat_dau');
    const inputNgayKetThuc = document.getElementById('ngay_ket_thuc');

    const catKpiInput = document.querySelector('.cat-kpi');
    const mayKpiInput = document.querySelector('.may-kpi');
    const catKpiMinEl = document.getElementById('cat-kpi-min');
    const mayKpiMinEl = document.getElementById('may-kpi-min');
    const catKpiWarn = document.getElementById('cat-kpi-warn');
    const mayKpiWarn = document.getElementById('may-kpi-warn');

    const catStartInput = document.querySelector('.cat-start');
    const catEndInput = document.querySelector('.cat-end');
    const mayStartInput = document.querySelector('.may-start');
    const mayEndInput = document.querySelector('.may-end');

    /* ====== KHỞI TẠO MẶC ĐỊNH ====== */
    if (!inputNgayKHSX.value) {
        inputNgayKHSX.value = formatISO(new Date());
    }

    /* ====== LOGIC CỐT LÕI (CORE LOGIC) ====== */
    function updatePlan() {
        // 1. INPUT: Ngày bắt đầu KHSX
        const planStart = parseDateISO(inputNgayKHSX.value) || new Date();

        // 2. INPUT: Ngày kết thúc May (Dự kiến)
        // Mặc định = Ngày Giao - 2 ngày (để đóng gói/xuất hàng)
        // User có thể chọn ngày khác, nhưng không được quá Ngày Giao - 1
        let mayEndTarget = parseDateISO(mayEndInput.value);
        const limitMayEnd = addDays(NGAY_GIAO, -2); // Giới hạn trần

        if (!mayEndTarget) {
            // Nếu chưa có, set mặc định
            mayEndTarget = limitMayEnd;
            mayEndInput.value = formatISO(mayEndTarget);
        } else if (mayEndTarget > addDays(NGAY_GIAO, -1)) {
            // Nếu chọn quá sát ngày giao -> Cảnh báo & Reset
            alert("⚠️ Ngày kết thúc may phải trước ngày giao hàng ít nhất 1-2 ngày để đóng gói!");
            mayEndTarget = limitMayEnd;
            mayEndInput.value = formatISO(mayEndTarget);
        }

        // Cập nhật ngày kết thúc tổng của Kế hoạch = Ngày giao hàng (cố định)
        inputNgayKetThuc.value = formatISO(NGAY_GIAO);


        // --- TÍNH TOÁN XƯỞNG CẮT ---

        // 3. Ngày Bắt đầu Cắt
        // Mặc định = Plan Start + 1 (hoặc user chọn)
        let catStart = parseDateISO(catStartInput.value);
        if (!catStart || catStart < planStart) {
            catStart = addDays(planStart, 1);
            catStartInput.value = formatISO(catStart);
        }

        // 4. Ngày Kết thúc Cắt & KPI Cắt
        let catKpi = parseInt(catKpiInput.value) || 0;
        let catDays = 0;
        let catEnd = null;

        // Giới hạn: Cắt phải xong trước khi May xong ít nhất 2 ngày (để còn chuyền hàng)
        const limitCatEnd = addDays(mayEndTarget, -1);

        if (catKpi > 0) {
            // CASE A: User nhập KPI -> Tính ngày kết thúc
            catDays = Math.ceil(SO_LUONG / catKpi);
            catEnd = addDays(catStart, catDays - 1);

            // Kiểm tra va chạm: Nếu làm chậm quá (KPI thấp) -> Vượt quá giới hạn
            if (catEnd > limitCatEnd) {
                // Ép về giới hạn cuối cùng
                catEnd = limitCatEnd;
                catEndInput.value = formatISO(catEnd);

                // Tính lại KPI tối thiểu cần thiết
                const realDays = diffDaysInclusive(catStart, catEnd);
                const requiredKpi = Math.ceil(SO_LUONG / Math.max(1, realDays));

                catKpiWarn.style.display = 'inline';
                catKpiWarn.textContent = `KPI nhập quá thấp! Để kịp tiến độ phải cắt tối thiểu ${requiredKpi} SP/ngày`;
                catKpiMinEl.textContent = requiredKpi;
            } else {
                catEndInput.value = formatISO(catEnd);
                catKpiWarn.style.display = 'none';
                catKpiMinEl.textContent = Math.ceil(SO_LUONG / Math.max(1, catDays));
            }
        } else {
            // CASE B: User chưa nhập KPI -> Tính KPI gợi ý dựa trên thời gian max
            // Mặc định cho Cắt chiếm khoảng 40% tổng thời gian hoặc user tự chỉnh ngày end
            // Ở đây ta set mặc định Cat End cách May End một khoảng an toàn
            if (!parseDateISO(catEndInput.value)) {
                // Nếu chưa chọn ngày End, mặc định cho làm đến sát nút (limitCatEnd) để hiển thị Min KPI dễ thở nhất
                catEnd = limitCatEnd;
                catEndInput.value = formatISO(catEnd);
            } else {
                catEnd = parseDateISO(catEndInput.value);
                // Nếu user chọn ngày End quá xa -> Ép lại
                if (catEnd > limitCatEnd) {
                    catEnd = limitCatEnd;
                    catEndInput.value = formatISO(catEnd);
                }
            }

            const realDays = diffDaysInclusive(catStart, catEnd);
            const suggestedKpi = Math.ceil(SO_LUONG / Math.max(1, realDays));
            catKpiMinEl.textContent = suggestedKpi;
            catKpiWarn.style.display = 'none';
        }


        // --- TÍNH TOÁN XƯỞNG MAY ---

        // 5. Ngày Bắt đầu May
        // Logic: May Start >= Cắt Start + 1
        let mayStart = parseDateISO(mayStartInput.value);
        const minMayStart = addDays(parseDateISO(catStartInput.value), 1);

        if (!mayStart || mayStart < minMayStart) {
            mayStart = minMayStart;
            mayStartInput.value = formatISO(mayStart);
        }

        // 6. Ngày Kết thúc May & KPI May
        let mayKpi = parseInt(mayKpiInput.value) || 0;
        let mayDays = 0;
        // mayEndTarget đã được tính ở bước 2

        if (mayKpi > 0) {
            // CASE A: User nhập KPI -> Tính ngày End
            mayDays = Math.ceil(SO_LUONG / mayKpi);
            let calculatedMayEnd = addDays(mayStart, mayDays - 1);

            // Kiểm tra Deadline
            if (calculatedMayEnd > mayEndTarget) {
                // Cảnh báo nhưng không tự sửa ngày End (vì ngày End là chốt chặn cuối)
                // Chỉ báo là KHÔNG KỊP
                const realDays = diffDaysInclusive(mayStart, mayEndTarget);
                const requiredKpi = Math.ceil(SO_LUONG / Math.max(1, realDays));

                mayKpiWarn.style.display = 'inline';
                mayKpiWarn.textContent = `Không kịp giao! Phải may ${requiredKpi} SP/ngày`;
                mayKpiMinEl.textContent = requiredKpi;
            } else {
                // Kịp -> Cập nhật ngày kết thúc thực tế (có thể xong sớm hơn dự kiến)
                mayEndInput.value = formatISO(calculatedMayEnd);
                mayKpiWarn.style.display = 'none';
                mayKpiMinEl.textContent = Math.ceil(SO_LUONG / Math.max(1, mayDays));
            }
        } else {
            // CASE B: Tự tính KPI theo thời gian
            const realDays = diffDaysInclusive(mayStart, mayEndTarget);
            const suggestedKpi = Math.ceil(SO_LUONG / Math.max(1, realDays));
            mayKpiMinEl.textContent = suggestedKpi;
            mayKpiWarn.style.display = 'none';
        }

        // --- CẬP NHẬT NVL ---
        document.querySelectorAll('.nvl-row').forEach(row => {
            const dinhMuc = parseFloat(row.querySelector('input[name$="[nvl_dinhMuc][]"]').value) || 0;
            const out = row.querySelector('input[name$="[nvl_soLuong][]"]');
            if (out) out.value = (dinhMuc * SO_LUONG).toFixed(2).replace(/\.00$/, '');
        });

        // --- CẬP NHẬT GHI CHÚ NHỎ ---
        updateNotes();
    }

    function updateNotes() {
        const catS = parseDateISO(catStartInput.value);
        const catE = parseDateISO(catEndInput.value);
        const mayS = parseDateISO(mayStartInput.value);
        const mayE = parseDateISO(mayEndInput.value);

        if (document.getElementById('cat-note-start')) document.getElementById('cat-note-start').textContent = `Bắt đầu: ${formatVN(formatISO(catS))}`;
        if (document.getElementById('cat-note-end')) document.getElementById('cat-note-end').textContent = `Kết thúc: ${formatVN(formatISO(catE))}`;

        if (document.getElementById('may-note-start')) document.getElementById('may-note-start').textContent = `Bắt đầu: ${formatVN(formatISO(mayS))}`;
        if (document.getElementById('may-note-end')) document.getElementById('may-note-end').textContent = `Kết thúc: ${formatVN(formatISO(mayE))}`;
    }

    /* ====== EVENT LISTENERS ====== */

    // 1. Thay đổi ngày bắt đầu KHSX
    inputNgayKHSX.addEventListener('change', updatePlan);

    // 2. Thay đổi ngày trong các xưởng
    catStartInput.addEventListener('change', updatePlan);
    catEndInput.addEventListener('change', updatePlan);
    mayStartInput.addEventListener('change', updatePlan);

    // Riêng May End: Khi thay đổi cần check không được quá Ngày Giao
    mayEndInput.addEventListener('change', function () {
        const d = parseDateISO(this.value);
        if (d > addDays(NGAY_GIAO, -1)) {
            alert('Ngày kết thúc may quá sát ngày giao hàng!');
            this.value = formatISO(addDays(NGAY_GIAO, -2));
        }
        updatePlan();
    });

    // 3. Thay đổi KPI (Debounce nhẹ hoặc change)
    catKpiInput.addEventListener('input', updatePlan); // Dùng input để tính realtime
    mayKpiInput.addEventListener('input', updatePlan);

    // 4. NVL Events
    document.addEventListener('input', function (e) {
        if (e.target && e.target.matches('input[name$="[nvl_dinhMuc][]"]')) {
            updatePlan();
        }
    });

    // Add/Remove NVL logic (Giữ nguyên như cũ)
    const addBtns = document.querySelectorAll('.btn-add-nvl');
    addBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const container = document.getElementById(this.dataset.target);
            const row = container.querySelector('.nvl-row');
            const clone = row.cloneNode(true);
            const select = clone.querySelector('select');
            if (select) select.value = '';
            clone.querySelectorAll('input').forEach(inp => {
                if (inp.hasAttribute('readonly')) {
                    inp.value = 0;
                } else {
                    inp.value = (inp.name && inp.name.includes('dinhMuc')) ? 1 : '';
                }
            });
            container.appendChild(clone);
            updatePlan();
        });
    });
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('btn-remove-nvl')) {
            const row = e.target.closest('.nvl-row');
            const container = row.parentElement;
            if (container.querySelectorAll('.nvl-row').length > 1) {
                row.remove();
                updatePlan();
            }
        }
    });

    /* Khởi chạy lần đầu */
    updatePlan();
</script>

<style>
    /* CSS đẹp, đồng đều — giữ gần như layout cũ, chỉnh cho cân chỉnh */
    body {
        font-family: "Segoe UI", system-ui, -apple-system, "Helvetica Neue", Arial;
        background: #f8f9fa;
        color: #222;
    }

    .main-content {
        padding: 20px;
    }

    .page-title {
        text-align: center;
        color: #007bff;
        margin-bottom: 18px;
        font-size: 22px;
        font-weight: 600;
    }

    .order-info {
        background: #fff;
        padding: 12px 14px;
        border-radius: 8px;
        margin-bottom: 18px;
        display: flex;
        gap: 18px;
        flex-wrap: wrap;
        font-size: 15px;
        box-shadow: 0 1px 4px rgba(15, 15, 15, 0.05);
    }

    .plan-row {
        display: flex;
        gap: 18px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .plan-col {
        flex: 1;
        min-width: 200px;
        display: flex;
        flex-direction: column;
    }

    .field-label {
        font-weight: 600;
        margin-bottom: 6px;
        font-size: 15px;
        color: #333;
    }

    .field-note {
        font-size: 13px;
        color: #666;
        margin-top: 6px;
        display: block;
    }

    .row {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .col {
        flex: 1;
        min-width: 180px;
        display: flex;
        flex-direction: column;
    }

    input[type="date"],
    input[type="number"],
    select {
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid #d0d7de;
        height: 40px;
        font-size: 14px;
        background: white;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        opacity: 0.6;
    }

    .xuong-block {
        margin-bottom: 18px;
        border-radius: 8px;
        padding: 14px;
        background: #fff;
        box-shadow: 0 1px 8px rgba(20, 20, 20, 0.04);
    }

    .xuong-block.cut {
        border-left: 4px solid #1565c0;
    }

    .xuong-block.sew {
        border-left: 4px solid #ef6c00;
    }

    .xuong-heading {
        margin: 0 0 8px 0;
        font-size: 16px;
        color: #333;
    }

    .nvl-section {
        margin-top: 10px;
    }

    .nvl-row {
        display: flex;
        gap: 10px;
        align-items: flex-end;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .nvl-row select {
        min-width: 180px;
        flex: 1;
    }

    .nvl-inputs {
        display: flex;
        gap: 8px;
        align-items: center;
        flex: 2;
        min-width: 260px;
    }

    .nvl-inputs .small-label {
        display: block;
        font-size: 13px;
        color: #555;
        margin-bottom: 4px;
    }

    .nvl-inputs input {
        flex: 1;
        padding: 8px 10px;
        border-radius: 6px;
        border: 1px solid #d0d7de;
        height: 38px;
    }

    .nvl-dates {
        margin-top: 8px;
        display: flex;
        gap: 8px;
        color: #555;
        font-size: 13px;
    }

    .kpi-note {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-bottom: 8px;
        font-size: 13px;
        color: #444;
    }

    .kpi-note b {
        color: #0b5ed7;
    }

    .kpi-warning {
        font-size: 13px;
        margin-left: 8px;
    }

    .btn-add-nvl {
        background: #28a745;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 8px 10px;
        cursor: pointer;
        font-size: 13px;
    }

    .btn-remove-nvl {
        background: #dc3545;
        color: #fff;
        border: none;
        border-radius: 6px;
        width: 36px;
        height: 36px;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 16px;
    }

    .btn-submit {
        background: #007bff;
        color: #fff;
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background: #0060d6;
    }

    input[readonly] {
        background: #f3f4f6;
        cursor: not-allowed;
    }

    .small-label {
       
        color: #333;
        margin-bottom: 4px;
    }

    @media (max-width:800px) {
        .plan-row {
            flex-direction: column;
        }

        .nvl-inputs {
            flex-direction: column;
        }
    }

    /* ----- CANH CHUẨN CHO KHU VỰC NVL ----- */

    /* Đảm bảo mỗi dòng NVL nằm tách biệt */
    .nvl-section {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    /* Mỗi row NVL rõ ràng, khoảng cách đẹp */
    .nvl-row {
        background: #f9fafb;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #e0e6eb;
    }

    /* Nút thêm NVL nằm riêng một dòng */
    .btn-add-nvl {
        align-self: flex-start;
        margin-top: 4px;
    }

    /* Ghi chú nhỏ nằm dưới cùng – không ép nằm cùng dòng */
    .nvl-dates {
        margin-top: 4px;
        display: block !important;
        /* đổi từ flex → block */
        font-size: 12px;
        color: #6c757d;
    }

    .nvl-dates small {
        display: inline-block;
        margin-right: 12px;
    }

    /* Giảm kích thước dòng NVL khi nhiều item */
    .nvl-inputs {
        gap: 12px;
    }

    /* Responsive tốt hơn */
    @media (max-width: 768px) {
        .nvl-row {
            flex-direction: column;
            align-items: stretch;
        }
    }

    /* Bọc khu vực NVL theo chiều dọc */
    .nvl-section {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Mỗi dòng NVL */
    .nvl-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding: 10px;
        border: 1px solid #e4e7ea;
        border-radius: 6px;
        background: #fafbfc;
    }

    /* Nút thêm NVL luôn bám sát ngay dưới các dòng NVL */
    .btn-add-nvl {
        align-self: flex-start;
        margin-top: 0;
        order: 99;
        /* đảm bảo đứng sau các .nvl-row */
    }

    /* Ghi chú luôn dưới nút thêm */
    .nvl-dates {
        order: 100;
        margin-top: -4px;
        display: block;
        font-size: 12px;
        color: #6c757d;
    }

    /* ====== FONT & BASE ====== */
    body {
        font-family: "Segoe UI", -apple-system, BlinkMacSystemFont, system-ui;
        font-size: 14px;
        line-height: 1.45;
        color: #1f1f1f;
    }

    /* ====== PAGE TITLE ====== */
    .page-title {
        
        font-weight: 700;
        margin-bottom: 18px;
        text-align: center;
        background: linear-gradient(90deg, #007bff, #005fcc);
        -webkit-background-clip: text;
        color: transparent;
    }

    /* ====== LABEL ====== */
    .field-label,
    .small-label {
        font-weight: 700;
        color: #020d1fff;
    }

   

    .field-note {
        
        color: #777;
    }

    /* ====== INPUTS ====== */
    input[type="date"],
    input[type="number"],
    select {
        padding: 8px 10px;
        border-radius: 6px;
        border: 1.5px solid #c6d4e1;
        background: white;
        font-size: 14px;
        transition: 0.2s;
    }

    input:focus,
    select:focus {
        border-color: #1a73e8;
        box-shadow: 0 0 3px rgba(26, 115, 232, 0.5);
        outline: none;
    }

    /* ====== BLOCK ====== */
    .xuong-block {
        padding: 14px;
        background: #fff;
        border-radius: 8px;
        margin-bottom: 18px;
        border: 1.5px solid #dbe5f3;
        box-shadow: 0 2px 8px rgba(20, 20, 20, 0.05);
    }

    /* Màu riêng cho từng xưởng */
    .xuong-block.cut .xuong-heading {
        color: #0a58ca;
        border-left: 4px solid #0d6efd;
        padding-left: 8px;
    }

    .xuong-block.sew .xuong-heading {
        color: #d35400;
        border-left: 4px solid #f39c12;
        padding-left: 8px;
    }

    .xuong-heading {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    /* ====== NVL ROW ====== */
    .nvl-row {
        display: flex;
        gap: 10px;
        padding: 10px;
        background: #f5f8ff;
        border-radius: 6px;
        border: 1px solid #d4e0f2;
    }

    .nvl-inputs input {
        font-size: 13px;
    }

    .nvl-dates small {
        color: #555;
    }

    /* ====== BUTTONS ====== */
    .btn-add-nvl {
        background: linear-gradient(135deg, #28a745, #1e7e34);
        color: #fff;
        font-weight: 600;
        padding: 7px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    .btn-add-nvl:hover {
        background: linear-gradient(135deg, #24963f, #176b2b);
    }

    .btn-remove-nvl {
        background: #dc3545;
        width: 34px;
        height: 34px;
        border-radius: 6px;
        border: none;
        color: white;
        font-size: 16px;
        cursor: pointer;
        font-weight: bold;
    }

    .btn-remove-nvl:hover {
        background: #b02a37;
    }

    .btn-submit {
        background: linear-gradient(135deg, #0069d9, #004eac);
        border: none;
        padding: 12px;
        color: white;
        width: 100%;
        border-radius: 7px;
        margin-top: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #005fcc, #003f91);
    }

    /* ====== ORDER INFO ====== */
    .order-info {
        
        background: #eef4ff;
        border: 1px solid #ccd9f6;
        color: #0b3d91;
    }

    /* ====== KPI NOTE ====== */
    .kpi-note {
        font-size: 13px;
    }

    .kpi-note b {
        color: #0d6efd;
    }

    .kpi-warning {
        font-size: 13px;
        font-weight: 600;
        color: #d9534f !important;
    }
    /* ==== ORDER INFO: Kiểu đóng khung từng ô ==== */
.order-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 16px;
    margin-bottom: 20px;
}

.order-info div {
    background: #ffffff;
    border: 1.8px solid #d9d9d9;
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 15px;
    color: #222;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);

    flex-direction: column;
    gap: 4px;
}

/* Nhãn */
.order-info b {
    font-size: 15px;
    color: #333;
    font-weight: 700;
}

/* Giá trị */
.order-info span {
    font-size: 15px;
    font-weight: 600;
    color: #0057c2;
}

/* Ngày giao nổi bật */
#ngayGiao {
    color: #d01919 !important;
    font-size: 15px;
    font-weight: 700;
}

</style>