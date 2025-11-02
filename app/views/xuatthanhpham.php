<?php
// Nạp layout chung
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper">
    <?php require_once 'app/views/layouts/sidebar.php'; ?>

    <main class="main-content">

        <style>
        .xuatkho-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 40px 50px;
            margin: 20px auto;
            max-width: 1100px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        h2 {
            text-align: center;
            font-size: 22px;
            color: #0d1a44;
            margin-bottom: 15px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th, table td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #f1f5fb;
            color: #0d1a44;
            font-weight: 600;
        }

        input[type="number"], input[type="text"] {
            padding: 6px 8px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            width: 90%;
        }

        .btn {
            padding: 8px 14px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: background 0.2s ease;
        }

        .btn-export {
            background-color: #22c55e;
            color: white;
        }

        .btn-export:hover {
            background-color: #16a34a;
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #333;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
        }

        /* Modal xác nhận */
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 25px 30px;
            width: 350px;
            margin: 15% auto;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .modal-content h3 {
            color: #0d1a44;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .modal-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 12px;
        }
        </style>

        <div class="xuatkho-container">
            <h2>📦 Xuất kho thành phẩm theo đơn hàng</h2>

            <table>
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Tên đơn hàng</th>
                        <th>Sản phẩm</th>
                        <th>Tồn kho</th>
                        <th>Số lượng xuất</th>
                        <th>Ghi chú</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($donhangs as $dh): ?>
                    <tr>
                        <td><?= htmlspecialchars($dh['maDonHang']) ?></td>
                        <td><?= htmlspecialchars($dh['tenDonHang']) ?></td>
                        <td><?= htmlspecialchars($dh['tenSanPham']) ?></td>
                        <td><?= htmlspecialchars($dh['soLuongTon']) ?></td>
                        <td>
                            <input type="number" id="soLuong<?= $dh['maDonHang'] ?>" min="1" max="<?= $dh['soLuongTon'] ?>">
                        </td>
                        <td>
                            <input type="text" id="ghiChu<?= $dh['maDonHang'] ?>">
                        </td>
                        <td>
                            <button class="btn btn-export" onclick="showExportModal('<?= $dh['maDonHang'] ?>')">Xuất</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal xác nhận xuất -->
        <div id="exportModal" class="modal">
            <div class="modal-content">
                <h3>Xác nhận xuất kho</h3>
                <p>Bạn có chắc chắn muốn xuất kho đơn hàng này không?</p>
                <div class="modal-buttons">
                    <button class="btn btn-export" id="confirmExport">Xuất</button>
                    <button class="btn btn-cancel" id="cancelExport">Hủy</button>
                </div>
            </div>
        </div>

        <script>
        let currentExportId = null;
        const modal = document.getElementById("exportModal");
        const confirmBtn = document.getElementById("confirmExport");
        const cancelBtn = document.getElementById("cancelExport");

        // Hiện modal xác nhận
        function showExportModal(maDonHang) {
            currentExportId = maDonHang;
            modal.style.display = "block";
        }

        // Đóng modal
        cancelBtn.onclick = function() {
            modal.style.display = "none";
            currentExportId = null;
        }

        // Xác nhận xuất
        confirmBtn.onclick = async function() {
            if (!currentExportId) return;
            const soLuong = document.getElementById("soLuong" + currentExportId).value;
            const ghiChu = document.getElementById("ghiChu" + currentExportId).value;

            if (!soLuong || soLuong <= 0) {
                alert("⚠️ Vui lòng nhập số lượng hợp lệ!");
                return;
            }

            const formData = new FormData();
            formData.append("maDonHang", currentExportId);
            formData.append("soLuongXuat", soLuong);
            formData.append("ghiChu", ghiChu);

            try {
                const res = await fetch("index.php?page=xuatthanhpham_xuat", {
                    method: "POST",
                    body: formData
                });

                const data = await res.json();
                if (data.success) {
                    alert("✅ Xuất kho thành công!");
                    location.reload();
                } else {
                    alert("❌ " + (data.message || "Xuất thất bại!"));
                }
            } catch (err) {
                console.error("Lỗi khi xuất kho:", err);
                alert("⚠️ Không thể kết nối máy chủ!");
            }

            modal.style.display = "none";
            currentExportId = null;
        }

        // Click ra ngoài modal sẽ đóng
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        </script>

    </main>
</div>

<?php require_once 'app/views/layouts/footer.php'; ?>
