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

          <form method="POST" action="index.php?page=luu-yeu-cau-nhap-kho">
            <div class="form-row">
              <div class="form-group">
                <label for="ngayLap" class="required">Ngày lập phiếu</label>
                <input type="date" id="ngayLap" name="ngayLap" required>
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
            </div>

            <div class="form-group">
              <label for="ghiChu">Ghi chú</label>
              <textarea id="ghiChu" name="ghiChu" placeholder="Nhập ghi chú nếu có..."></textarea>
            </div>

            <div class="table-container">
              <table id="tableNVL">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Mã NVL</th>
                    <th>Tên NVL</th>
                    <th>Số lượng</th>
                    <th>Đơn vị</th>
                    <th style="min-width: 200px;">Nhà cung cấp</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td colspan="6" style="text-align:center; color:gray;">Vui lòng chọn kế hoạch để hiển thị NVL</td>
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

.ncc-select {
  width: 100%;
  padding: 6px 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.ncc-select:disabled {
  background-color: #f5f5f5;
  cursor: not-allowed;
}

.ncc-select:focus {
  outline: none;
  border-color: #3b7ddd;
  box-shadow: 0 0 0 2px rgba(59, 125, 221, 0.1);
}
</style>

<script>
// Danh sách nhà cung cấp mẫu
const nhaCungCapList = [
  'Công ty Vải Việt Nam',
  'Công ty Sợi Quốc Tế',
  'Công ty Phụ liệu May Mặc',
  'Công ty Vải Cotton Cao Cấp',
  'Công ty Phụ Kiện Thời Trang'
];

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

// Cập nhật số lượng NVL được chọn
function updateSelectedCount() {
  const checked = document.querySelectorAll('input[name="nvl[]"]:checked').length;
  document.getElementById('selectedCount').textContent = checked;
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
        <tr><td colspan="6" style="text-align:center; color:gray;">Vui lòng chọn kế hoạch khác</td></tr>`;
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
        <tr><td colspan="6" style="text-align:center; color:gray;">
          Không có nguyên vật liệu cho kế hoạch này
        </td></tr>`;
      return;
    }

    // Tạo options cho nhà cung cấp
    const nccOptions = nhaCungCapList.map(ncc => `<option value="${ncc}">${ncc}</option>`).join('');

    tbody.innerHTML = data.map((item, index) => {
      return `
      <tr>
        <td><input type="checkbox" name="nvl[]" value="${item.maNVL}"></td>
        <td>${item.maNVL}</td>
        <td>${item.tenNVL}</td>
        <td>${item.soLuongCan}</td>
        <td>${item.donViTinh ?? '-'}</td>
        <td>
          <select name="nhaCungCap_${item.maNVL}" class="ncc-select" disabled required>
            <option value="">-- Chọn nhà cung cấp --</option>
            ${nccOptions}
          </select>
        </td>
      </tr>
    `}).join('');
    
    updateSelectedCount();
  } catch (error) {
    console.error('Lỗi tải NVL:', error);
  }
});

// Cập nhật khi checkbox thay đổi
document.addEventListener('change', (e) => {
  if (e.target.name === 'nvl[]') {
    const row = e.target.closest('tr');
    const nccSelect = row.querySelector('.ncc-select');
    
    if (e.target.checked) {
      nccSelect.disabled = false;
      nccSelect.required = true;
    } else {
      nccSelect.disabled = true;
      nccSelect.required = false;
      nccSelect.value = '';
    }
    
    updateSelectedCount();
  }

  if (e.target.id === 'selectAll') {
    const all = document.querySelectorAll('input[name="nvl[]"]');
    all.forEach(cb => {
      cb.checked = e.target.checked;
      const row = cb.closest('tr');
      const nccSelect = row.querySelector('.ncc-select');
      if (nccSelect) {
        nccSelect.disabled = !e.target.checked;
        nccSelect.required = e.target.checked;
      }
    });
    updateSelectedCount();
  }
});

// ✅ Kiểm tra trước khi submit form
document.querySelector('form').addEventListener('submit', function(e) {
  const checkedBoxes = document.querySelectorAll('input[name="nvl[]"]:checked');
  
  if (checkedBoxes.length === 0) {
    e.preventDefault();
    alert("⚠️ Vui lòng chọn ít nhất một nguyên vật liệu cần nhập kho!");
    return false;
  }

  // Kiểm tra nhà cung cấp đã được chọn chưa
  let missingNCC = false;
  checkedBoxes.forEach(checkbox => {
    const row = checkbox.closest('tr');
    const nccSelect = row.querySelector('.ncc-select');
    if (nccSelect && !nccSelect.value) {
      missingNCC = true;
      nccSelect.style.border = '2px solid red';
    }
  });

  if (missingNCC) {
    e.preventDefault();
    alert("⚠️ Vui lòng chọn nhà cung cấp cho tất cả các NVL được chọn!");
    return false;
  }
});

</script>
