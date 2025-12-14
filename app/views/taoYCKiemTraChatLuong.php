<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/layouts/nav.php';
?>
<div class="main-layout-wrapper">
  <?php require_once __DIR__ . '/layouts/sidebar.php'; ?>

  <main class="main-content" style="padding: 30px;">
    <div class="container">
      <div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
        
        <h1 style="font-size:26px; color:#1d3557; font-weight:700; margin:0;">
          Tạo Yêu Cầu Kiểm Tra Chất Lượng
        </h1>
      </div>

      <!-- Form chọn kế hoạch -->
      <form action="index.php?page=tao-yeu-cau-kiem-tra-chat-luong-create" method="POST"
            style="display:flex; align-items:center; gap:15px; margin-bottom:25px; flex-wrap:wrap;">
        <label for="planCode" style="font-weight:600;">Chọn kế hoạch sản xuất:</label>
        <select name="planCode" id="planCode" required onchange="loadProductInfo()"
                style="padding:8px 12px; border:1px solid #ccc; border-radius:8px; font-size:15px; min-width:300px;">
          <option value="">-- Chọn kế hoạch --</option>
          <?php foreach ($plans as $p): ?>
            <option value="<?= $p['maKHSX'] ?>" 
                    data-product='<?= json_encode($p) ?>'>
              <?= htmlspecialchars($p['tenKHSX']) ?> - <?= htmlspecialchars($p['tenSanPham']) ?>
            </option>
          <?php endforeach; ?>
        </select>

        <button type="submit" id="btnCreate" disabled
                style="background:#1d3557; color:white; padding:10px 18px; border:none; border-radius:8px;
                       font-weight:600; cursor:pointer; transition:0.3s; opacity:0.5;">
          Tạo phiếu kiểm tra chất lượng
        </button>
      </form>

      <!-- Bảng thông tin sản phẩm cần kiểm tra -->
      <section style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.1); padding:20px;">
        <h2 style="font-size:20px; color:#1d3557; font-weight:600; margin-bottom:15px;">
          Thông Tin Sản Phẩm Cần Kiểm Tra Chất Lượng
        </h2>
        <div id="productInfo" style="padding:15px; background:#f8f9fa; border-radius:8px; min-height:100px;">
          <p style="color:#666; text-align:center;">Vui lòng chọn kế hoạch sản xuất để xem thông tin...</p>
        </div>
      </section>
    </div>
  </main>
</div>

<!-- ========== STYLE ========== -->
<style>
.info-row {
  display: flex;
  padding: 10px 0;
  border-bottom: 1px solid #e0e0e0;
}
.info-label {
  font-weight: 600;
  color: #1d3557;
  width: 200px;
}
.info-value {
  color: #333;
  flex: 1;
}
</style>

<!-- ========== SCRIPT ========== -->
<script>
function loadProductInfo() {
  const select = document.getElementById('planCode');
  const selectedOption = select.options[select.selectedIndex];
  const btnCreate = document.getElementById('btnCreate');
  const productInfo = document.getElementById('productInfo');
  if (!select.value) {
    productInfo.innerHTML = '<p style="color:#666; text-align:center;">Vui lòng chọn kế hoạch sản xuất để xem thông tin...</p>';
    btnCreate.disabled = true;
    btnCreate.style.opacity = '0.5';
    btnCreate.style.cursor = 'not-allowed';
    return;
  }

  const data = JSON.parse(selectedOption.getAttribute('data-product'));
  
  productInfo.innerHTML = `
    <div class="info-row">
      <div class="info-label">Tên kế hoạch:</div>
      <div class="info-value">${data.tenKHSX}</div>
    </div>
    <div class="info-row">
      <div class="info-label">Sản phẩm:</div>
      <div class="info-value"><strong>${data.tenSanPham}</strong></div>
    </div>
    <div class="info-row">
      <div class="info-label">Số lượng cần kiểm tra:</div>
      <div class="info-value"><strong style="color:#d00; font-size:18px;">${data.soLuongSanXuat}</strong> cái</div>
    </div>
    <div class="info-row">
      <div class="info-label">Thời gian:</div>
      <div class="info-value">${data.thoiGianBatDau} → ${data.thoiGianKetThuc}</div>
    </div>
  `;
  
  btnCreate.disabled = false;
  btnCreate.style.opacity = '1';
  btnCreate.style.cursor = 'pointer';
}
</script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>