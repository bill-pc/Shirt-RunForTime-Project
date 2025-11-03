// public/js/khsx.js

document.addEventListener("DOMContentLoaded", function () {

    // --- LẤY CÁC PHẦN TỬ CẦN THIẾT ---
    const searchBox = document.getElementById("search-box");
    const resultsBody = document.getElementById("results-table-body");

    // Modal chính
    const modal = document.getElementById("order-modal");
    const closeModalBtn = document.getElementById("close-modal-btn");

    // Modal xác nhận thoát
    const confirmModal = document.getElementById("confirm-exit-modal");
    const btnStay = document.getElementById("confirm-exit-no");
    const btnExit = document.getElementById("confirm-exit-yes");

    // (MỚI) Biến toàn cục để lưu dữ liệu NVL và Sản Phẩm
    // Giúp không phải gọi AJAX mỗi khi nhấn "Thêm NVL"
    let globalData = {
        danhSachNVL: [],
        danhSachSanPham: []
    };


    // --- LOGIC TÌM KIẾM VÀ TẢI BẢNG ---

    // 1. Hàm gọi AJAX (Tìm kiếm hoặc tải mặc định)
    function fetchResults(query) {
        resultsBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Đang tải...</td></tr>';

        // Gọi Endpoint 1 (AJAX)
        // (Controller sẽ tự quyết định nên tìm kiếm hay lấy 5 cái mặc định)
        fetch(`index.php?page=ajax-tim-kiem&query=${query}`)
            .then(response => response.json())
            .then(data => {
                buildTable(data); // Xây dựng bảng kết quả
            })
            .catch(error => {
                console.error("Lỗi tìm kiếm:", error);
                resultsBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Lỗi khi tìm kiếm...</td></tr>';
            });
    }

    // 2. Hàm vẽ lại bảng kết quả
    function buildTable(data) {
        resultsBody.innerHTML = ''; // Xóa bảng cũ
        if (!data || data.length === 0) {
            resultsBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Không tìm thấy kết quả.</td></tr>';
            return;
        }

        data.forEach(item => {
            const row = `
                <tr>
                    <td>${item.maDonHang}</td>
                    <td>${item.tenDonHang}</td>
                    <td>${item.ngayGiao}</td>
                    <td>${item.trangThai}</td>
                    <td>
                        <button class="btn-chon" data-id="${item.maDonHang}">
                            Chọn
                        </button>
                    </td>
                </tr>
            `;
            resultsBody.innerHTML += row;
        });
    }

    // 3. Gắn sự kiện cho ô tìm kiếm
    if (searchBox) {
        searchBox.addEventListener("input", function() {
            fetchResults(this.value); 
        });
    }

    // 4. Tải 5 đơn hàng mặc định khi vào trang
    if (resultsBody) { 
        fetchResults(''); // Gọi với query rỗng
    }


    // --- LOGIC MODAL POP-UP ---

    // 5. Hàm gọi AJAX để lấy TOÀN BỘ dữ liệu cho Modal
    function openOrderModal(id) {
        
        // SỬA LỖI URL: Phải là 'ajax-get-modal-data'
        fetch(`index.php?page=ajax-get-modal-data&id=${id}`)
            .then(response => response.json())
            .then(data => {
                // Data trả về là 1 object lớn: { donHang: {...}, danhSachXuong: [...], ... }
                const donHang = data.donHang;

                if (!donHang) {
                    alert("Không thể tải chi tiết đơn hàng.");
                    return;
                }
                
                // (SỬA LỖI) Lưu dữ liệu vào biến toàn cục
                globalData.danhSachNVL = data.danhSachNVL || [];
                globalData.danhSachSanPham = data.danhSachSanPham || [];

                // 5a. Điền thông tin Đơn hàng
                document.getElementById("modal-maDonHang").value = donHang.maDonHang;
                document.getElementById("modal-maDonHang-display").innerText = donHang.maDonHang;
                document.getElementById("modal-tenDonHang").innerText = donHang.tenDonHang;
                document.getElementById("modal-tenSanPham").innerText = donHang.tenSanPham;
                document.getElementById("modal-donVi").innerText = donHang.donVi;
                document.getElementById("modal-ngayGiao").innerText = donHang.ngayGiao;

                // 5b. Điền Sản lượng trung bình
                document.getElementById("modal-sanLuongTB").innerText = data.sanLuongTB;

                // 5c. Điền logic Ngày tháng
                const ngayBatDauInput = document.getElementById("ngay_bat_dau_kh");
                const ngayKetThucInput = document.getElementById("ngay_ket_thuc_kh");
                ngayKetThucInput.value = donHang.ngayGiao;
                ngayKetThucInput.readOnly = true;
                ngayBatDauInput.max = donHang.ngayGiao;
                ngayBatDauInput.value = '';

                // 5d. Dọn dẹp form cũ (Xóa các danh sách NVL đã thêm)
                document.getElementById("xuong-cat-nvl-list").innerHTML = '';
                document.getElementById("xuong-may-nvl-list").innerHTML = '';
                
                // 5e. Điền dropdown Sản Phẩm cho cả 2 xưởng
                const productSelects = document.querySelectorAll(".product-select");
                productSelects.forEach(select => {
                    select.innerHTML = '<option value="">-- Chọn sản phẩm --</option>';
                    globalData.danhSachSanPham.forEach(sp => {
                        select.innerHTML += `<option value="${sp.maSanPham}">${sp.tenSanPham}</option>`;
                    });
                    // Tự động chọn sản phẩm của đơn hàng
                    select.value = donHang.maSanPham; 
                });

                // 5f. Tự động thêm 1 dòng NVL cho mỗi xưởng
                addNvlRow('xuong-cat-nvl-list', 'xuong_cat');
                addNvlRow('xuong-may-nvl-list', 'xuong_may');

                // 5g. Hiển thị Modal
                modal.classList.add("show");
            })
            .catch(error => {
                console.error("Lỗi lấy chi tiết:", error);
                // Lỗi JSON hay '404' đều sẽ bị bắt ở đây
                alert("Lỗi khi tải chi tiết. Vui lòng kiểm tra Console (F12) và file index.php.");
            });
    }

    // 6. Gắn sự kiện Mở Modal (Khi click nút "Chọn")
    if (resultsBody) {
        resultsBody.addEventListener("click", function (e) {
            // (SỬA LỖI) Chỉ bắt sự kiện click vào nút .btn-chon
            if (e.target && e.target.classList.contains('btn-chon')) {
                const donHangId = e.target.dataset.id;
                openOrderModal(donHangId);
            }
        });
    }

    // 7. Gắn sự kiện Đóng Modal (và logic Hộp xác nhận)
    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", function() {
            confirmModal.classList.add("show");
        });
    }
    if (modal) {
        modal.addEventListener("click", function(e) {
            if (e.target === modal) { 
                confirmModal.classList.add("show");
            }
        });
    }
    if (btnStay) {
        btnStay.addEventListener("click", function() {
            confirmModal.classList.remove("show");
        });
    }
    if (btnExit) {
        btnExit.addEventListener("click", function() {
            confirmModal.classList.remove("show");
            modal.classList.remove("show");
        });
    }


    // --- LOGIC THÊM/XÓA NVL ĐỘNG ---

    // 8. Hàm tạo HTML cho 1 dòng NVL
    function createNvlRowHTML(formNamePrefix) {
        let nvlOptions = '<option value="">-- Chọn NVL --</option>';
        globalData.danhSachNVL.forEach(nvl => {
            nvlOptions += `<option value="${nvl.maNVL}">${nvl.tenNVL} (${nvl.donViTinh})</option>`;
        });

        // Tên (name) của input phải là mảng (vd: "xuong_cat[nvl_id][]")
        return `
            <div class="nvl-row">
                <select name="${formNamePrefix}[nvl_id][]" required>
                    ${nvlOptions}
                </select>
                <input type="number" name="${formNamePrefix}[nvl_soLuong][]" placeholder="SL" min="1" required>
                <button type="button" class="btn-remove-nvl">&times;</button>
            </div>
        `;
    }

    // 9. Hàm thêm 1 dòng NVL vào danh sách
    function addNvlRow(targetListId, formNamePrefix) {
        const targetList = document.getElementById(targetListId);
        const rowHTML = createNvlRowHTML(formNamePrefix);
        targetList.insertAdjacentHTML('beforeend', rowHTML);
    }

    // 10. Gắn sự kiện click chung cho các nút THÊM / XÓA (bên trong modal)
    if (modal) {
        modal.addEventListener('click', function(e) {
            // Nếu click nút "+ Thêm NVL"
            if (e.target && e.target.classList.contains('btn-add-nvl')) {
                const targetListId = e.target.dataset.target;
                const formNamePrefix = (targetListId === 'xuong-cat-nvl-list') ? 'xuong_cat' : 'xuong_may';
                addNvlRow(targetListId, formNamePrefix);
            }

            // Nếu click nút "Xóa" (nút X đỏ)
            if (e.target && e.target.classList.contains('btn-remove-nvl')) {
                e.target.closest('.nvl-row').remove();
            }
        });
    }

}); 
