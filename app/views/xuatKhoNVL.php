<?php
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper">

    <?php require_once 'app/views/layouts/sidebar.php'; ?>

    <main class="main-content">

        <h2 class="main-title" style="text-align:center; font-size: 1.3em; margin-bottom: 20px;">
            XUẤT KHO NGUYÊN VẬT LIỆU
        </h2>

        <section class="request-list">
            <h3 class="section-title" style="text-align:center; background:#9bc3ebff; color:#495057;
                 padding:10px 15px; border-radius:5px; font-weight:600;">
                DANH SÁCH PHIẾU YÊU CẦU CUNG CẤP NGUYÊN VẬT LIỆU
            </h3>

            <table class="data-table list-table"
                   style="width:100%; border-collapse:collapse; margin-top: 15px; border: 1px solid #dee2e6;">
                <thead>
                    <tr style="background:#f8f9fa;">
                        <th style="padding: 10px; text-align:center;">STT</th>
                        <th style="padding: 10px; text-align:center;">Tên phiếu</th>
                        <th style="padding: 10px; text-align:center;">Người lập</th>
                        <th style="padding: 10px; text-align:center;">Ngày lập</th>
                        <th style="padding: 10px; text-align:center;"></th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($danhSachPhieu)): $stt = 1;
                        foreach ($danhSachPhieu as $row): ?>
                        <tr style="text-align:center;">
                            <td><?= $stt++ ?></td>
                            <td><?= htmlspecialchars($row['tenPhieu']) ?></td>
                            <td><?= htmlspecialchars($row['tenNguoiLap']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['ngayLap'])) ?></td>
                            <td>
                                <a href="index.php?page=chi-tiet-xuat-kho&maYCCC=<?= $row['maYCCC'] ?>"
                                   style="display:inline-block; background:#007bff; padding:6px 12px;
                                          color:white; text-decoration:none; font-size:.9em;
                                          border-radius:5px; font-weight:500;">
                                    ➜ Xem chi tiết
                                </a>
                            </td>
                        </tr>
                        <?php endforeach;
                    else: ?>
                    <tr>
                        <td colspan="5" style="padding:15px; text-align:center; color:#6c757d;">
                            Không có phiếu yêu cầu cung cấp NVL.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

    </main>
</div>

<!-- ✅ Modal báo thành công khi lập phiếu Xuất kho -->
<div id="success-modal" 
     style="display:none; position:fixed;top:0;left:0;width:100%;height:100%;
            background:rgba(0,0,0,0.5);justify-content:center;align-items:center;z-index:1000;">
    <div style="background:#fff;padding:25px 35px;border-radius:8px;text-align:center;
                box-shadow:0 4px 15px rgba(0,0,0,0.2);min-width:300px;">
        <p style="font-size:1.1em;font-weight:bold;color:#28a745;margin-bottom:20px;">
            Lập phiếu xuất kho thành công!
        </p>
        <button id="btn-close"
                style="background:#007bff;color:white;padding:8px 20px;border:none;border-radius:5px;
                       cursor:pointer;font-weight:bold;">
            Đóng
        </button>
    </div>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const successModal = document.getElementById("success-modal");
    const btnClose = document.getElementById("btn-close");

    const params = new URLSearchParams(window.location.search);
    
    // ✅ Chỉ hiển thị modal khi về trang này từ hành động lập phiếu
    if (params.get("success") === "1") {
        successModal.style.display = "flex";

        const cleanUrl = window.location.pathname;
        history.replaceState({}, "", cleanUrl);
    }

    btnClose?.addEventListener("click", () => {
        successModal.style.display = "none";
    });

    successModal.addEventListener("click", (e) => {
        if (e.target === successModal) successModal.style.display = "none";
    });
});
</script>