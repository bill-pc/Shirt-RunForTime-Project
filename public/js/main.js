document.addEventListener("DOMContentLoaded", function () {
    const btnMenu = document.getElementById("menuDanhMuc");
    const dropdown = document.getElementById("dropdownDanhMuc");
    const sidebarList = document.getElementById("sidebarList");

    // --- Dữ liệu và Link Map (Giữ nguyên) ---
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
        "Xem công việc": "index.php?page=xem-cong-viec",
        "Theo dõi tiến độ": "index.php?page=theo-doi-tien-do",
        "Yêu cầu cung cấp NVL": "index.php?page=tao-yeu-cau-nvl",
        "Yêu cầu kiểm tra chất lượng": "index.php?page=yeu-cau-kiem-tra",
        "Lịch làm việc": "index.php?page=lichlamviec",
        "Báo cáo sự cố": "index.php?page=baocaosuco"
        // ... thêm các link khác
    };
    

    // --- Kết thúc Dữ liệu ---


    /* === SỬA LỖI Ở ĐÂY === */

    // 1. Tạo hàm để điền nội dung sidebar
    function populateSidebar(sectionKey) {
        // Kiểm tra xem sidebarList có tồn tại không
        if (!sidebarList) {
            console.error("Không tìm thấy phần tử #sidebarList");
            return; 
        }

        const chucnang = danhMucData[sectionKey] || []; // Lấy danh sách chức năng
        
        sidebarList.innerHTML = chucnang
            .map(item => {
                const url = linkMap[item] || "#"; 
                return `<li><a href="${url}">${item}</a></li>`;
            })
            .join("");
    }

    // 2. Gọi hàm này NGAY KHI TRANG TẢI XONG
    //    Hãy chọn một mục mặc định, ví dụ 'xuong' hoặc 'congnhan'
    //    Bạn có thể lưu lựa chọn cuối cùng vào localStorage để nhớ lần sau
    const defaultSection = 'xuong'; // <-- CHỌN MỤC MẶC ĐỊNH Ở ĐÂY
    populateSidebar(defaultSection);

    /* === KẾT THÚC SỬA LỖI === */


    // --- Logic Dropdown (Giữ nguyên, chỉ gọi hàm populateSidebar) ---
    if (btnMenu && dropdown) { // Thêm kiểm tra null
        btnMenu.addEventListener("click", () => dropdown.classList.toggle("show"));

        dropdown.querySelectorAll("button[data-section]").forEach(btn => {
            btn.addEventListener("click", () => {
                const section = btn.dataset.section;
                
                // Gọi hàm để điền sidebar thay vì lặp code
                populateSidebar(section); 
                
                dropdown.classList.remove("show");
            });
        });

        // Đóng dropdown khi click ra ngoài
        document.addEventListener("click", e => {
            if (!btnMenu.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove("show");
            }
        });
    } else {
        console.warn("Không tìm thấy #menuDanhMuc hoặc #dropdownDanhMuc");
    }

});