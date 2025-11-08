<?php require_once 'app/views/layouts/header.php'; ?>
<?php require_once 'app/views/layouts/nav.php'; ?>

<div class="main-layout-wrapper">
  <?php require_once 'app/views/layouts/sidebar.php'; ?>

  <main class="main-content">
    <div class="content">

      <!-- Kế hoạch chờ duyệt -->
      <div class="section">
        <div class="section-title">Kế Hoạch Chờ Phê Duyệt</div>
        <div class="section-content">
          <ul class="plan-list">
            <?php if (!empty($plans)): ?>
              <?php foreach ($plans as $p): ?>
                <li class="plan-item" onclick="selectPlan(this, <?= $p['maKHSX'] ?>)">
                  <div class="plan-item-header">
                    <span class="plan-item-name"><?= htmlspecialchars($p['tenKHSX']) ?></span>
                    <span class="plan-item-status status-pending"><?= htmlspecialchars($p['trangThai']) ?></span>
                  </div>
                  <div class="plan-item-date">
                    Ngày bắt đầu: <?= htmlspecialchars($p['thoiGianBatDau']) ?> –
                    Ngày kết thúc: <?= htmlspecialchars($p['thoiGianKetThuc']) ?>
                  </div>
                </li>
              <?php endforeach; ?>
            <?php else: ?>
              <p style="color:#777;">Không có kế hoạch nào đang chờ duyệt.</p>
            <?php endif; ?>
          </ul>
        </div>
      </div>

      <!-- Chi tiết kế hoạch -->
      <div class="section" id="plan-detail-section" style="display:none;">
        <div class="section-title">Chi Tiết Kế Hoạch</div>
        <div class="section-content">

          <div class="detail-section"><div class="detail-label">Đơn Hàng Sản Xuất</div><div class="detail-value" id="order-code">—</div></div>
          <div class="detail-section"><div class="detail-label">Thời Gian Thực Hiện</div><div class="detail-value"><span id="start-date">—</span> đến <span id="end-date">—</span></div></div>
          <div class="detail-section"><div class="detail-label">Sản Phẩm</div><div class="detail-value" id="product-name">—</div></div>
          <div class="detail-section"><div class="detail-label">Số Lượng Sản Phẩm</div><div class="detail-value" id="product-qty">—</div></div>
          <div class="detail-section"><div class="detail-label">Xưởng Phân Công</div><div class="detail-value" id="workshop-name">—</div></div>

          <div class="detail-section">
            <div class="detail-label">Nguyên Vật Liệu &amp; Số Lượng</div>
            <table class="detail-table" id="materials-table">
              <thead>
                <tr>
                  <th>Mã NVL</th>
                  <th>Tên NVL</th>
                  <th>ĐVT</th>
                  <th>SL cần</th>
                  <th>Tồn kho</th>
                  <th>Ghi chú</th>
                </tr>
              </thead>
              <tbody></tbody>
              <tfoot>
                <tr>
                  <th colspan="3" style="text-align:right;">TỔNG SL CẦN</th>
                  <th id="total-need">0</th>
                  <th id="total-stock">0</th>
                  <th></th>
                </tr>
              </tfoot>
            </table>
          </div>

          <div class="detail-section"><div class="detail-label">Ghi Chú</div><div class="detail-value" id="plan-note">—</div></div>

          <div class="action-buttons">
            <button class="btn btn-approve" onclick="openApproveModal()">Phê Duyệt</button>
            <button class="btn btn-reject" onclick="openRejectModal()">Từ Chối</button>
          </div>
        </div>
      </div>

      <!-- Lịch sử phê duyệt -->
      <div class="section" id="approval-history-section" style="display:none;">
        <div class="section-title">📜 Lịch Sử Phê Duyệt</div>
        <div class="section-content">
          <table class="detail-table" id="history-table">
            <thead>
              <tr>
                <th>Hành động</th>
                <th>Ghi chú</th>
                <th>Người thực hiện</th>
                <th>Thời gian</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>

      <!-- Modal Phê duyệt -->
      <div class="modal" id="approveModal">
        <div class="modal-content">
          <div class="modal-title">Xác Nhận Phê Duyệt</div>
          <p>Bạn có chắc chắn muốn phê duyệt kế hoạch này?</p>
          <div class="form-group">
            <label class="form-label">Ghi chú (tùy chọn)</label>
            <textarea class="form-control" placeholder="Nhập ghi chú..."></textarea>
          </div>
          <div class="modal-buttons">
            <button class="btn-cancel" onclick="closeApproveModal()">Hủy</button>
            <button class="btn-confirm" onclick="confirmApprove()">Phê Duyệt</button>
          </div>
        </div>
      </div>

      <!-- Modal Từ chối -->
      <div class="modal" id="rejectModal">
        <div class="modal-content">
          <div class="modal-title">Từ Chối Kế Hoạch</div>
          <label class="form-label">Lý Do Từ Chối</label>
          <textarea class="form-control" placeholder="Nhập lý do từ chối..."></textarea>
          <div class="modal-buttons">
            <button class="btn-cancel" onclick="closeRejectModal()">Hủy</button>
            <button class="btn-confirm" onclick="confirmReject()">Xác Nhận</button>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
