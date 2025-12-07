document.addEventListener("DOMContentLoaded", function() {
    const btnMenu = document.getElementById("menuDanhMuc");
    const dropdown = document.getElementById("dropdownDanhMuc");
    const sidebarList = document.getElementById("sidebarList");

    const danhMucData = {
        tongquan: ["Thông tin cá nhân", "Báo cáo tổng hợp", "Phê duyệt kế hoạch sản xuất"],
        nhansu: ["Thêm nhân viên", "Xem nhân viên", "Xóa nhân viên", "Sửa nhân viên"],
        sanxuat: ["Tạo đơn hàng sản xuất", "Lập kế hoạch sản xuất", "Phê duyệt các yêu cầu sản xuất"],
        khoNVL: ["Tạo yêu cầu nhập nguyên vật liệu", "Nhập kho nguyên vật liệu", "Xuất nguyên vật liệu", "Thống kê kho nguyên vật liệu"],
        xuong: ["Xem công việc", "Theo dõi tiến độ", "Yêu cầu cung cấp NVL", "Yêu cầu kiểm tra chất lượng"],
        qc: ["Cập nhật thành phẩm", "Báo cáo chất lượng"],
        khoTP: ["Nhập kho thành phẩm", "Xuất kho thành phẩm", "Thống kê kho thành phẩm"],
        congnhan: ["Lịch làm việc", "Báo cáo sự cố"]
    };

    const linkMap = {
        "Xem công việc": "index.php?page=xem-cong-viec",
        "Theo dõi tiến độ": "index.php?page=ghi-nhan-tp",
        "Báo cáo tổng hợp": "index.php?page=bao-cao-tong-hop",
        "Yêu cầu cung cấp NVL": "index.php?page=tao-yeu-cau-nvl",
        "Lịch làm việc": "index.php?page=lichlamviec",
        "Báo cáo sự cố": "index.php?page=baocaosuco",
        "Xem công việc": "index.php?page=xemcongviec",
        "Thêm nhân viên": "index.php?page=themnhanvien",
        "Xóa nhân viên": "index.php?page=xoanhanvien&id",
        "Xem nhân viên": "index.php?page=xemnhanvien",
        "Thống kê kho nguyên vật liệu": "index.php?page=thongke-khonvl",
        "Xuất kho thành phẩm": "index.php?page=xuatthanhpham",
        "Thông tin cá nhân": "index.php?page=thong-tin-ca-nhan",
        "Phê duyệt các yêu cầu sản xuất": "index.php?page=phe-duyet-cac-yeu-cau",
        "Xuất nguyên vật liệu": "index.php?page=xuat-kho-nvl",
        "Tạo yêu cầu nhập nguyên vật liệu": "index.php?page=tao-yeu-cau-nhap-kho",
        "Nhập kho nguyên vật liệu": "index.php?page=nhap-kho-nvl",
        "Yêu cầu kiểm tra chất lượng": "index.php?page=tao-yeu-cau-kiem-tra-chat-luong",
        "Phê duyệt kế hoạch sản xuất": "index.php?page=phe-duyet-ke-hoach-sx",
        "Sửa nhân viên": "index.php?page=suanhanvien",
        "Lập kế hoạch sản xuất": "index.php?page=lap-khsx",
        "Thống kê kho thành phẩm": "index.php?page=thongke",
        "Báo cáo chất lượng": "index.php?page=baocao-chatluong",
        "Tạo đơn hàng sản xuất": "index.php?page=tao-don-hang-san-xuat",
        "Cập nhật thành phẩm": "index.php?page=cap-nhat-thanh-pham",
        "Nhập kho thành phẩm": "index.php?page=nhap-kho-thanh-pham"

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