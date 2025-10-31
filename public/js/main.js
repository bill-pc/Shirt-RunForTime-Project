document.addEventListener("DOMContentLoaded", function () {
    const btnMenu = document.getElementById("menuDanhMuc");
    const dropdown = document.getElementById("dropdownDanhMuc");
    const sidebarList = document.getElementById("sidebarList");

    const danhMucData = {
        tongquan: ["Đăng nhập", "Đăng xuất", "Thông tin cá nhân", "Báo cáo tổng hợp"],
        nhansu: ["Thêm nhân viên", "Xem nhân viên", "Xóa nhân viên", "Sửa nhân viên"],
        sanxuat: ["Tạo đơn hàng sản xuất", "Lập kế hoạch sản xuất", "Phê duyệt yêu các yêu cầu sản xuất"],
        khoNVL: ["Tạo yêu cầu nhập nguyên vật liệu", "Nhập kho nguyên vật liệu", "Xuất nguyên vật liệu", "Thống kê kho nguyên vật liệu"],
        xuong: ["Xem công việc", "Theo dõi tiến độ", "Yêu cầu cung cấp NVL", "Yêu cầu kiểm tra chất lượng"],
        qc: ["Cập nhật thành phẩm", "Báo cáo chất lượng"],
        khoTP: ["Nhập kho thành phẩm", "Xuất kho thành phẩm", "Thống kê kho thành phẩm"],
        congnhan: ["Lịch làm việc", "Báo cáo sự cố"]
    };

    const linkMap = {
        "Theo dõi tiến độ": "index.php?page=theo-doi-tien-do",
        "Yêu cầu cung cấp NVL": "index.php?page=tao-yeu-cau-nvl",
        "Yêu cầu kiểm tra chất lượng": "index.php?page=yeu-cau-kiem-tra",
        "Lịch làm việc": "index.php?page=lichlamviec",
        "Báo cáo sự cố": "index.php?page=baocaosuco",
        "Xem công việc": "index.php?page=xemcongviec",
        "Xóa nhân viên": "index.php?page=xoanhanvien&id",
        "Xem nhân viên": "index.php?page=xemnhanvien",
        "Thống kê kho nguyên vật liệu": "index.php?page=thongke-khonvl",
        "Xuất kho thành phẩm": "index.php?page=xuatthanhpham",
        "Thông tin cá nhân": "index.php?page=thong-tin-ca-nhan",
        "Xuất nguyên vật liệu": "index.php?page=xuat-kho-nvl",
        "Phê duyệt yêu các yêu cầu sản xuất": "index.php?page=phe-duyet-cac-yeu-cau",
    };

    function populateSidebar(sectionKey) {
        if (!sidebarList) return;
        const chucnang = danhMucData[sectionKey] || [];
        if (chucnang.length === 0) {
            sidebarList.innerHTML = `<li class="sidebar-alert">Chưa có chức năng nào trong mục này</li>`;
        } else {
            sidebarList.innerHTML = chucnang
                .map(item => {
                    const url = linkMap[item] || "#";
                    return `<li><a href="${url}">${item}</a></li>`;
                })
                .join("");
        }
        localStorage.setItem("lastSelectedSection", sectionKey);
    }

    // --- Kiểm tra trạng thái đăng nhập ---
    const currentPage = window.location.search;
    const isLoggedIn = localStorage.getItem("isLoggedIn") === "true";
    const isHomePage = currentPage === "" || currentPage === "?page=home";

    // --- Hiển thị sidebar mặc định ---
    if (!isLoggedIn) {
        localStorage.removeItem("lastSelectedSection");
        sidebarList.innerHTML = `<li class="sidebar-alert">⚠️ Hãy đăng nhập trước để sử dụng các chức năng</li>`;
    } else if (isHomePage) {
        sidebarList.innerHTML = `<li class="sidebar-alert">Vui lòng chọn danh mục ở trên</li>`;
    } else {
        const lastSection = localStorage.getItem("lastSelectedSection");
        if (lastSection) populateSidebar(lastSection);
    }

    // --- Dropdown ---
    if (btnMenu && dropdown) {
        btnMenu.addEventListener("click", () => {
            if (!isLoggedIn) {
                alert("Vui lòng đăng nhập để sử dụng danh mục chức năng!");
                return;
            }
            dropdown.classList.toggle("show");
        });

        dropdown.querySelectorAll("button[data-section]").forEach(btn => {
            btn.addEventListener("click", () => {
                if (!isLoggedIn) {
                    alert("Vui lòng đăng nhập để chọn chức năng!");
                    return;
                }
                const section = btn.dataset.section;
                populateSidebar(section);
                dropdown.classList.remove("show");
            });
        });

        document.addEventListener("click", e => {
            if (dropdown.classList.contains("show") &&
                !btnMenu.contains(e.target) &&
                !dropdown.contains(e.target)) {
                dropdown.classList.remove("show");
            }
        });
    }
});