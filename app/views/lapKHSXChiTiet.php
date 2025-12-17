<?php
require_once 'layouts/header.php';
require_once 'layouts/nav.php';

/* ====== PHẦN SỬA: LOGIC LỌC NVL CHUẨN XÁC ====== */
$dsVai = [];      
$dsPhuLieu = []; 

if (isset($danhSachNVL) && is_array($danhSachNVL)) {
    foreach ($danhSachNVL as $item) {
        // BƯỚC 1: Chuẩn hóa dữ liệu từ DB (Cắt khoảng trắng thừa, chuyển về chữ thường)
        // Dùng mb_strtolower với UTF-8 để xử lý tiếng Việt chuẩn
        $loaiNVL_Chuan = mb_strtolower(trim($item['loaiNVL'] ?? ''), 'UTF-8');
        
        // BƯỚC 2: Kiểm tra
        // Điều kiện 1: Cột loại là "vải" (đã chuyển thường)
        // Điều kiện 2: Hoặc tên sản phẩm có chứa chữ "vải" (Dự phòng trường hợp cột loại bị nhập sai)
        $tenNVL_Chuan = mb_strtolower(trim($item['tenNVL'] ?? ''), 'UTF-8');
        
        if ($loaiNVL_Chuan === 'vải' || strpos($tenNVL_Chuan, 'vải') !== false) {
            $dsVai[] = $item;
        } else {
            // Tất cả những cái không phải vải -> Vào Phụ liệu
            $dsPhuLieu[] = $item;
        }
    }
}
?>

