<?php
// Đường dẫn tính từ file index.php ở gốc
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php'; // Thanh nav ngang
?>

<div class="main-layout-wrapper">

    <?php
    // Tải Sidebar (thanh nav dọc)
    require_once 'app/views/layouts/sidebar.php';
    ?>

    <main class="main-content">
<style>
            /* body { ... } */ /* Nên bỏ style body nếu đã có layout chung */

            .report-form-container {
                background-color: #ffffff;
                border-radius: 12px;
                padding: 32px 40px;
                max-width: 600px; /* Hoặc điều chỉnh nếu cần */
                margin: 20px auto; /* Căn giữa trong main-content */
                box-shadow: 0 4px 15px rgba(0,0,0,0.08);
                /* animation: fadeIn 0.3s ease; */ /* Bỏ animation nếu không cần */
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .report-form-container h2 {
                text-align: center;
                color: #0d1a44;
                margin-bottom: 15px;
                font-size: 22px;
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
            /* Style cho input file (có thể giữ hoặc bỏ nếu dùng style mặc định) */
            /* .file-upload { ... } */

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

            /* Search result box */
             .search-box { /* Thêm position relative */
                position: relative;
             }
            .search-results {
                border: 1px solid #d1d9e6;
                border-radius: 8px;
                background: white;
                position: absolute; /* Đảm bảo position absolute */
                width: 100%; /* Chiếm toàn bộ chiều rộng của parent */
                max-height: 150px;
                overflow-y: auto;
                z-index: 10;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                display: none;
                top: 100%; /* Hiển thị ngay dưới ô input */
                left: 0;
            }
            .search-results div {
                padding: 8px 12px;
                cursor: pointer;
            }
            .search-results div:hover {
                background-color: #eef4ff;
            }
        </style>

        <div class="report-form-container">
            <h2>Lập báo cáo lỗi và sự cố</h2>
            <hr>

            <form action="#" method="POST" enctype="multipart/form-data" class="report-form">
                <label for="search_device">Mã thiết bị</label>
                <div class="search-box">
                    <input type="text" id="search_device" placeholder="Nhập mã hoặc tên thiết bị...">
                    <div id="search_results" class="search-results"></div>
                </div>
                <label for="ten_thiet_bi">Tên thiết bị</label>
                <input type="text" id="ten_thiet_bi" name="ten_thiet_bi" readonly>

                <label for="loai_loi">Loại lỗi</label>
                <select id="loai_loi" name="loai_loi">
                    <option value="">Chọn loại lỗi</option>
                    <option value="phanmem">Lỗi phần mềm</option>
                    <option value="phancung">Lỗi phần cứng</option>
                    <option value="khac">Khác</option>
                </select>

                <label for="mo_ta">Mô tả</label>
                <textarea id="mo_ta" name="mo_ta" rows="4"></textarea>

                <label for="hinh_anh">Hình ảnh</label>
                <input type="file" id="hinh_anh" name="hinh_anh" style="display: block; margin-top: 10px; border: 1px solid #ccc; padding: 5px; border-radius: 4px;">

                <div class="form-buttons">
                    <button type="button" class="cancel-btn" onclick="window.history.back()">Hủy</button>
                    <button type="submit" class="submit-btn">Gửi báo cáo</button>
                </div>
            </form>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.getElementById("search_device");
            const resultBox = document.getElementById("search_results"); // Lấy div có sẵn
            const tenThietBiInput = document.getElementById("ten_thiet_bi");

            if (!input || !resultBox || !tenThietBiInput) {
                console.error("Thiếu phần tử HTML cho search box!");
                return;
            }

            input.addEventListener("input", async function() {
                const keyword = this.value.trim();
                if (keyword.length < 1) { // Hiện gợi ý ngay khi gõ
                    resultBox.style.display = "none";
                    resultBox.innerHTML = ''; // Xóa kết quả cũ
                    return;
                }

                try {
                    // !!! QUAN TRỌNG: Sửa lại đường dẫn fetch cho đúng !!!
                    const response = await fetch(`index.php?page=search-device&keyword=${encodeURIComponent(keyword)}`);

                     if (!response.ok) { throw new Error(`Lỗi HTTP: ${response.status}`); }
                    const data = await response.json();

                    resultBox.innerHTML = "";
                    if(data && data.length > 0) {
                        data.forEach(item => {
                            const option = document.createElement("div");
                            option.textContent = `${item.maThietBi || 'N/A'} - ${item.tenThietBi || 'Không rõ'}`;
                            option.style.padding = '8px 12px';
                            option.style.cursor = 'pointer';
                            option.addEventListener('mouseover', () => option.style.backgroundColor = '#eef4ff');
                            option.addEventListener('mouseout', () => option.style.backgroundColor = 'white');

                            option.onclick = function() {
                                input.value = item.maThietBi || '';
                                tenThietBiInput.value = item.tenThietBi || '';
                                resultBox.style.display = "none";
                            };
                            resultBox.appendChild(option);
                        });
                        resultBox.style.display = "block";
                    } else {
                         resultBox.innerHTML = "<div style='padding: 8px 12px; color: grey;'>Không tìm thấy kết quả.</div>";
                         resultBox.style.display = "block";
                    }

                } catch (error) {
                    console.error('Lỗi khi tìm kiếm thiết bị:', error);
                    resultBox.innerHTML = `<div style='padding: 8px 12px; color: red;'>Lỗi: ${error.message}</div>`;
                    resultBox.style.display = "block";
                }
            });

            document.addEventListener("click", function(e) {
                if (input && resultBox && !input.contains(e.target) && !resultBox.contains(e.target)) {
                    resultBox.style.display = "none";
                }
            });
        });
        </script>
        </main> </div> <?php
// Tải Footer
require_once 'app/views/layouts/footer.php';
?>