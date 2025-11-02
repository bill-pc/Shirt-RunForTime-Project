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
              <option value="">-- Không chọn (nhập thủ công) --</option>
              <option value="PYC-2025-001">PYC-2025-001 - ✅ Đã duyệt</option>
              <option value="PYC-2025-002">PYC-2025-002 - ⏳ Chờ duyệt</option>
              <option value="PYC-2025-003">PYC-2025-003 - ❌ Từ chối</option>
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
                  <th>Số lượng</th>
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
  const materials = [];
  const $ = (s) => document.querySelector(s);

  const requestData = {
    "PYC-2025-001": {
      status: "approved",
      supplier: "Công ty Vải Việt Nam",
      items: [
        { name: "Vải cotton trắng", quantity: 100, unit: "Mét", category: "Vải" },
        { name: "Chỉ may trắng", quantity: 50, unit: "Cuộn", category: "Chỉ" }
      ]
    },
    "PYC-2025-002": { status: "pending" },
    "PYC-2025-003": { status: "rejected" }
  };

  // Khi chọn phiếu yêu cầu
  function loadFromRequest(code) {
    materials.length = 0;
    $('#linesBody').innerHTML = '';
    $('#supplier').value = '';

    if (!code) return;

    const req = requestData[code];
    if (!req) return alert('Không tìm thấy dữ liệu phiếu này.');

    if (req.status !== "approved") {
      alert(`Phiếu ${code} chưa được duyệt, không thể lập phiếu nhập.`);
      $('#requestRef').value = "";
      return;
    }

    $('#supplier').value = req.supplier;
    req.items.forEach(item => materials.push(item));
    renderLines();
  }

  // Hiển thị danh sách NVL
  function renderLines() {
    const tbody = $('#linesBody');
    tbody.innerHTML = '';
    materials.forEach((m) => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${m.name}</td>
        <td>${m.quantity}</td>
        <td>${m.unit}</td>
        <td>${m.category}</td>
      `;
      tbody.appendChild(tr);
    });
  }

  // Gửi form
  document.getElementById('materialForm').addEventListener('submit', (e) => {
    e.preventDefault();
    if (materials.length === 0) return alert('Vui lòng chọn ít nhất 1 nguyên vật liệu.');

    const payload = {
      date: new Date().toLocaleDateString('vi-VN'),
      supplier: $('#supplier').value,
      notes: $('#notes').value,
      items: materials,
    };
    console.log('Phiếu nhập kho:', payload);
    alert('✅ Phiếu nhập kho đã được lưu thành công!');
    e.target.reset();
    materials.length = 0;
    renderLines();
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