const plans = <?= json_encode($plans, JSON_UNESCAPED_UNICODE) ?>;

// 🔹 Khi chọn kế hoạch
async function selectPlan(el, maKHSX) {
  document.querySelectorAll(".plan-item").forEach(i => i.classList.remove("active"));
  el.classList.add("active");

  const res = await fetch(`index.php?page=ajax-get-plan-detail&maKHSX=${maKHSX}`);
  const data = await res.json();

  const section = document.getElementById("plan-detail-section");
  section.style.display = "block";

  document.getElementById("order-code").textContent = data.maDonHang || "—";
  document.getElementById("start-date").textContent = data.ngayBatDau || "—";
  document.getElementById("end-date").textContent = data.ngayKetThuc || "—";
  document.getElementById("product-name").textContent = data.tenSanPham || "—";
  document.getElementById("product-qty").textContent = data.soLuongSanXuat || "—";
  document.getElementById("workshop-name").textContent = data.tenXuong || "—";
  document.getElementById("plan-note").textContent = data.ghiChu ?? '';

  // Nguyên vật liệu
  const tbody = document.querySelector("#materials-table tbody");
  tbody.innerHTML = "";
  let totalNeed = 0, totalStock = 0;

  data.nguyenVatLieu.forEach(m => {
    totalNeed += parseInt(m.soLuongCan);
    totalStock += parseInt(m.soLuongTonKho);
    tbody.innerHTML += `
      <tr>
        <td>${m.maNVL}</td>
        <td>${m.tenNVL}</td>
        <td>${m.donViTinh}</td>
        <td>${m.soLuongCan}</td>
        <td>${m.soLuongTonKho}</td>
        <td>${m.ghiChu}</td>
      </tr>`;
  });
  document.getElementById("total-need").textContent = totalNeed;
  document.getElementById("total-stock").textContent = totalStock;

  // ✅ Lấy lịch sử phê duyệt
  const historyRes = await fetch(`index.php?page=ajax-get-approval-history&maKHSX=${maKHSX}`);
  const history = await historyRes.json();
  const tbodyHistory = document.querySelector("#history-table tbody");
  tbodyHistory.innerHTML = "";

  if (history.length > 0) {
    history.forEach(h => {
      const icon = h.hanhDong.includes('Từ chối') ? '❌' : '✅';
      tbodyHistory.innerHTML += `
        <tr>
          <td>${icon} ${h.hanhDong}</td>
          <td>${h.ghiChu || ''}</td>
          <td>${h.nguoiThucHien}</td>
          <td>${h.thoiGian}</td>
        </tr>`;
    });
  } else {
    tbodyHistory.innerHTML = `<tr><td colspan="4" style="text-align:center;">Chưa có lịch sử phê duyệt</td></tr>`;
  }
  document.getElementById("approval-history-section").style.display = "block";
}

