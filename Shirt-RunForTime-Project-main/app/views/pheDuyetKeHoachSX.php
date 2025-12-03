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
            <li class="plan-item" onclick="selectPlan(this, 1)">
              <div class="plan-item-header">
                <span class="plan-item-name">KH-2024-001</span>
                <span class="plan-item-status status-pending">Chờ duyệt</span>
              </div>
              <div class="plan-item-date">Ngày lập: 15/10/2024</div>
            </li>
            <li class="plan-item" onclick="selectPlan(this, 2)">
              <div class="plan-item-header">
                <span class="plan-item-name">KH-2024-002</span>
                <span class="plan-item-status status-pending">Chờ duyệt</span>
              </div>
              <div class="plan-item-date">Ngày lập: 14/10/2024</div>
            </li>
          </ul>
        </div>
      </div>

      <!-- Chi tiết kế hoạch (ẩn ban đầu) -->
      <div class="section" id="plan-detail-section" style="display:none;">
        <div class="section-title">Chi Tiết Kế Hoạch</div>
        <div class="section-content">
          <div class="detail-section">
            <div class="detail-label">Đơn Hàng Sản Xuất</div>
            <div class="detail-value" id="order-code">—</div>
          </div>

          <div class="detail-section">
            <div class="detail-label">Thời Gian Thực Hiện</div>
            <div class="detail-value">
              <span id="start-date">—</span> đến <span id="end-date">—</span>
            </div>
          </div>

          <div class="detail-section">
            <div class="detail-label">Sản Phẩm</div>
            <div class="detail-value" id="product-name">—</div>
          </div>

          <div class="detail-section">
            <div class="detail-label">Số Lượng Sản Phẩm</div>
            <div class="detail-value" id="product-qty">—</div>
          </div>

          <div class="detail-section">
            <div class="detail-label">Xưởng Phân Công</div>
            <div class="detail-value" id="workshop-name">—</div>
          </div>

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

          <div class="detail-section">
            <div class="detail-label">Ghi Chú</div>
            <div class="detail-value" id="plan-note">—</div>
          </div>

          <div class="action-buttons">
            <button class="btn btn-approve" onclick="openApproveModal()">Phê Duyệt</button>
            <button class="btn btn-reject" onclick="openRejectModal()">Từ Chối</button>
          </div>
        </div>
      </div>

      <!-- Lịch sử phê duyệt -->
      <div class="section" style="margin-top:30px;">
        <div class="section-title">Lịch Sử Phê Duyệt</div>
        <div class="section-content">
          <div class="history-item">
            <div class="history-time">15/10/2024 10:30</div>
            <div class="history-action">Phê duyệt - KH-2024-001</div>
            <div class="history-note">Phê duyệt bởi: Giám Đốc Trần Văn B</div>
          </div>
        </div>
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
  </main>
</div>

<script>
const plans = [
  {
    id: 1,
    orderCode: "SO-2024-3456",
    startDate: "2024-10-15",
    endDate: "2024-10-20",
    product: { name: "Áo sơ mi công sở" },
    quantity: 5000,
    workshop: { name: "Xưởng May 1" },
    note: "Sản xuất theo lô, ưu tiên đơn hàng gấp.",
    materials: [
      { code: "NVL-CT01", name: "Vải cotton 120gsm", uom: "m", need: 12000, stock: 15000, note: "Đủ kho" },
      { code: "NVL-CH01", name: "Chỉ may #60", uom: "cuộn", need: 450, stock: 300, note: "Thiếu 150 cuộn" }
    ]
  },
  {
    id: 2,
    orderCode: "SO-2024-7777",
    startDate: "2024-10-18",
    endDate: "2024-10-25",
    product: { name: "Áo thun đồng phục" },
    quantity: 8000,
    workshop: { name: "Xưởng May 2" },
    note: "Sản xuất đợt 2 theo đơn hàng tháng 10.",
    materials: [
      { code: "NVL-CT02", name: "Vải thun lạnh", uom: "m", need: 15000, stock: 12000, note: "Thiếu 3000m" },
      { code: "NVL-CH02", name: "Chỉ polyester", uom: "cuộn", need: 600, stock: 800, note: "Dư kho" }
    ]
  }
];

function fmt(d) {
  const t = new Date(d);
  return `${String(t.getDate()).padStart(2,"0")}/${String(t.getMonth()+1).padStart(2,"0")}/${t.getFullYear()}`;
}

function selectPlan(el, id) {
  document.querySelectorAll(".plan-item").forEach(i => i.classList.remove("active"));
  el.classList.add("active");

  const data = plans.find(p => p.id === id);
  if (!data) return;

  const section = document.getElementById("plan-detail-section");
  section.style.display = "block";

  document.getElementById("order-code").textContent = data.orderCode;
  document.getElementById("start-date").textContent = fmt(data.startDate);
  document.getElementById("end-date").textContent = fmt(data.endDate);
  document.getElementById("product-name").textContent = data.product.name;
  document.getElementById("product-qty").textContent = data.quantity;
  document.getElementById("workshop-name").textContent = data.workshop.name;
  document.getElementById("plan-note").textContent = data.note;

  const tbody = document.querySelector("#materials-table tbody");
  tbody.innerHTML = "";
  let totalNeed = 0, totalStock = 0;

  data.materials.forEach(m => {
    totalNeed += m.need;
    totalStock += m.stock;
    const tr = document.createElement("tr");
    tr.innerHTML = `<td>${m.code}</td><td>${m.name}</td><td>${m.uom}</td><td>${m.need}</td><td>${m.stock}</td><td>${m.note}</td>`;
    tbody.appendChild(tr);
  });

  document.getElementById("total-need").textContent = totalNeed;
  document.getElementById("total-stock").textContent = totalStock;
}

// Modal
function openApproveModal() { document.getElementById("approveModal").classList.add("active"); }
function closeApproveModal() { document.getElementById("approveModal").classList.remove("active"); }
function openRejectModal() { document.getElementById("rejectModal").classList.add("active"); }
function closeRejectModal() { document.getElementById("rejectModal").classList.remove("active"); }
function confirmApprove() { alert("✅ Kế hoạch đã được phê duyệt!"); closeApproveModal(); }
function confirmReject() { alert("❌ Kế hoạch đã bị từ chối!"); closeRejectModal(); }
</script>

<style>
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
