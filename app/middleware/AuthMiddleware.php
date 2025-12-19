<?php
/**
 * AuthMiddleware - Kiểm tra phân quyền truy cập
 * Mỗi vai trò chỉ được thực hiện các chức năng được phép
 */

class AuthMiddleware {
    
    /**
     * Mapping từ route sang thông tin menu
     * Format: 'route' => ['icon' => '...', 'text' => '...', 'order' => số thứ tự]
     */
    private static $routeMenuMap = [
        'home' => ['icon' => 'fa-home', 'text' => 'Trang chủ', 'order' => 1],
        'thong-tin-ca-nhan' => ['icon' => 'fa-user', 'text' => 'Thông tin cá nhân', 'order' => 99],
        'profile' => ['icon' => 'fa-user', 'text' => 'Thông tin cá nhân', 'order' => 99],
        
        // Giám đốc
        'phe-duyet-ke-hoach-sx' => ['icon' => 'fa-check-circle', 'text' => 'Phê duyệt KHSX', 'order' => 10],
        'lap-bao-cao' => ['icon' => 'fa-chart-bar', 'text' => 'Xem báo cáo', 'order' => 20],
        'xem-bao-cao' => ['icon' => 'fa-chart-bar', 'text' => 'Xem báo cáo', 'order' => 20],
        
        // Quản lý nhân sự
        'themnhanvien' => ['icon' => 'fa-user-plus', 'text' => 'Thêm nhân viên', 'order' => 10],
        'xemnhanvien' => ['icon' => 'fa-users', 'text' => 'Xem nhân viên', 'order' => 11],
        'suanhanvien' => ['icon' => 'fa-user-edit', 'text' => 'Sửa nhân viên', 'order' => 12],
        'xoanhanvien' => ['icon' => 'fa-user-times', 'text' => 'Xóa nhân viên', 'order' => 13],
        
        // Quản lý sản xuất
        'tao-don-hang-san-xuat' => ['icon' => 'fa-cart-plus', 'text' => 'Tạo đơn hàng SX', 'order' => 10],
        'lap-ke-hoach' => ['icon' => 'fa-calendar-alt', 'text' => 'Lập kế hoạch SX', 'order' => 11],
        'phe-duyet-cac-yeu-cau' => ['icon' => 'fa-check-circle', 'text' => 'Phê duyệt yêu cầu', 'order' => 12],
        
        // Quản lý kho NVL
        'tao-yeu-cau-nhap-kho' => ['icon' => 'fa-file-import', 'text' => 'Tạo yêu cầu nhập NVL', 'order' => 10],
        'nhap-kho-nvl' => ['icon' => 'fa-download', 'text' => 'Nhập kho NVL', 'order' => 11],
        'xuat-kho-nvl' => ['icon' => 'fa-upload', 'text' => 'Xuất kho NVL', 'order' => 12],
        'thongke-khonvl' => ['icon' => 'fa-chart-line', 'text' => 'Thống kê kho NVL', 'order' => 13],
        
        // Quản lý xưởng
        'xemcongviec' => ['icon' => 'fa-tasks', 'text' => 'Xem công việc', 'order' => 10],
        'tao-yeu-cau-nvl' => ['icon' => 'fa-clipboard-list', 'text' => 'Yêu cầu cung cấp NVL', 'order' => 11],
        'tao-yeu-cau-kiem-tra-chat-luong' => ['icon' => 'fa-clipboard-check', 'text' => 'Yêu cầu kiểm tra QC', 'order' => 12],
        
        // Nhân viên QC
        'nhap-kho-tp-da-check-qc' => ['icon' => 'fa-check-square', 'text' => 'Nhập kho TP (đã QC)', 'order' => 10],
        
        // Quản lý kho TP
        'xuatthanhpham' => ['icon' => 'fa-truck', 'text' => 'Xuất thành phẩm', 'order' => 11],
        'thongke_sanpham' => ['icon' => 'fa-chart-pie', 'text' => 'Thống kê kho TP', 'order' => 12],
        
        // Công nhân
        'xem-lich-lam-viec' => ['icon' => 'fa-calendar', 'text' => 'Xem lịch làm việc', 'order' => 10],
        'calamviec' => ['icon' => 'fa-calendar', 'text' => 'Xem lịch làm việc', 'order' => 10],
        'baocaosuco' => ['icon' => 'fa-exclamation-triangle', 'text' => 'Báo cáo sự cố', 'order' => 11],
    ];
    
