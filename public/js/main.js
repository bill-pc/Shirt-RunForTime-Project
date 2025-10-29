document.addEventListener("DOMContentLoaded", function () {
    const btnMenu = document.getElementById("menuDanhMuc");
    const dropdown = document.getElementById("dropdownDanhMuc");
    const sidebarList = document.getElementById("sidebarList");

    const danhMucData = {
        tongquan: ["Đăng nhập", "Đăng xuất", "Thông tin cá nhân", "Báo cáo tổng hợp"],
        nhansu: ["Thêm nhân viên", "Xem nhân viên", "Xóa nhân viên", "Sửa nhân viên"],
        sanxuat: ["Tạo đơn hàng sản xuất", "Lập kế hoạch sản xuất", "Duyệt kế hoạch sản xuất"],
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
    };

    function populateSidebar(sectionKey) {
        if (!sidebarList) return;
        sidebarList.innerHTML = "";
        const chucnang = danhMucData[sectionKey];
        if (!chucnang) return;
        sidebarList.innerHTML = chucnang
            .map(item => {
                const url = linkMap[item] || "#";
                return `<li><a href="${url}">${item}</a></li>`;
            })
            .join("");
    }

    // Nếu người dùng đã chọn trước đó → load lại
    const currentSection = localStorage.getItem("currentSection");
    if (currentSection) {
        populateSidebar(currentSection);
    } else {
        sidebarList.innerHTML = ""; // không hiển thị gì lúc đầu
    }

    if (btnMenu && dropdown) {
        btnMenu.addEventListener("click", () => dropdown.classList.toggle("show"));

        dropdown.querySelectorAll("button[data-section]").forEach(btn => {
            btn.addEventListener("click", () => {
                const section = btn.dataset.section;
                populateSidebar(section);
                localStorage.setItem("currentSection", section);
                dropdown.classList.remove("show");
            });
        });

        document.addEventListener("click", e => {
            if (!btnMenu.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove("show");
            }
        });
    }
});
