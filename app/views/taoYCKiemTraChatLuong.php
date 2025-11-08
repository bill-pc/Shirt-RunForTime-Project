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
        <select name="planCode" id="planCode" required
                style="padding:8px 12px; border:1px solid #ccc; border-radius:8px; font-size:15px; min-width:200px;">
          <option value="">-- Chọn kế hoạch --</option>
          <?php foreach ($plans as $p): ?>
            <option value="<?= $p['maKHSX'] ?>"><?= htmlspecialchars($p['tenKHSX']) ?></option>
          <?php endforeach; ?>
        </select>

        <input type="hidden" name="tenNguoiLap"
               value="<?= $_SESSION['user']['tenNhanVien'] ?? 'Hệ thống' ?>">

        <button type="submit"
                style="background:#1d3557; color:white; padding:10px 18px; border:none; border-radius:8px;
                       font-weight:600; cursor:pointer; transition:0.3s;">
          Tạo phiếu kiểm tra chất lượng
        </button>
      </form>

      <!-- Bảng danh sách NVL -->
      <section style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.1); padding:20px;">
        <h2 style="font-size:20px; color:#1d3557; font-weight:600; margin-bottom:15px;">
          Danh sách Nguyên Vật Liệu thuộc kế hoạch
        </h2>
        <table id="materialsTable"
               style="width:100%; border-collapse:collapse; font-size:15px; text-align:center;">
          <thead style="background:#457b9d; color:white;">
            <tr>
              <th style="padding:10px;">Mã NVL</th>
              <th style="padding:10px;">Tên NVL</th>
              <th style="padding:10px;">Xưởng</th>
              <th style="padding:10px;">Số lượng cần kiểm tra</th>
            </tr>
          </thead>
          <tbody>
            <tr><td colspan="4" style="padding:12px; color:#666;">Chưa chọn kế hoạch...</td></tr>
          </tbody>
        </table>
      </section>
    </div>
  </main>
</div>

<!-- ========== STYLE ========== -->
<style>
#materialsTable tbody tr:hover {
  background-color: #f1f8ff;
  transition: 0.2s;
}
#materialsTable td, #materialsTable th {
  border-bottom: 1px solid #ddd;
}
</style>

<!-- ========== SCRIPT ========== -->
<script>
document.getElementById('planCode').addEventListener('change', function() {
  const maKHSX = this.value;
  const tbody = document.querySelector('#materialsTable tbody');
  tbody.innerHTML = `<tr><td colspan="4" style="padding:12px; color:#666;">Đang tải dữ liệu...</td></tr>`;
  if (!maKHSX) {
    tbody.innerHTML = `<tr><td colspan="4" style="padding:12px; color:#666;">Chưa chọn kế hoạch...</td></tr>`;
    return;
  }

  fetch(`app/controllers/api.php?action=getMaterials&maKHSX=${maKHSX}`)

    .then(res => res.json())
    .then(data => {
      if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" style="padding:12px; color:#888;">Không có NVL nào trong kế hoạch này.</td></tr>`;
        return;
      }
      tbody.innerHTML = data.map(row => `
        <tr>
          <td>${row.maNVL}</td>
          <td style="text-align:left; padding-left:15px;">${row.tenNVL}</td>
          <td>${row.tenXuong}</td>
          <td>${row.soLuong}</td>
        </tr>`).join('');
    })
    .catch(err => {
      tbody.innerHTML = `<tr><td colspan="4" style="padding:12px; color:red;">Lỗi tải dữ liệu!</td></tr>`;
      console.error(err);
    });
});
</script>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