<div class="main-layout-wrapper">
    <?php require_once 'layouts/sidebar.php'; ?>

    <main class="main-content">
        <h2 class="page-title">📋 Lập Kế hoạch Sản xuất - Đơn hàng:
            <?= htmlspecialchars($donHang['tenDonHang'] ?? 'Không rõ') ?>
        </h2>

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

            <div class="xuong-block cut">
                <h3 class="xuong-heading">XƯỞNG CẮT</h3>
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
                        <label class="field-label">Nguyên vật liệu (Chỉ chọn Vải)</label>
                        <div class="nvl-row">
                            <select name="xuong_cat[nvl_id][]" required>
                                <option value="" data-dvt="">-- Chọn loại Vải --</option>
                                <?php foreach ($dsVai as $nvl): ?>
                                    <option value="<?= $nvl['maNVL'] ?>" data-dvt="<?= htmlspecialchars($nvl['donViTinh'] ?? '') ?>">
                                        <?= htmlspecialchars($nvl['tenNVL']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <div class="nvl-inputs">
                                <div class="input-wrapper">
                                    <label class="small-label">Định mức / 1 SP</label>
                                    <div class="input-with-unit">
                                        <input type="number" name="xuong_cat[nvl_dinhMuc][]" min="0" step="0.01" value="1" required>
                                        <span class="unit-display">--</span>
                                    </div>
                                </div>

                                <div class="input-wrapper">
                                    <label class="small-label">Tổng NVL cần</label>
                                    <div class="input-with-unit">
                                        <input type="number" name="xuong_cat[nvl_soLuong][]" min="0" value="0" readonly>
                                        <span class="unit-display">--</span>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn-remove-nvl" title="Xóa NVL">&times;</button>
                        </div>

                        <button type="button" class="btn-add-nvl" data-target="xuong-cat-container">+ Thêm Vải</button>
                        <div class="nvl-dates" aria-hidden="true">
                            <small style="font-size: 13px;" id="cat-note-start"></small>
                            <small style="font-size: 13px;" id="cat-note-end"></small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xuong-block sew">
                <h3 class="xuong-heading">XƯỞNG MAY</h3>
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
                        <label class="field-label">Nguyên vật liệu (Phụ liệu)</label>
                        <div class="nvl-row">
                            <select name="xuong_may[nvl_id][]" required>
                                <option value="" data-dvt="">-- Chọn Phụ liệu --</option>
                                <?php foreach ($dsPhuLieu as $nvl): ?>
                                    <option value="<?= $nvl['maNVL'] ?>" data-dvt="<?= htmlspecialchars($nvl['donViTinh'] ?? '') ?>">
                                        <?= htmlspecialchars($nvl['tenNVL']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <div class="nvl-inputs">
                                <div class="input-wrapper">
                                    <label class="small-label">Định mức / 1 SP</label>
                                    <div class="input-with-unit">
                                        <input type="number" name="xuong_may[nvl_dinhMuc][]" min="0" value="1" step="0.01" required>
                                        <span class="unit-display">--</span>
                                    </div>
                                </div>

                                <div class="input-wrapper">
                                    <label class="small-label">Tổng NVL cần</label>
                                    <div class="input-with-unit">
                                        <input type="number" name="xuong_may[nvl_soLuong][]" min="0" value="0" readonly>
                                        <span class="unit-display">--</span>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn-remove-nvl" title="Xóa NVL">&times;</button>
                        </div>

                        <button type="button" class="btn-add-nvl" data-target="xuong-may-container">+ Thêm Phụ liệu</button>
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
    /* ====== CẤU HÌNH & HELPER DATE (GIỮ NGUYÊN) ====== */
    const SO_LUONG = parseInt(document.getElementById('soLuongSanPham').textContent.replace(/\./g, '')) || 0;
    const elNgayGiao = document.getElementById('ngayGiao');
    const NGAY_GIAO = parseDateVN(elNgayGiao.textContent.trim());

    function formatVN(dateStr) {
        if (!dateStr) return "";
        const d = new Date(dateStr);
        return [
            String(d.getDate()).padStart(2, '0'),
            String(d.getMonth() + 1).padStart(2, '0'),
            d.getFullYear()
        ].join('/');
    }

    function parseDateVN(dateStr) {
        if (!dateStr) return null;
        const [d, m, y] = dateStr.split('/');
        return new Date(y, m - 1, d);
    }

    function parseDateISO(dateStr) {
        if (!dateStr) return null;
        const [y, m, d] = dateStr.split('-').map(Number);
        return new Date(y, m - 1, d);
    }

    function formatISO(dateObj) {
        if (!dateObj) return '';
        const y = dateObj.getFullYear();
        const m = String(dateObj.getMonth() + 1).padStart(2, '0');
        const d = String(dateObj.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    function addDays(dateObj, delta) {
        if (!dateObj) return null;
        const d = new Date(dateObj.getFullYear(), dateObj.getMonth(), dateObj.getDate());
        d.setDate(d.getDate() + delta);
        return d;
    }

    function diffDaysInclusive(start, end) {
        if (!start || !end) return 0;
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
        // --- 1. NGÀY TỔNG ---
        const planStart = parseDateISO(inputNgayKHSX.value) || new Date();
        let mayEndTarget = parseDateISO(mayEndInput.value);
        const limitMayEnd = addDays(NGAY_GIAO, -2); 

        if (!mayEndTarget) {
            mayEndTarget = limitMayEnd;
            mayEndInput.value = formatISO(mayEndTarget);
        } else if (mayEndTarget > addDays(NGAY_GIAO, -1)) {
            alert("⚠️ Ngày kết thúc may phải trước ngày giao hàng ít nhất 1-2 ngày để đóng gói!");
            mayEndTarget = limitMayEnd;
            mayEndInput.value = formatISO(mayEndTarget);
        }
        inputNgayKetThuc.value = formatISO(NGAY_GIAO);

        // --- 2. XƯỞNG CẮT ---
        let catStart = parseDateISO(catStartInput.value);
        if (!catStart || catStart < planStart) {
            catStart = addDays(planStart, 1);
            catStartInput.value = formatISO(catStart);
        }

        let catKpi = parseInt(catKpiInput.value) || 0;
        let catDays = 0;
        let catEnd = null;
        const limitCatEnd = addDays(mayEndTarget, -1);

        if (catKpi > 0) {
            catDays = Math.ceil(SO_LUONG / catKpi);
            catEnd = addDays(catStart, catDays - 1);
            if (catEnd > limitCatEnd) {
                catEnd = limitCatEnd;
                catEndInput.value = formatISO(catEnd);
                const realDays = diffDaysInclusive(catStart, catEnd);
                const requiredKpi = Math.ceil(SO_LUONG / Math.max(1, realDays));
                catKpiWarn.style.display = 'inline';
                catKpiWarn.textContent = `KPI quá thấp! Cần cắt tối thiểu ${requiredKpi} SP/ngày`;
                catKpiMinEl.textContent = requiredKpi;
            } else {
                catEndInput.value = formatISO(catEnd);
                catKpiWarn.style.display = 'none';
                catKpiMinEl.textContent = Math.ceil(SO_LUONG / Math.max(1, catDays));
            }
        } else {
            if (!parseDateISO(catEndInput.value)) {
                catEnd = limitCatEnd;
                catEndInput.value = formatISO(catEnd);
            } else {
                catEnd = parseDateISO(catEndInput.value);
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

        // --- 3. XƯỞNG MAY ---
        let mayStart = parseDateISO(mayStartInput.value);
        const minMayStart = addDays(parseDateISO(catStartInput.value), 1);

        if (!mayStart || mayStart < minMayStart) {
            mayStart = minMayStart;
            mayStartInput.value = formatISO(mayStart);
        }

        let mayKpi = parseInt(mayKpiInput.value) || 0;
        let mayDays = 0;

        if (mayKpi > 0) {
            mayDays = Math.ceil(SO_LUONG / mayKpi);
            let calculatedMayEnd = addDays(mayStart, mayDays - 1);
            if (calculatedMayEnd > mayEndTarget) {
                const realDays = diffDaysInclusive(mayStart, mayEndTarget);
                const requiredKpi = Math.ceil(SO_LUONG / Math.max(1, realDays));
                mayKpiWarn.style.display = 'inline';
                mayKpiWarn.textContent = `Không kịp giao! Phải may ${requiredKpi} SP/ngày`;
                mayKpiMinEl.textContent = requiredKpi;
            } else {
                mayEndInput.value = formatISO(calculatedMayEnd);
                mayKpiWarn.style.display = 'none';
                mayKpiMinEl.textContent = Math.ceil(SO_LUONG / Math.max(1, mayDays));
            }
        } else {
            const realDays = diffDaysInclusive(mayStart, mayEndTarget);
            const suggestedKpi = Math.ceil(SO_LUONG / Math.max(1, realDays));
            mayKpiMinEl.textContent = suggestedKpi;
            mayKpiWarn.style.display = 'none';
        }

        // --- 4. CẬP NHẬT NVL (TÍNH TỔNG) ---
        document.querySelectorAll('.nvl-row').forEach(row => {
            const dinhMuc = parseFloat(row.querySelector('input[name$="[nvl_dinhMuc][]"]').value) || 0;
            const out = row.querySelector('input[name$="[nvl_soLuong][]"]');
            if (out) out.value = (dinhMuc * SO_LUONG).toFixed(2).replace(/\.00$/, '');
        });

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

    /* ====== HELPER ĐƠN VỊ TÍNH (MỚI) ====== */
    function updateUnitLabel(selectElement) {
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        const unit = selectedOption.getAttribute('data-dvt') || '--';
        
        const row = selectElement.closest('.nvl-row');
        if (!row) return;

        const unitSpans = row.querySelectorAll('.unit-display');
        unitSpans.forEach(span => {
            span.textContent = unit;
        });
    }

    /* ====== EVENT LISTENERS ====== */
    inputNgayKHSX.addEventListener('change', updatePlan);
    catStartInput.addEventListener('change', updatePlan);
    catEndInput.addEventListener('change', updatePlan);
    mayStartInput.addEventListener('change', updatePlan);

    mayEndInput.addEventListener('change', function () {
        const d = parseDateISO(this.value);
        if (d > addDays(NGAY_GIAO, -1)) {
            alert('Ngày kết thúc may quá sát ngày giao hàng!');
            this.value = formatISO(addDays(NGAY_GIAO, -2));
        }
        updatePlan();
    });

    catKpiInput.addEventListener('input', updatePlan);
    mayKpiInput.addEventListener('input', updatePlan);

    document.addEventListener('input', function (e) {
        if (e.target && e.target.matches('input[name$="[nvl_dinhMuc][]"]')) {
            updatePlan();
        }
    });

    // MỚI: Sự kiện change cho select NVL để đổi ĐVT
    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('select[name$="[nvl_id][]"]')) {
            updateUnitLabel(e.target);
        }
    });

    // Logic Add NVL (Đã cập nhật reset ĐVT và Select)
    const addBtns = document.querySelectorAll('.btn-add-nvl');
    addBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const container = document.getElementById(this.dataset.target);
            const row = container.querySelector('.nvl-row');
            const clone = row.cloneNode(true);
            const select = clone.querySelector('select');
            if (select) select.value = '';
            
            // Reset ĐVT cho dòng mới clone
            clone.querySelectorAll('.unit-display').forEach(sp => sp.textContent = '--');

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

    // Chạy lần đầu
    updatePlan();
</script>

<style>
    /* CSS Cũ giữ nguyên */
    body { font-family: "Segoe UI", system-ui, -apple-system, Arial; background: #f8f9fa; color: #222; }
    .main-content { padding: 20px; }
    .page-title { text-align: center; color: #007bff; margin-bottom: 18px; font-size: 22px; font-weight: 600; background: linear-gradient(90deg, #007bff, #005fcc); -webkit-background-clip: text; color: transparent;}
    .order-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 16px; margin-bottom: 20px; }
    .order-info div { background: #ffffff; border: 1.8px solid #d9d9d9; border-radius: 8px; padding: 12px 14px; font-size: 15px; color: #222; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    .order-info b { font-size: 15px; color: #333; font-weight: 700; }
    .order-info span { font-size: 15px; font-weight: 600; color: #0057c2; }
    #ngayGiao { color: #d01919 !important; font-size: 15px; font-weight: 700; }
    .plan-row { display: flex; gap: 18px; margin-bottom: 16px; flex-wrap: wrap; }
    .plan-col { flex: 1; min-width: 200px; display: flex; flex-direction: column; }
    .field-label { font-weight: 600; margin-bottom: 6px; font-size: 15px; color: #333; }
    .field-note { font-size: 13px; color: #666; margin-top: 6px; }
    .row { display: flex; gap: 12px; align-items: center; margin-bottom: 10px; flex-wrap: wrap; }
    .col { flex: 1; min-width: 180px; display: flex; flex-direction: column; }
    input[type="date"], input[type="number"], select { padding: 8px 10px; border-radius: 6px; border: 1.5px solid #c6d4e1; height: 40px; font-size: 14px; background: white; transition: 0.2s; }
    input:focus, select:focus { border-color: #1a73e8; box-shadow: 0 0 3px rgba(26, 115, 232, 0.5); outline: none; }
    .xuong-block { margin-bottom: 18px; border-radius: 8px; padding: 14px; background: #fff; box-shadow: 0 1px 8px rgba(20, 20, 20, 0.04); border: 1.5px solid #dbe5f3; }
    .xuong-block.cut { border-left: 4px solid #1565c0; }
    .xuong-block.sew { border-left: 4px solid #ef6c00; }
    .xuong-heading { margin: 0 0 8px 0; font-size: 16px; color: #333; font-weight: 700; }
    .xuong-block.cut .xuong-heading { color: #0a58ca; }
    .xuong-block.sew .xuong-heading { color: #d35400; }
    .nvl-section { display: flex; flex-direction: column; gap: 12px; margin-top: 10px; }
    .nvl-row { display: flex; gap: 10px; padding: 10px; background: #f5f8ff; border-radius: 6px; border: 1px solid #d4e0f2; flex-wrap: wrap; align-items: flex-end; }
    .nvl-row select { min-width: 180px; flex: 1; }
    .nvl-dates { margin-top: 4px; display: block; font-size: 12px; color: #6c757d; order: 100; }
    .kpi-note { display: flex; gap: 12px; align-items: center; margin-bottom: 8px; font-size: 13px; color: #444; }
    .kpi-note b { color: #0b5ed7; }
    .kpi-warning { font-size: 13px; margin-left: 8px; font-weight: 600; color: #d9534f !important; }
    .btn-add-nvl { background: linear-gradient(135deg, #28a745, #1e7e34); color: #fff; font-weight: 600; padding: 7px 12px; border: none; border-radius: 6px; cursor: pointer; align-self: flex-start; margin-top: 0; order: 99; }
    .btn-add-nvl:hover { background: linear-gradient(135deg, #24963f, #176b2b); }
    .btn-remove-nvl { background: #dc3545; width: 34px; height: 34px; border-radius: 6px; border: none; color: white; font-size: 16px; cursor: pointer; font-weight: bold; display: flex; justify-content: center; align-items: center; }
    .btn-remove-nvl:hover { background: #b02a37; }
    .btn-submit { background: linear-gradient(135deg, #0069d9, #004eac); border: none; padding: 12px; color: white; width: 100%; border-radius: 7px; margin-top: 10px; font-size: 15px; font-weight: 600; cursor: pointer; }
    .btn-submit:hover { background: linear-gradient(135deg, #005fcc, #003f91); }
    input[readonly] { background: #f3f4f6; cursor: not-allowed; }
    .small-label { display: block; font-size: 13px; color: #333; margin-bottom: 4px; font-weight: 700; }

    /* ====== CSS MỚI CHO ĐƠN VỊ TÍNH ====== */
    .nvl-inputs {
        display: flex;
        gap: 15px; 
        flex: 2; 
        min-width: 260px;
    }
    .input-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .input-with-unit {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-with-unit input {
        width: 100%;
        padding-right: 45px; /* Chừa chỗ cho ĐVT */
        height: 38px;
    }
    .unit-display {
        position: absolute;
        right: 10px;
        font-size: 12px;
        color: #666;
        background: #f0f0f0;
        padding: 2px 6px;
        border-radius: 4px;
        font-weight: 600;
        pointer-events: none;
        z-index: 2;
    }

    @media (max-width: 768px) {
        .nvl-row { flex-direction: column; align-items: stretch; }
        .nvl-inputs { flex-direction: column; gap: 10px; }
        .unit-display { top: 50%; transform: translateY(-50%); }
    }
</style>