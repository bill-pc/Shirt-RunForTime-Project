// public/js/khsx.js

document.addEventListener("DOMContentLoaded", function () {


    const searchBox = document.getElementById("search-box");
    const resultsBody = document.getElementById("results-table-body");
    const modal = document.getElementById("order-modal");
    const closeModalBtn = document.getElementById("close-modal-btn");

    if (closeModalBtn) {
        closeModalBtn.addEventListener("click", function () {
            if (modal) modal.classList.remove("show");
        });

        if (modal) {
            modal.addEventListener("click", function (e) {
                if (e.target === modal) {
                    modal.classList.remove("show");
                }
            });
        }

        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" || e.key === "Esc") {
                if (modal && modal.classList.contains("show")) {
                    modal.classList.remove("show");
                }
            }
        });
    }


    if (searchBox && resultsBody) {
        searchBox.addEventListener("input", function () {
            const query = this.value;


            fetch(`index.php?page=ajax-tim-kiem&query=${query}`)
                .then(response => response.json())
                .then(data => {
                    buildTable(data);
                })
                .catch(error => {
                    console.error("Lỗi tìm kiếm:", error);
                    resultsBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Lỗi khi tìm kiếm...</td></tr>';
                });
        });
    }

    function buildTable(data) {
        resultsBody.innerHTML = '';
        if (data.length === 0) {
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


    if (resultsBody) {
        resultsBody.addEventListener("click", function (e) {
            const row = e.target.closest("tr.result-row");
            if (row) {
                const donHangId = row.dataset.id;
                openOrderModal(donHangId);
            }
        });
    }

    if (resultsBody) {
        resultsBody.addEventListener("click", function (e) {
            if (e.target && e.target.classList.contains('btn-chon')) {
                const donHangId = e.target.dataset.id;
                openOrderModal(donHangId);
            }
        });
    }

    function openOrderModal(id) {
        fetch(`index.php?page=ajax-get-chitiet&id=${id}`)
            .then(response => response.json())
            .then(donHang => {
                if (!donHang) {
                    alert("Không thể tải chi tiết đơn hàng.");
                    return;
                }

                document.getElementById("modal-maDonHang").value = donHang.maDonHang;
                document.getElementById("modal-maDonHang-display").innerText = donHang.maDonHang;
                document.getElementById("modal-tenDonHang").innerText = donHang.tenDonHang;
                document.getElementById("modal-tenSanPham").innerText = donHang.tenSanPham;

                document.getElementById("modal-trangThai").innerText = donHang.trangThai;
                document.getElementById("modal-ngayGiao").innerText = donHang.ngayGiao;


                const ngayBatDauInput = document.getElementById("ngay_bat_dau_kh");
                const ngayKetThucInput = document.getElementById("ngay_ket_thuc_kh");

                ngayKetThucInput.value = donHang.ngayGiao;
                ngayKetThucInput.readOnly = true;

                ngayBatDauInput.max = donHang.ngayGiao;
                ngayBatDauInput.value = '';

                // 3. HIỂN THỊ MODAL
                modal.classList.add("show");
            })
            .catch(error => console.error("Lỗi lấy chi tiết:", error));
    }
}); 