    /**
     * Danh sách quyền theo vai trò
     * Format: 'vai_tro' => ['page1', 'page2', ...]
     */
    private static $permissions = [
        'Giám đốc' => [
            'home',
            'thong-tin-ca-nhan',
            'profile',
            'bao-cao-tong-hop',
            'phe-duyet-ke-hoach-sx',
            'phe-duyet-ke-hoach-sx-process',
            'ajax-get-approval-history',
            'ajax-get-plan-detail',
            'lap-bao-cao',
            'xem-bao-cao',
            'logout'
        ],
        
        'Quản lý nhân sự' => [
            'home',
            'thong-tin-ca-nhan',
            'profile',
            'themnhanvien',
            'xemnhanvien',
            'suanhanvien',
            'suathongtinnv',
            'capnhatnv',
            'xoanhanvien',
            'timkiem-nhanvien',
            'xacnhan-xoa-nhanvien',
            'logout'
        ],
        
        'Quản lý sản xuất' => [
            'home',
            'thong-tin-ca-nhan',
            'profile',
            'tao-don-hang-san-xuat',
            'luu-don-hang-san-xuat',
            'lap-ke-hoach',
            'luu-ke-hoach',
            'ajax-tim-kiem',
            'ajax-get-modal-data',
            'chitietkhxs',
            'phe-duyet-cac-yeu-cau',
            'chi-tiet-phe-duyet-yeu-cau',
            'duyet-phieu',
            'tuchoi-phieu',
            'phe-duyet-ke-hoach-sx',
            'phe-duyet-ke-hoach-sx-process',
            'ajax-get-approval-history',
            'ajax-get-plan-detail',
            'logout'
        ],
        
        'Quản lý kho NVL' => [
            'home',
            'thong-tin-ca-nhan',
            'profile',
            'tao-yeu-cau-nhap-kho',
            'tao-yeu-cau-nhap-nguyen-vat-lieu',
            'chi-tiet-yeu-cau-nhap-kho',
            'luu-phieu-nhap-kho',
            'nhap-kho-nvl',
            'ajax-get-details-nhapkho',
            'luu-phieu-nhap-nvl',
            'xuat-kho-nvl',
            'chi-tiet-xuat-kho',
            'luu-phieu-xuat-kho',
            'thongke-khonvl',
            'thongke-nvl-xuatcsv',
            'logout'
        ],
        
        'Quản lý xưởng' => [
            'home',
            'thong-tin-ca-nhan',
            'profile',
            'xemcongviec',
            'chitietkhxs',
            'tao-yeu-cau-nvl',
            'chi-tiet-yeu-cau',
            'luu-yeu-cau-nvl',
            'tao-yeu-cau-kiem-tra-chat-luong',
            'tao-yeu-cau-kiem-tra-chat-luong-create',
            'tao-yeu-cau-kiem-tra-chat-luong-process',
            'logout'
        ],
        
        'Nhân viên QC' => [
            'home',
            'thong-tin-ca-nhan',
            'profile',
            'nhap-kho-tp-da-check-qc',
            'luu-nhap-kho-tp-da-check-qc',
            'lap-bao-cao',
            'logout'
        ],
        
        'Quản lý kho TP' => [
            'home',
            'thong-tin-ca-nhan',
            'profile',
            'nhap-kho-tp-da-check-qc',
            'luu-nhap-kho-tp-da-check-qc',
            'xuatthanhpham',
            'xuatthanhpham_xuat',
            'thongke_sanpham',
            'thongke',
            'export_thongke',
            'logout'
        ],
        
        'Công nhân' => [
            'home',
            'thong-tin-ca-nhan',
            'profile',
            'calamviec',
            'xem-lich-lam-viec',
            'lichlamviec',
            'baocaosuco',
            'luu-baocaosuco',
            'logout'
        ]
    ];

