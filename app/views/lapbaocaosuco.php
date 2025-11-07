<?php
// Nạp layout chung (header + nav)
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper">

    <?php
    // Thanh sidebar
    require_once 'app/views/layouts/sidebar.php';
    ?>

    <main class="main-content">

        <style>
        .report-form-container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 32px 40px;
            max-width: 650px;
            margin: 20px auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .report-form-container h2 {
            text-align: center;
            color: #0d1a44;
            margin-bottom: 15px;
            font-size: 22px;
            font-weight: 700;
        }

        .report-form-container hr {
            border: none;
            border-top: 1px solid #e1e7ef;
            margin-bottom: 25px;
        }

        .report-form label {
            display: block;
            font-weight: 600;
            margin-top: 15px;
            margin-bottom: 6px;
            color: #0d1a44;
        }

        .report-form input[type="text"],
        .report-form select,
        .report-form textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cfd8e3;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .report-form input:focus,
        .report-form textarea:focus,
        .report-form select:focus {
            border-color: #5a8dee;
            box-shadow: 0 0 0 2px rgba(90,141,238,0.25);
            outline: none;
        }

        /* Search box */
        .search-box {
            position: relative;
        }

        .search-results {
            border: 1px solid #d1d9e6;
            border-radius: 8px;
            background: white;
            position: absolute;
            width: 100%;
            max-height: 150px;
            overflow-y: auto;
            z-index: 10;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            display: none;
            top: 100%;
            left: 0;
        }

        .search-results div {
            padding: 8px 12px;
            cursor: pointer;
        }
        .search-results div:hover {
            background-color: #eef4ff;
        }

        /* File upload */
        .file-upload {
            display: block;
            width: 100%;
            margin-top: 10px;
            padding: 50px;
            border: 1px dashed #b8c4d9;
            border-radius: 10px;
            background-color: #f9fbff;
            text-align: center;
            color: #666;
            transition: all 0.2s ease;
        }
        .file-upload:hover {
            border-color: #7da6f8;
            background-color: #f0f5ff;
        }

        /* Buttons */
        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
        }

        .cancel-btn, .submit-btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .cancel-btn {
            background-color: #f0f0f0;
            color: #333;
        }
        .cancel-btn:hover {
            background-color: #e2e2e2;
        }

        .submit-btn {
            background-color: #5a8dee;
            color: white;
        }
        .submit-btn:hover {
            background-color: #4076db;
        }
        </style>

        <div class="report-form-container">
            <h2>Lập báo cáo lỗi và sự cố</h2>
            

            <form action="index.php?page=luu-baocaosuco" method="POST" enctype="multipart/form-data" class="report-form">
                <!-- 🔽 THÊM PHẦN CHỌN XƯỞNG -->
                <label for="xuong">Xưởng</label>
                <select id="xuong" name="xuong">
                    <option value="">Chọn xưởng</option>
                    <option value="1">Xưởng cắt</option>
                    <option value="2">Xưởng may</option>
                </select>

                <label for="ma_thiet_bi">Mã thiết bị</label>
                <select id="ma_thiet_bi" name="ma_thiet_bi" required>
                    <option value="">-- Chọn thiết bị --</option>
                </select>

                <label for="ten_thiet_bi">Tên thiết bị</label>
                <input type="text" id="ten_thiet_bi" name="ten_thiet_bi" readonly>

                <label for="loai_loi">Loại lỗi</label>
                <select id="loai_loi" name="loai_loi" required>
                    <option value="">Chọn loại lỗi</option>
                    <option value="phanmem">Lỗi phần mềm</option>
                    <option value="phancung">Lỗi phần cứng</option>
                    <option value="khac">Khác</option>
                </select>

                <label for="mo_ta">Mô tả chi tiết</label>
                <textarea id="mo_ta" name="mo_ta" rows="4" placeholder="Mô tả chi tiết lỗi hoặc sự cố..."></textarea>

                <label for="hinh_anh">Hình ảnh minh họa</label>
                <input type="file" id="hinh_anh" name="hinh_anh" class="file-upload">

                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="window.history.back()">Hủy</button>
                    <button type="submit" class="submit-btn">Gửi báo cáo</button>
                </div>
            </form>
        </div>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    const xuongSelect = document.getElementById("xuong");
    const maThietBiSelect = document.getElementById("ma_thiet_bi");
    const tenThietBiInput = document.getElementById("ten_thiet_bi");

    // Khi chọn xưởng => load danh sách thiết bị
    xuongSelect.addEventListener("change", async function() {
        const xuong = this.value;
        maThietBiSelect.innerHTML = '<option value="">-- Chọn thiết bị --</option>';
        tenThietBiInput.value = '';

        if (!xuong) return;

        try {
            const res = await fetch(`index.php?page=search&type=thietbi&keyword=&xuong=${encodeURIComponent(xuong)}`);
            const data = await res.json();

            if (data.length > 0) {
                data.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.maThietBi;
                    option.textContent = `${item.maThietBi} - ${item.tenThietBi}`;
                    option.dataset.ten = item.tenThietBi;
                    maThietBiSelect.appendChild(option);
                });
            } else {
                const opt = document.createElement("option");
                opt.textContent = "Không có thiết bị nào trong xưởng này";
                maThietBiSelect.appendChild(opt);
            }
        } catch (err) {
            console.error("Lỗi khi tải thiết bị:", err);
        }
    });

    // Khi chọn thiết bị => tự điền tên thiết bị
    maThietBiSelect.addEventListener("change", function() {
        const selected = this.options[this.selectedIndex];
        const tenTB = selected ? (selected.dataset.ten || "") : "";
        tenThietBiInput.value = tenTB;
    });
});
</script>


    </main>
</div>

<?php
// Footer
require_once 'app/views/layouts/footer.php';
?>
