<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lập báo cáo lỗi và sự cố</title>
    <link rel="stylesheet" href="/Shirt-RunForTime-Project/public/css/style.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

    <style>
    body {
        background-color: #f4f6fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .report-form-container {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 32px 40px;
        max-width: 600px;
        margin: 50px auto;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        animation: fadeIn 0.3s ease;
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
    .file-upload {
        border: 2px dashed #b8c4d9;
        border-radius: 12px;
        padding: 80px;                   /* tăng padding để khung cao hơn */
        text-align: center;
        color: #555;
        margin-top: 10px;
        font-size: 15px;                 /* chữ lớn hơn chút */
        transition: all 0.2s ease;
        background-color: #f9fbff;       /* nền sáng nhẹ để tách khỏi form */
    }

    .file-upload:hover {
        border-color: #7da6f8;           /* đổi màu khi rê chuột */
        background-color: #f0f5ff;
    }


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
    }
    .search-results div {
        padding: 8px 12px;
        cursor: pointer;
    }
    .search-results div:hover {
        background-color: #eef4ff;
    }
    </style>
</head>
<body>
    <?php include 'layouts/header.php'; ?>
    <?php include 'layouts/nav.php'; ?>
            <div class="report-form-container">
                <h2>Lập báo cáo lỗi và sự cố</h2>
                <hr>

                <form action="#" method="POST" enctype="multipart/form-data" class="report-form">
                    <label for="ma_thiet_bi">Mã thiết bị</label>
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
                    <div class="file-upload">
                        <input type="file" id="hinh_anh" name="hinh_anh">
                    </div>

                    <div class="form-buttons">
                        <button type="button" class="cancel-btn" onclick="window.history.back()">Hủy</button>
                        <button type="submit" class="submit-btn">Gửi báo cáo</button>
                    </div>
                </form>
            </div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const input = document.getElementById("ma_thiet_bi");
    const resultBox = document.createElement("div");
    resultBox.className = "search-results";
    input.parentNode.appendChild(resultBox);

    input.addEventListener("input", async function() {
        const keyword = this.value.trim();
        if (keyword.length < 2) {
            resultBox.style.display = "none";
            return;
        }

        try {
            const res = await fetch(`/search_device.php?keyword=${encodeURIComponent(keyword)}`);
            const data = await res.json();

            resultBox.innerHTML = "";
            data.forEach(item => {
                const option = document.createElement("div");
                option.textContent = `${item.ma_thiet_bi} - ${item.ten_thiet_bi}`;
                option.onclick = function() {
                    input.value = item.ma_thiet_bi;
                    document.getElementById("ten_thiet_bi").value = item.ten_thiet_bi;
                    resultBox.style.display = "none";
                };
                resultBox.appendChild(option);
            });
            resultBox.style.display = data.length ? "block" : "none";
        } catch (e) {
            console.error(e);
        }
    });

    document.addEventListener("click", function(e) {
        if (!resultBox.contains(e.target) && e.target !== input) {
            resultBox.style.display = "none";
        }
    });
});
</script>


</body>
</html>