// 🔹 Modal logic
function openApproveModal() { document.getElementById("approveModal").classList.add("active"); }
function closeApproveModal() { document.getElementById("approveModal").classList.remove("active"); }
function openRejectModal() { document.getElementById("rejectModal").classList.add("active"); }
function closeRejectModal() { document.getElementById("rejectModal").classList.remove("active"); }

// 🔹 Xử lý duyệt kế hoạch
async function confirmApprove() {
  const activePlan = document.querySelector(".plan-item.active");
  if (!activePlan) return alert("⚠️ Vui lòng chọn một kế hoạch!");
  const maKHSX = activePlan.getAttribute("onclick").match(/\d+/)[0];
  const ghiChu = document.querySelector("#approveModal textarea").value;

  const res = await fetch("index.php?page=phe-duyet-ke-hoach-sx-process", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `maKeHoach=${maKHSX}&trangThai=Đã duyệt&ghiChu=${encodeURIComponent(ghiChu)}`
  });
  const result = await res.json();
  alert(result.success ? "✅ Kế hoạch đã được phê duyệt!" : "❌ " + result.message);
  window.location.reload();
}

// 🔹 Xử lý từ chối
async function confirmReject() {
  const activePlan = document.querySelector(".plan-item.active");
  if (!activePlan) return alert("⚠️ Vui lòng chọn một kế hoạch!");
  const maKHSX = activePlan.getAttribute("onclick").match(/\d+/)[0];
  const ghiChu = document.querySelector("#rejectModal textarea").value;

  const res = await fetch("index.php?page=phe-duyet-ke-hoach-sx-process", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `maKeHoach=${maKHSX}&trangThai=Từ chối&ghiChu=${encodeURIComponent(ghiChu)}`
  });
  if (res.ok) alert("❌ Kế hoạch đã bị từ chối!"); else alert("⚠️ Có lỗi khi từ chối!");
  window.location.reload();
}
</script>


<style>
  .modal-buttons {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 15px;
}

.modal-buttons .btn-cancel,
.modal-buttons .btn-confirm {
  flex: 0; /* ❌ Không giãn */
  min-width: 100px;
  padding: 8px 14px;
  font-weight: 600;
  border-radius: 4px;
  border: none;
}

.btn-cancel {
  background: #dc3545;
  color: #fff;
  transition: 0.2s;
}
.btn-cancel:hover {
  background: #b02a37;
}

.btn-confirm {
  background: #3b7ddd;
  color: #fff;
  transition: 0.2s;
}
.btn-confirm:hover {
  background: #295fc5;
}

.main-content { margin-top: 0; padding-top: 10px; width: 100%; }
.content { max-width: 1000px; margin: 0 auto; padding: 20px 30px; background: #f8fafc; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); }
.section { background: #fff; border: 1px solid #dce2ec; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.section-title { background: #142850; color: #fff; font-weight: 600; padding: 10px 15px; border-radius: 8px 8px 0 0; }
.section-content { background: #fff; padding: 18px; border-radius: 0 0 8px 8px; }
.plan-item { background: #fafafa; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 10px; padding: 10px 15px; cursor: pointer; transition: 0.3s; }
.plan-item:hover { background: #f1f6ff; }
.plan-item.active { border-color: #3b7ddd; background: #eaf2ff; }
.plan-item-status { border: 1px solid #000; padding: 2px 10px; border-radius: 15px; background: #fffbe7; font-size: 12px; }
.detail-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
.detail-table th, .detail-table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
.btn { flex: 1; padding: 10px; border-radius: 4px; font-weight: 600; cursor: pointer; }
.btn-approve { background: #3b7ddd; color: #fff; }
.btn-reject { background: #ff3b3b; color: #fff; }
.modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.45); align-items: center; justify-content: center; z-index: 9999; }
.modal.active { display: flex; }
.modal-content { background: #fff; border-radius: 6px; padding: 25px; max-width: 480px; width: 90%; }
#plan-detail-section { animation: fadeIn 0.4s ease-in-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<?php require_once 'app/views/layouts/footer.php'; ?>
