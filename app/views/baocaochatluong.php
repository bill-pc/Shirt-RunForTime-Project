<?php require_once 'app/views/layouts/header.php'; ?>
<?php require_once 'app/views/layouts/nav.php'; ?>

<style>
.table-container {
    background:#fff; 
    padding:20px; 
    border-radius:8px; 
    box-shadow:0 2px 5px rgba(0,0,0,0.1);
}

.data-table th {
    background:#f1f5f9;
    padding:10px;
    border:1px solid #e2e8f0;
    text-align:center;
}

.data-table td {
    padding:10px;
    border:1px solid #e2e8f0;
}

.btn-view {
    background:#007bff; 
    color:white; 
    border:none; 
    padding:6px 12px; 
    border-radius:4px; 
    cursor:pointer;
}

.btn-view:hover {
    background:#0069d9;
}

.modal {
    display:none; 
    position:fixed; 
    top:0; 
    left:0; 
    width:100%; 
    height:100%; 
    background:rgba(0,0,0,0.5); 
    z-index:1000; 
    justify-content:center; 
    align-items:center;
}

.modal-content {
    background:white; 
    padding:25px; 
    border-radius:8px; 
    width:420px; 
    max-width:95%;
}

.btn-close {
    background:#6c757d; 
    color:white; 
    border:none; 
    padding:8px 15px; 
    border-radius:4px; 
    cursor:pointer;
}

.btn-export {
    background:#28a745; 
    color:white; 
    border:none; 
    padding:8px 15px; 
    border-radius:4px; 
    cursor:pointer;
}
</style>

<div class="main-layout-wrapper">
<?php require_once 'app/views/layouts/sidebar.php'; ?>

<main class="main-content">
    <h2 class="main-title" style="text-align:center; color:#0d1a44;">BÁO CÁO CHẤT LƯỢNG</h2>

    <div class="table-container">
        <table class="data-table" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Mã QC</th>
                    <th>Sản phẩm</th>
                    <th>Tổng SL</th>
                    
                    <th>Người lập</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
            <?php if (!empty($dsBaoCao)): ?>
                <?php foreach ($dsBaoCao as $row): ?>
                <tr>
                    <td style="text-align:center;"><?= $row['maYC'] ?></td>
                    <td><?= $row['tenSanPham'] ?></td>
                    <td style="text-align:center; font-weight:bold;"><?= $row['soLuong'] ?></td>
                    
                    <td style="text-align:center;"><?= $row['tenNguoiLap'] ?></td>
                    <td style="text-align:center;">
                        <button class="btn-view" onclick="openDetail(<?= $row['maYC'] ?>)">Xem</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px;">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
</div>

<!-- Modal -->
<!-- Modal -->
<div id="detailModal" class="modal">
    <div class="modal-content">

        <h3 style="margin-top:0; color:#0d1a44; border-bottom:1px solid #eee; padding-bottom:10px;">
            Chi tiết báo cáo
        </h3>

        <p><b>Mã QC:</b> <span id="ctMaYC"></span></p>
        <p><b>Sản phẩm:</b> <span id="ctTenSP"></span></p>
        <p><b>Tổng SL:</b> <span id="ctTongSL"></span></p>
        <p><b>SL Đạt:</b> <span id="ctDat"></span></p>
        <p><b>SL Hỏng:</b> <span id="ctHong"></span></p>
        <p><b>Ghi chú:</b> <span id="ctGhiChu"></span></p>
        <p><b>Người lập:</b> <span id="ctNguoiLap"></span></p>
        <p><b>Ngày kiểm tra:</b> <span id="ctNgay"></span></p>

        <div style="text-align:right; border-top:1px solid #eee; padding-top:15px;">
            <button class="btn-close" onclick="detailModal.style.display='none'">Đóng</button>
            <a id="btnExport" class="btn-export">Xuất CSV</a>
        </div>

    </div>
</div>

<script>
function openDetail(maYC) {
    fetch("index.php?page=baocao-get&maYC=" + maYC)
        .then(res => res.json())
        .then(data => {

            document.getElementById("ctMaYC").innerText = maYC;
            document.getElementById("ctTenSP").innerText = data.tenSanPham;
            document.getElementById("ctTongSL").innerText = data.soLuong;
            document.getElementById("ctDat").innerText = data.soLuongDat;
            document.getElementById("ctHong").innerText = data.soLuongHong;
            document.getElementById("ctGhiChu").innerText = data.ghiChu;
            document.getElementById("ctNguoiLap").innerText = data.tenNguoiLap;
            document.getElementById("ctNgay").innerText = data.ngayKiemTra;

            document.getElementById("btnExport").href = 
                "index.php?page=baocao-export&maYC=" + maYC;

            document.getElementById("detailModal").style.display = "flex";
        });
}

window.onclick = function(e){
    const modal = document.getElementById('detailModal');
    if (e.target === modal) modal.style.display = "none";
};
</script>


<?php require_once 'app/views/layouts/footer.php'; ?>
