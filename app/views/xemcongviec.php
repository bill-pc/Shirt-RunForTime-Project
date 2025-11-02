<?php
// Nạp layout chung (header + nav)
require_once 'app/views/layouts/header.php';
require_once 'app/views/layouts/nav.php';
?>

<div class="main-layout-wrapper">

    <?php
    // Sidebar bên trái
    require_once 'app/views/layouts/sidebar.php';
    ?>

    <main class="main-content">

        <div class="task-container">

            <h2>Danh sách công việc</h2>

            <div class="filter-bar">
                <input type="text" id="search" placeholder="Tìm theo tiêu đề hoặc mô tả...">
                <select id="statusFilter">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Đang thực hiện">Đang thực hiện</option>
                    <option value="Hoàn thành">Hoàn thành</option>
                    <option value="Chưa bắt đầu">Chưa bắt đầu</option>
                </select>
                <button onclick="filterTasks()">Lọc</button>
                <button onclick="xuatCSV()" class="btn-csv">Xuất CSV</button>
            </div>

            <table id="taskTable">
                <thead>
                    <tr>
                        <th>Mã CV</th>
                        <th>Tiêu đề</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th>Ngày hết hạn</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data)): ?>
                        <?php foreach ($data as $cv): ?>
                            <tr>
                                <td><?= htmlspecialchars($cv['maCongViec']) ?></td>
                                <td><?= htmlspecialchars($cv['tieuDe']) ?></td>
                                <td><?= htmlspecialchars($cv['moTa'] ?? '') ?></td>
                                <td><?= htmlspecialchars($cv['trangThai']) ?></td>
                                <td><?= htmlspecialchars($cv['ngayHetHan']) ?></td>
                                <td>
                                    <a href="index.php?page=xoa-congviec&id=<?= $cv['maCongViec'] ?>" 
                                        class="btn-delete" 
                                        onclick="return confirm('Xóa công việc này?')">🗑️</a>
                                    <button onclick="suaCongViec(<?= $cv['maCongViec'] ?>)" 
                                            class="btn-edit">✏️</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" style="text-align:center;">Không có công việc nào</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <script>
        function filterTasks() {
            const keyword = document.getElementById('search').value.toLowerCase();
            const status = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('#taskTable tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const match = text.includes(keyword) && (status === '' || row.cells[3].textContent === status);
                row.style.display = match ? '' : 'none';
            });
        }

        function xuatCSV() {
            window.location.href = "index.php?page=xuat-csv";
        }

        function suaCongViec(id) {
            alert("Chức năng sửa (demo): ID công việc " + id);
        }
        </script>

        <style>
        /* --- Bố cục tổng thể --- */
        .main-layout-wrapper {
            display: flex;
            min-height: 100vh;
            background: #f4f6f9;
        }

        .sidebar {
            width: 240px;
            background: #1e293b;
            color: white;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            padding: 20px 10px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.2);
        }

        .main-content {
            margin-left: 10px;
            flex: 1;
            padding: 30px;
            background: #f4f6f9;
            min-height: 100vh;
            overflow: auto;
        }

        /* --- Giao diện danh sách công việc --- */
        .task-container {
            padding: 24px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin: 20px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .task-container h2 {
            margin-bottom: 20px;
            color: #2b2b2b;
            font-size: 22px;
            border-left: 6px solid #007bff;
            padding-left: 10px;
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            align-items: center;
        }

        .filter-bar input,
        .filter-bar select {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            font-size: 14px;
            transition: 0.2s;
        }

        .filter-bar input:focus,
        .filter-bar select:focus {
            border-color: #007bff;
            box-shadow: 0 0 4px rgba(0, 123, 255, 0.4);
        }

        .filter-bar button {
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s, transform 0.1s;
        }

        .filter-bar button:hover {
            transform: translateY(-1px);
        }

        .filter-bar button:nth-child(3) {
            background: #007bff;
            color: white;
        }

        .btn-csv {
            background: #28a745;
            color: white;
        }

        .btn-csv:hover {
            background: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 10px;
        }

        thead th {
            background: #007bff;
            color: #fff;
            text-align: left;
            padding: 10px 12px;
            font-size: 14px;
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:nth-child(even) {
            background: #f9f9f9;
        }

        tbody tr:hover {
            background: #eaf4ff;
        }

        td {
            padding: 10px 12px;
            border-top: 1px solid #ddd;
            font-size: 14px;
            color: #333;
        }

        .btn-delete,
        .btn-edit {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-delete {
            background: #ff4d4f;
            color: #fff;
            border: none;
        }

        .btn-edit {
            background: #ffc107;
            color: #000;
            border: none;
            margin-left: 5px;
        }

        .btn-delete:hover {
            background: #e63b3d;
        }

        .btn-edit:hover {
            background: #e0a800;
        }

        .btn-delete:active,
        .btn-edit:active {
            transform: scale(0.95);
        }
        </style>

    </main>
</div>

<?php
// Footer
require_once 'app/views/layouts/footer.php';
?>
