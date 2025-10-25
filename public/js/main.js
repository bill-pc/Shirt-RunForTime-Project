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

        btnMenu.addEventListener("click", () => dropdown.classList.toggle("show"));

        dropdown.querySelectorAll("button[data-section]").forEach(btn => {
            btn.addEventListener("click", () => {
                const section = btn.dataset.section;
                const chucnang = danhMucData[section] || [];
                sidebarList.innerHTML = chucnang
                    .map(item => `<li><a href="#">${item}</a></li>`)
                    .join("");
                dropdown.classList.remove("show");
            });
        });

        document.addEventListener("click", e => {
            if (!btnMenu.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove("show");
            }
        });
        function loadDanhMucScript(section) {
    const scriptPath = `/public/js/${section}.js`;

    // Xóa các script cũ
    document.querySelectorAll("script[data-dynamic='true']").forEach(s => s.remove());

    // Tạo script mới
    const script = document.createElement("script");
    script.src = scriptPath;
    script.dataset.dynamic = "true";
    document.body.appendChild(script);
}

});
// 🧩 Khi click vào item trong sidebar (ví dụ: Báo cáo sự cố)
document.addEventListener("click", function (e) {
    const link = e.target.closest("a");
    if (!link) return;

    const text = link.textContent.trim();
    const content = document.querySelector(".content");

    if (text === "Báo cáo sự cố") {
        e.preventDefault();
        // Gọi Ajax để load nội dung form vào .content
        fetch("app/views/lapbaocaosuco.php")
            .then(res => res.text())
            .then(html => {
                content.innerHTML = html;
            })
            .catch(err => console.error("Lỗi tải form:", err));
    }

    if (text === "Lịch làm việc") {
        e.preventDefault();
        fetch("app/views/lichlamviec.php")
            .then(res => res.text())
            .then(html => {
                content.innerHTML = html;
            })
            .catch(err => console.error("Lỗi tải lịch:", err));
    }
});
