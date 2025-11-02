<?php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>
<div class="main-layout-wrapper">
    <?php require_once 'app/views/layouts/sidebar.php'; ?>

    <main class="main-content">
        <style>
            .nhanvien-container{background:#fff;border-radius:12px;padding:28px;margin:20px;box-shadow:0 4px 15px rgba(0,0,0,.08)}
            h2{margin:0 0 14px;font-size:22px;color:#0d1a44;font-weight:700;text-align:center}
            .search-bar{display:flex;gap:10px;justify-content:space-between;align-items:center;margin-bottom:10px;position:relative}
            .search-bar input{width:260px;padding:8px 12px;border:1px solid #cbd5e1;border-radius:6px}
            .search-bar button{padding:8px 14px;border:none;border-radius:6px;background:#5a8dee;color:#fff;cursor:pointer}
            table{width:100%;border-collapse:collapse}
            th,td{border:1px solid #e2e8f0;padding:10px;text-align:center}
            th{background:#f1f5fb;color:#0d1a44;font-weight:600}
            .btn{padding:7px 12px;border-radius:6px;border:none;cursor:pointer}
            .btn-delete{background:#ef4444;color:#fff}
            .btn-delete:hover{background:#dc2626}
            .btn-icon{padding:6px 9px;background:#f3f4f6}
            .btn-icon i{font-size:14px}
            .modal{display:none;position:fixed;z-index:999;inset:0;background:rgba(0,0,0,.4)}
            .modal-content{width:360px;margin:12% auto;background:#fff;border-radius:10px;padding:22px 26px;text-align:center;box-shadow:0 2px 10px rgba(0,0,0,.2)}
            .modal-buttons{margin-top:16px;display:flex;gap:12px;justify-content:center}
            .suggestions-list{position:absolute;top:100%;left:0;width:260px;background:#fff;border:none;border-radius:6px;box-shadow:0 4px 10px rgba(0,0,0,.1);z-index:1000;list-style:none;margin:4px 0 0;padding:0;max-height:220px;overflow:auto}
            .suggestions-list li{padding:8px 10px;cursor:pointer}
            .suggestions-list li:hover{background:#f2f2f2}
            .action-icons a{margin:0 6px}
        </style>

        <div class="nhanvien-container">
            <h2>Danh sách nhân viên</h2>

            <div class="search-bar">
                <input type="text" id="search" placeholder="Tìm kiếm nhân viên...">
                <button id="btnFind">Tìm</button>
                <ul id="suggestions" class="suggestions-list"></ul>
            </div>

            <table id="nhanvienTable">
                <thead>
                    <tr>
                        <th>Mã NV</th>
                        <th>Họ tên</th>
                        <th>Chức vụ</th>
                        <th>Phòng ban</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($nhanviens as $nv): ?>
                    <tr>
                        <td><?= htmlspecialchars($nv['maND']) ?></td>
                        <td><?= htmlspecialchars($nv['hoTen']) ?></td>
                        <td><?= htmlspecialchars($nv['chucVu']) ?></td>
                        <td><?= htmlspecialchars($nv['phongBan']) ?></td>
                        <td><?= htmlspecialchars($nv['diaChi']) ?></td>
                        <td><?= htmlspecialchars($nv['email']) ?></td>
                        <td><?= htmlspecialchars($nv['soDienThoai']) ?></td>
                        <td class="action-icons">
                            <!-- Xem -->
                            <a class="btn btn-icon" title="Xem"
                               href="index.php?page=xemnhanvien&id=<?= $nv['maND'] ?>">
                                <i class="fa fa-eye" style="color:#2563eb"></i>
                            </a>
                            <!-- Sửa -->
                            <a class="btn btn-icon" title="Sửa"
                               href="index.php?page=suathongtinnv&id=<?= $nv['maND'] ?>">
                                <i class="fas fa-pen" style="color:#0ea5e9"></i>
                            </a>
                            <!-- Xóa (modal) -->
                            <button class="btn btn-delete" onclick="showDeleteModal('<?= $nv['maND'] ?>')">
                                Xóa
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal xác nhận xóa -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <h3>Xác nhận xóa nhân viên</h3>
                <p>Bạn có chắc chắn muốn xóa nhân viên này không?</p>
                <div class="modal-buttons">
                    <button class="btn btn-delete" id="confirmDelete">Xóa</button>
                    <button class="btn" id="cancelDelete">Hủy</button>
                </div>
            </div>
        </div>

        <script>
        // ====== XÓA (giống trang xoanhanvien) ======
        let currentDeleteId = null;
        const modal = document.getElementById('deleteModal');
        const confirmBtn = document.getElementById('confirmDelete');
        const cancelBtn  = document.getElementById('cancelDelete');

        function showDeleteModal(maNV){
            currentDeleteId = maNV;
            modal.style.display = 'block';
        }
        cancelBtn.onclick = () => { modal.style.display = 'none'; currentDeleteId = null; };
        window.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };

        confirmBtn.onclick = async () => {
            if (!currentDeleteId) return;
            try {
                const res = await fetch(`index.php?page=xoanhanvien&id=${currentDeleteId}`, {
                    method: 'POST',
                    headers: {'X-Requested-With':'XMLHttpRequest'}
                });
                const data = await res.json();
                if (data.success){
                    alert('Xóa thành công!');
                    location.reload();
                } else {
                    alert('Xóa thất bại: ' + (data.message || 'Lỗi không xác định'));
                }
            } catch(err){
                console.error(err);
                alert('Không thể xóa nhân viên.');
            } finally {
                modal.style.display = 'none';
            }
        };

        // ====== TÌM KIẾM + GỢI Ý ======
        const searchInput  = document.getElementById('search');
        const suggestions  = document.getElementById('suggestions');
        const btnFind      = document.getElementById('btnFind');

        async function callSearch(keyword){
            const res = await fetch(`index.php?page=timkiem-nhanvien&keyword=${encodeURIComponent(keyword)}`);
            return await res.json();
        }

        function renderRows(rows){
            const tbody = document.querySelector('#nhanvienTable tbody');
            tbody.innerHTML = rows.map(nv => `
                <tr>
                    <td>${nv.maND}</td>
                    <td>${nv.hoTen}</td>
                    <td>${nv.chucVu}</td>
                    <td>${nv.phongBan}</td>
                    <td>${nv.diaChi}</td>
                    <td>${nv.email}</td>
                    <td>${nv.soDienThoai}</td>
                    <td class="action-icons">
                        <a class="btn btn-icon" title="Xem" href="index.php?page=xemnhanvien&id=${nv.maND}">
                            <i class="fa fa-eye" style="color:#2563eb"></i>
                        </a>
                        <a class="btn btn-icon" title="Sửa" href="index.php?page=suathongtinnv&id=${nv.maND}">
                            <i class="fas fa-pen" style="color:#0ea5e9"></i>
                        </a>
                        <button class="btn btn-delete" onclick="showDeleteModal('${nv.maND}')">Xóa</button>
                    </td>
                </tr>
            `).join('');
        }

        searchInput.addEventListener('keyup', async () => {
            const kw = searchInput.value.trim();
            if (kw.length < 2){ suggestions.innerHTML = ''; return; }
            try{
                const data = await callSearch(kw);
                suggestions.innerHTML = data.map(item => `<li data-id="${item.maND}">${item.hoTen}</li>`).join('');
            }catch(e){ console.error(e); }
        });

        suggestions.addEventListener('click', async (e) => {
            if (e.target.tagName === 'LI'){
                const name = e.target.textContent;
                searchInput.value = name;
                suggestions.innerHTML = '';
                try{
                    const data = await callSearch(name);
                    renderRows(data);
                }catch(e){ console.error(e); }
            }
        });

        btnFind.addEventListener('click', async () => {
            const kw = searchInput.value.trim();
            const data = kw ? await callSearch(kw) : [];
            if (kw) renderRows(data);
        });
        </script>
    </main>
</div>
<?php require_once 'app/views/layouts/footer.php'; ?>