    /**
     * Kiểm tra người dùng đã đăng nhập chưa
     */
    public static function checkLogin() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit();
        }
    }

    /**
     * Kiểm tra quyền truy cập trang
     * @param string $page Tên trang đang truy cập
     * @return bool
     */
    public static function checkPermission($page) {
        self::checkLogin();
        
        // Lấy vai trò từ session
        $vaiTro = $_SESSION['user']['vaiTro'] ?? 'Công nhân';
        
        // Kiểm tra vai trò có trong danh sách không
        if (!isset(self::$permissions[$vaiTro])) {
            return false;
        }
        
        // Kiểm tra trang có trong quyền của vai trò không
        return in_array($page, self::$permissions[$vaiTro]);
    }
    
    /**
     * Lấy danh sách menu cho vai trò hiện tại
     * @return array Danh sách menu items đã sắp xếp
     */
    public static function getMenuForCurrentRole() {
        // Không gọi checkLogin() để tránh redirect loop khi include sidebar
        if (!isset($_SESSION['user'])) {
            return []; // Trả về menu rỗng nếu chưa login
        }
        
        $vaiTro = $_SESSION['user']['vaiTro'] ?? 'Công nhân';
        
        // Lấy danh sách quyền của vai trò
        $allowedPages = self::$permissions[$vaiTro] ?? [];
        
        // Tạo menu từ các quyền
        $menu = [];
        foreach ($allowedPages as $page) {
            // Bỏ qua các route không cần hiển thị trên menu
            $skipRoutes = ['logout', 'ajax-', 'luu-', 'capnhat', 'xacnhan-', 'timkiem-', 'process'];
            $shouldSkip = false;
            foreach ($skipRoutes as $skip) {
                if (strpos($page, $skip) !== false) {
                    $shouldSkip = true;
                    break;
                }
            }
            if ($shouldSkip) continue;
            
            // Nếu có mapping cho route này
            if (isset(self::$routeMenuMap[$page])) {
                $menu[] = [
                    'link' => $page,
                    'icon' => self::$routeMenuMap[$page]['icon'],
                    'text' => self::$routeMenuMap[$page]['text'],
                    'order' => self::$routeMenuMap[$page]['order']
                ];
            }
        }
        
        // Loại bỏ trùng lặp (cùng text)
        $uniqueMenu = [];
        $seenTexts = [];
        foreach ($menu as $item) {
            if (!in_array($item['text'], $seenTexts)) {
                $uniqueMenu[] = $item;
                $seenTexts[] = $item['text'];
            }
        }
        
        // Sắp xếp theo thứ tự
        usort($uniqueMenu, function($a, $b) {
            return $a['order'] - $b['order'];
        });
        
        return $uniqueMenu;
    }

    /**
     * Chặn truy cập nếu không có quyền
     * @param string $page Tên trang đang truy cập
     */
    public static function requirePermission($page) {
        if (!self::checkPermission($page)) {
            $vaiTro = $_SESSION['user']['vaiTro'] ?? 'Không xác định';
            echo "<script>
                alert('⛔ BẠN KHÔNG CÓ QUYỀN TRUY CẬP CHỨC NĂNG NÀY!\\n\\nVai trò của bạn: {$vaiTro}');
                window.location.href = 'index.php?page=home';
            </script>";
            exit();
        }
    }

    /**
     * Kiểm tra vai trò cụ thể
     * @param string|array $roles Vai trò cần kiểm tra (string hoặc array)
     * @return bool
     */
    public static function hasRole($roles) {
        self::checkLogin();
        
        $userRole = $_SESSION['user']['vaiTro'] ?? '';
        
        if (is_array($roles)) {
            return in_array($userRole, $roles);
        }
        
        return $userRole === $roles;
    }

    /**
     * Lấy danh sách quyền của vai trò hiện tại
     * @return array
     */
    public static function getCurrentPermissions() {
        self::checkLogin();
        
        $vaiTro = $_SESSION['user']['vaiTro'] ?? 'Công nhân';
        
        return self::$permissions[$vaiTro] ?? [];
    }

    /**
     * Kiểm tra có phải admin (Giám đốc hoặc Quản lý sản xuất)
     * @return bool
     */
    public static function isAdmin() {
        return self::hasRole(['Giám đốc', 'Quản lý sản xuất']);
    }
}
