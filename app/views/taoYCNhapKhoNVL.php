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
                        <span class="status-badge status-approved">Đã duyệt</span>
                      <?php elseif ($phieu['trangThai'] === 'Đã nhập kho'): ?>
                        <span class="status-badge status-success">Đã nhập kho</span>
                      <?php elseif ($phieu['trangThai'] === 'Từ chối'): ?>
                        <span class="status-badge status-rejected">Từ chối</span>
                      <?php else: ?>
                        <span class="status-badge status-pending">Chờ duyệt</span>
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
              <table id="tableNVL">
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

// Khi chọn kế hoạch sản xuất
document.getElementById('maKHSX').addEventListener('change', async (e) => {
  const maKHSX = e.target.value;
  if (!maKHSX) return;

  // ✅ Bước 1: Kiểm tra kế hoạch đã lập phiếu hay chưa
  try {
    const checkRes = await fetch(`app/controllers/ajax_check_khsx.php?maKHSX=${maKHSX}`);
    const { exists } = await checkRes.json();

    if (exists) {
      alert('⚠️ Kế hoạch sản xuất này đã được lập phiếu yêu cầu nhập kho NVL rồi!');
      e.target.value = ''; // reset chọn
      document.querySelector('#tableNVL tbody').innerHTML = `
        <tr><td colspan="7" style="text-align:center; color:gray;">Vui lòng chọn kế hoạch khác</td></tr>`;
      return;
    }
  } catch (error) {
    console.error('Lỗi kiểm tra kế hoạch:', error);
  }

  // ✅ Bước 2: Nếu chưa tồn tại, tiếp tục load danh sách NVL
  try {
   const res = await fetch(`app/controllers/ajax_get_nvl.php?maKHSX=${maKHSX}`);
    const data = await res.json();
    const tbody = document.querySelector('#tableNVL tbody');

    if (!Array.isArray(data) || data.length === 0) {
      tbody.innerHTML = `
        <tr><td colspan="7" style="text-align:center; color:gray;">
          Không có nguyên vật liệu cho kế hoạch này
        </td></tr>`;
      return;
    }

    tbody.innerHTML = data.map(item => `
      <tr>
        <td><input type="checkbox" name="nvl[]" value="${item.maNVL}"></td>
        <td>${item.maNVL}</td>
        <td>${item.tenNVL}</td>
        <td>${item.soLuongCan}</td>
        <td>${item.donViTinh ?? '-'}</td>
        <td>${item.soLuongTonKho ?? 0}</td>
        <td>${Math.max(item.soLuongCan - (item.soLuongTonKho ?? 0), 0)}</td>
      </tr>
    `).join('');
  } catch (error) {
    console.error('Lỗi tải NVL:', error);
  }
});

// Cập nhật đếm số lượng NVL được chọn
// Cập nhật đếm số lượng NVL được chọn
document.addEventListener('change', (e) => {
  if (e.target.name === 'nvl[]') {
    const checked = document.querySelectorAll('input[name="nvl[]"]:checked').length;
    document.getElementById('selectedCount').textContent = checked;
  }

  if (e.target.id === 'selectAll') {
    const all = document.querySelectorAll('input[name="nvl[]"]');
    all.forEach(cb => cb.checked = e.target.checked);
    document.getElementById('selectedCount').textContent = e.target.checked ? all.length : 0;
  }
});

// ✅ Kiểm tra trước khi submit form
document.querySelector('form').addEventListener('submit', function(e) {
  const rows = document.querySelectorAll('#tableNVL tbody tr');
  let canNhapCount = 0;

  rows.forEach(row => {
    const cell = row.children[6]; // cột “Cần nhập”
    if (cell && parseFloat(cell.textContent) > 0) {
      canNhapCount++;
    }
  });

  if (canNhapCount === 0) {
    e.preventDefault();
    alert("⚠️ Tất cả nguyên vật liệu đều đủ tồn kho. Không cần lập phiếu nhập kho!");
    return false;
  }
});

</script>
