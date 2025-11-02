<?php
require_once './app/views/layouts/header.php';
require_once './app/views/layouts/nav.php';
?>
<div class="main-layout-wrapper">
  <?php require_once './app/views/layouts/sidebar.php'; ?>

  <main class="main-content">
    <div class="container">

      <!-- Tabs -->
    <div class="page-header">
  <h2>TẠO YÊU CẦU NHẬP KHO NGUYÊN VẬT LIỆU</h2>
      <div class="tabs">
        <button class="tab active" onclick="switchTab('list', event)">Danh sách phiếu</button>
        <button class="tab" onclick="switchTab('create', event)">Lập phiếu mới</button>
      </div>
        </div>

      <!-- Section: Danh sách phiếu -->
      <section id="list" class="section active">
        <div class="card">
          <div class="card-header">
            <h2>Danh sách phiếu yêu cầu nhập kho</h2>
            <!-- <button class="btn-primary" onclick="switchTab('create', event)">➕ Lập phiếu mới</button> -->
          </div>

          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Mã phiếu</th>
                  <th>Ngày lập</th>
                  <th>Số lượng NVL</th>
                  <th>Trạng thái</th>
                  <th>Hành động</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($danhSachPhieu)): ?>
                  <?php foreach ($danhSachPhieu as $phieu): ?>
                    <tr>
                      <td><?= htmlspecialchars($phieu['maYCNK']) ?></td>
                      <td><?= htmlspecialchars($phieu['ngayLap']) ?></td>
                      <td><?= htmlspecialchars($phieu['soLuongNVL']) ?></td>
                      <td>
                        <?php if ($phieu['trangThai'] === 'Đã duyệt'): ?>
                          <span class="status-badge status-approved">✓ Đã duyệt</span>
                        <?php else: ?>
                          <span class="status-badge status-pending">⏳ Chờ duyệt</span>
                        <?php endif; ?>
                      </td>
                      <td><button class="btn-primary btn-small">Xem</button></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="5" style="text-align:center;">Không có phiếu nào</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Section: Lập phiếu -->
      <section id="create" class="section">
        <div class="card">
          <div class="card-header">
            <h2>Lập phiếu yêu cầu nhập kho nguyên vật liệu</h2>
          </div>

          <form method="POST" action="index.php?page=luu-phieu-nhap-kho">
            <!-- <h3 style="margin-bottom: 1.5rem; color: var(--primary);">Thông tin cơ bản</h3> -->

            <div class="form-row">
              <div class="form-group">
                <label for="ngayLap" class="required">Ngày lập phiếu</label>
                <input type="date" id="ngayLap" name="ngayLap" required>
              </div>

              <div class="form-group">
                <label for="nhaCungCap" class="required">Nhà cung cấp</label>
                <select id="nhaCungCap" name="nhaCungCap" required>
                  <option value="">-- Chọn nhà cung cấp --</option>
                  <option value="NCC001">Công ty Vải Việt Nam</option>
                  <option value="NCC002">Công ty Sợi Quốc Tế</option>
                  <option value="NCC003">Công ty Phụ liệu May Mặc</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label for="ghiChu">Ghi chú</label>
              <textarea id="ghiChu" name="ghiChu" placeholder="Nhập ghi chú nếu có..."></textarea>
            </div>

            <!-- <h3 style="margin-top:2rem; margin-bottom:1rem; color: var(--primary);">Chọn nguyên vật liệu từ kế hoạch sản xuất</h3> -->
            <div class="form-group">
              <label for="maKHSX" class="required">Kế hoạch sản xuất</label>
              <select id="maKHSX" name="maKHSX" required>
                <option value="">-- Chọn kế hoạch --</option>
                <?php if (!empty($danhSachKHSX)): ?>
                  <?php foreach ($danhSachKHSX as $khsx): ?>
                    <option value="<?= htmlspecialchars($khsx['maKHSX']) ?>">
                      <?= htmlspecialchars($khsx['tenKHSX']) ?> (<?= $khsx['thoiGianBatDau'] ?> → <?= $khsx['thoiGianKetThuc'] ?>)
                    </option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
            </div>

            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Mã NVL</th>
                    <th>Tên NVL</th>
                    <th>Số lượng cần</th>
                    <th>Đơn vị</th>
                    <th>Tồn kho</th>
                    <th>Cần nhập</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="7" style="text-align:center; color:gray;">Vui lòng chọn kế hoạch để hiển thị NVL</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div style="margin-top: 1rem; padding: 1rem; background-color: var(--gray-100); border-radius: var(--radius);">
              <strong>Số lượng NVL được chọn:</strong> <span id="selectedCount">0</span>
            </div>

            <div class="button-group">
              <button type="button" class="btn-secondary" onclick="switchTab('list', event)">Hủy</button>
              <button type="submit" class="btn-primary">Lưu phiếu</button>
            </div>
          </form>
        </div>
      </section>

    </div>
  </main>
</div>

<?php require_once './app/views/layouts/footer.php'; ?>

<style>
<?php include './public/css/phieu-nhap.css'; ?>
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const dateInput = document.getElementById('ngayLap');
  dateInput.value = new Date().toISOString().split('T')[0];
});

function switchTab(tab, e) {
  document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
  document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
  document.getElementById(tab).classList.add('active');
  e.target.classList.add('active');
}
</script>
