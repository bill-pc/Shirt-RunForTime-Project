<?php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>
<div class="main-layout-wrapper">
  <?php require_once './app/views/layouts/sidebar.php'; ?>

  <main class="main-content">
    <div class="container">
      <div class="card form-section">
        <h2>NHẬP KHO NGUYÊN VẬT LIỆU</h2>
        <form id="materialForm">
          <div class="form-group">
            <label for="requestRef">Phiếu Yêu Cầu Nhập Kho (chỉ phiếu đã duyệt)</label>
            <select id="requestRef" onchange="loadFromRequest(this.value)">
  <option value="">-- Chọn phiếu yêu cầu đã duyệt --</option>
  <?php if (!empty($requests)): ?>
      <?php foreach ($requests as $row): ?>
          <option value="<?= htmlspecialchars($row['maYCNK']) ?>">
              <?= htmlspecialchars($row['maYCNK']) ?> - <?= htmlspecialchars($row['nhaCungCap']) ?> (<?= htmlspecialchars($row['ngayLap']) ?>)
          </option>
      <?php endforeach; ?>loadFromRequest

  <?php else: ?>
      <option disabled>Không có phiếu nào đã duyệt</option>
  <?php endif; ?>
</select>

            <small style="color:#555; display:block; margin-top:5px;">
              Hệ thống chỉ cho phép lấy dữ liệu từ các phiếu <b>Đã duyệt</b>.
            </small>
          </div>

          <div class="form-group">
            <label for="supplier">Nhà Cung Cấp *</label>
            <input type="text" id="supplier" placeholder="Nhập tên nhà cung cấp" required>
          </div>

          <div class="form-group">
            <label for="notes">Ghi Chú</label>
            <textarea id="notes" placeholder="Nhập ghi chú thêm (nếu có)"></textarea>
          </div>

          <!-- Bảng hiển thị NVL -->
          <div class="table-container">
            <table>
                  <thead>
      <tr>
        <th>Tên NVL</th>
        <th>Số lượng yêu cầu</th>
        <th>Tồn kho</th>
        <th>Cần nhập</th>
        <th>Đơn vị</th>
        <th>Loại</th>
      </tr>
    </thead>
    <tbody id="linesBody"></tbody>
            </table>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Lưu Phiếu Nhập</button>
            <button type="reset" class="btn btn-secondary">Xóa</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>

<script>
  // Biến tiện dụng và hàm rút gọn
  const $ = (s) => document.querySelector(s);

  // === KHI CHỌN PHIẾU YÊU CẦU ĐÃ DUYỆT ===
  async function loadFromRequest(maYCNK) {
  if (!maYCNK) return;
  const res = await fetch(`index.php?page=ajax-get-details-nhapkho&maYCNK=${maYCNK}`);
  const data = await res.json();
  const tbody = document.getElementById('linesBody');
  tbody.innerHTML = '';

  data.forEach(row => {
    tbody.innerHTML += `
      <tr>
        <td>${row.tenNVL}</td>
        <td>${row.soLuongYeuCau}</td>
        <td>${row.soLuongTonKho}</td>
        <td>${row.soLuongCanNhap}</td>
        <td>${row.donViTinh ?? '-'}</td>
        <td>${row.loaiNVL ?? '-'}</td>
      </tr>`;
  });

  // ✅ Tự động gán dữ liệu cần nhập cho khi lưu phiếu
  window.selectedItems = data.map(r => ({
    maNVL: parseInt(r.maNVL),
    soLuong: parseInt(r.soLuongCanNhap) || 0
  }));
}


  // === GỬI FORM LƯU PHIẾU NHẬP ===
 document.getElementById('materialForm').addEventListener('submit', async (e) => {
  e.preventDefault();

  if (!window.selectedItems || window.selectedItems.length === 0) {
    alert('⚠️ Không có dữ liệu cần nhập!');
    return;
  }

  const items = window.selectedItems.filter(i => i.soLuong > 0);
  if (items.length === 0) {
    alert('⚠️ Tất cả NVL đều không cần nhập (đủ tồn kho)!');
    return;
  }

  const formData = new FormData();
  formData.append('maYCNK', document.getElementById('requestRef').value);
  formData.append('nhaCungCap', document.getElementById('supplier').value.trim());
  formData.append('items', JSON.stringify(items));

  try {
    const res = await fetch('index.php?page=luu-phieu-nhap-nvl', {
      method: 'POST',
      body: formData
    });
    const text = await res.text();

    // Chạy script trả về (alert + redirect)
    if (text.includes('<script')) {
      const temp = document.createElement('div');
      temp.innerHTML = text;
      temp.querySelectorAll('script').forEach(s => eval(s.innerText));
    } else {
      document.body.innerHTML = text;
    }
  } catch (err) {
    console.error('❌ Lỗi khi gửi dữ liệu:', err);
    alert('Đã xảy ra lỗi khi lưu phiếu nhập!');
  }
});

</script>


<style>
.container {
  max-width: 1100px;
  margin: 0 auto;
}

.form-section {
  background: #fff;
  border: 1px solid #e3e3e3;
  border-radius: 10px;
  padding: 25px 30px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
  transition: box-shadow 0.3s ease;
  position: relative;
}
.form-section:hover {
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
  transform: none !important;
}

.form-section h2 {
  font-size: 18px;
  font-weight: 600;
  color: #004aad;
  margin-bottom: 20px;
  text-align: center;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  font-weight: 500;
  font-size: 14px;
  color: #333;
  margin-bottom: 6px;
  display: block;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 9px 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  background: #fafafa;
  transition: all 0.2s;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: #004aad;
  outline: none;
  background: #fff;
}

.btn {
  display: inline-block;
  border-radius: 5px;
  border: none;
  padding: 8px 15px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: 0.3s;
}

.btn-primary {
  background-color: #004aad;
  color: white;
}
.btn-primary:hover {
  background-color: #003b8e;
}

.btn-secondary {
  background-color: #e0e0e0;
  color: #333;
}
.btn-secondary:hover {
  background-color: #ccc;
}

.table-container {
  margin-top: 15px;
  overflow-x: auto;
}
.table-container table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}
.table-container th,
.table-container td {
  border: 1px solid #ddd;
  padding: 8px;
  text-align: center;
}
.table-container th {
  background-color: #f5f7fa;
  font-weight: 600;
  color: #222;
}

.form-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}
</style>

<?php
require_once 'app/views/layouts/footer.php';
?>
