
<?php
require_once __DIR__ . '/layouts/header.php';
require_once __DIR__ . '/layouts/nav.php';
?>
<div class="main-layout-wrapper">
  <?php require_once __DIR__ . '/layouts/sidebar.php'; ?>
  
  <main class="main-content">
    <div class="container">
    
        <h1>Tạo Yêu Cầu Kiểm Tra Chất Lượng</h1>
   

      <div class="main-content-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <!-- Form bên trái -->
        <div class="form-section" style="border: 2px solid #000; border-radius: 8px; padding: 25px; background: #fff;">
          <h2 style="border-bottom: 2px solid #000; padding-bottom: 8px;">Thông Tin Yêu Cầu</h2>
          <form id="qualityCheckForm">
            <div class="form-group">
              <label>Khởi tạo từ <span style="color:red">*</span></label>
              <select id="dataSource" required>
                <option value="plan" selected>Từ Kế hoạch sản xuất</option>
                <option value="manual">Nhập tay</option>
              </select>
            </div>

            <div class="form-group" id="planPicker">
              <label for="planCode">Mã Kế Hoạch <span style="color:red">*</span></label>
              <select id="planCode" required>
                <option value="">-- Chọn kế hoạch --</option>
              </select>
            </div>

            <div class="form-group">
              <label for="productCode">Mã Sản Phẩm <span style="color:red">*</span></label>
              <select id="productCode" required></select>
            </div>

            <div class="form-group">
              <label for="quantity">Số Lượng <span style="color:red">*</span></label>
              <input type="number" id="quantity" min="1" placeholder="Nhập số lượng" required>
            </div>

            <div class="form-group">
              <label for="workshop">Xưởng/Chuyền yêu cầu <span style="color:red">*</span></label>
              <select id="workshop" required></select>
            </div>

            <div class="form-group">
              <label for="requestTime">Thời Gian Yêu Cầu <span style="color:red">*</span></label>
              <input type="datetime-local" id="requestTime" required>
            </div>

            <div class="form-group">
              <label for="notes">Ghi Chú</label>
              <input type="text" id="notes" placeholder="Nhập ghi chú (tùy chọn)">
            </div>

            <div class="button-group" style="display:flex;gap:10px;margin-top:20px;">
              <button type="submit" class="btn" style="flex:1;padding:10px;border:2px solid #000;background:#fff;font-weight:600;cursor:pointer;">Nhập</button>
              <button type="reset" class="btn" style="flex:1;padding:10px;border:2px solid #000;background:#fff;font-weight:600;cursor:pointer;">Xóa</button>
            </div>
          </form>
        </div>

        <!-- Bên phải -->
        <div class="form-section" style="border: 2px solid #000; border-radius: 8px; padding: 25px; background: #fff;">
          <h2 style="border-bottom: 2px solid #000; padding-bottom: 8px;">Thông Tin Hệ Thống</h2>
          <p>Trạng thái QC: <strong>Sẵn sàng tiếp nhận yêu cầu</strong></p>
          <p>Yêu cầu hôm nay: <strong>12 yêu cầu</strong></p>
          <p>Chờ xử lý: <strong>5 yêu cầu</strong></p>
          <p>Thời gian xử lý trung bình: <strong>2–3 giờ</strong></p>
        </div>
      </div>

      <!-- Bảng lịch sử -->
      <div class="history-section" style="border: 2px solid #000; border-radius: 8px; padding: 25px; background: #fff; margin-top:20px;">
        <h2 style="border-bottom: 2px solid #000; padding-bottom: 8px;">Lịch Sử Yêu Cầu</h2>
        <table class="history-table" style="width:100%;border-collapse:collapse;">
          <thead>
            <tr>
              <th style="border:1px solid #000;padding:8px;background:#f2f2f2;">Mã Yêu Cầu</th>
              <th style="border:1px solid #000;padding:8px;background:#f2f2f2;">Mã Sản Phẩm</th>
              <th style="border:1px solid #000;padding:8px;background:#f2f2f2;">Số Lượng</th>
              <th style="border:1px solid #000;padding:8px;background:#f2f2f2;">Thời Gian</th>
              <th style="border:1px solid #000;padding:8px;background:#f2f2f2;">Trạng Thái</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>
<style>
  
<?php include './public/css/phieu-nhap.css'; ?>
</style>
<?php require_once __DIR__ . '/layouts/footer.php'; ?>
