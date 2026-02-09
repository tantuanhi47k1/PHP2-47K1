<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));
$current_page = $segments[0] ?? 'admin';

// Lấy role từ session
$admin_role = $_SESSION['admin_role'] ?? 1;
?>

<style>
    .sidebar {
        width: 260px;
        background-color: #1a1d21;
        min-height: 100vh;
        color: #aeb7c1;
        transition: all 0.3s;
        border-right: 1px solid #2d3238;
        display: flex;
        flex-direction: column;
    }

    .brand-container {
        padding: 10px 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #15181c;
        border-bottom: 1px solid #2d3238;
    }

    .sidebar-brand {
        display: block;
        text-decoration: none;
        transition: transform 0.3s ease;
    }

    .sidebar-brand:hover {
        transform: scale(1.05);
    }

    .sidebar-brand img {
        width: 200px !important; 
        height: auto !important;
        object-fit: contain;
        filter: drop-shadow(0px 4px 10px rgba(99, 102, 241, 0.2));
    }

    .brand-container h3 {
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 800;
        margin-top: 15px;
        margin-bottom: 0;
        letter-spacing: 2px;
        text-transform: uppercase;
        text-align: center;
    }

    .brand-container h3::after {
        content: '';
        display: block;
        width: 35px;
        height: 2px;
        background: #6366f1;
        margin: 10px auto 0;
        border-radius: 2px;
    }

    .sidebar-menu {
        list-style: none;
        margin-top: 20px;
        padding-left: 0;
        flex-grow: 1;
    }

    .sidebar-menu .nav-item {
        margin: 4px 12px;
    }

    .sidebar-menu .nav-link {
        color: #94a3b8;
        padding: 12px 15px;
        display: flex;
        align-items: center;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s;
        font-size: 0.95rem;
    }

    .sidebar-menu .nav-link i {
        margin-right: 12px;
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
        color: #64748b;
        transition: 0.2s;
    }

    .sidebar-menu .nav-link.active {
        background: linear-gradient(90deg, rgba(99, 102, 241, 0.15) 0%, rgba(99, 102, 241, 0.05) 100%);
        color: #818cf8 !important;
        font-weight: 600;
        border-left: 3px solid #6366f1;
    }

    .sidebar-menu .nav-link.active i {
        color: #818cf8;
    }

    .sidebar-menu .nav-link:hover:not(.active) {
        background-color: rgba(255, 255, 255, 0.05);
        color: #e2e8f0;
    }

    .logout-item {
        border-top: 1px solid #2d3238;
        margin-top: auto !important;
        padding: 20px 12px;
    }
</style>

<aside class="sidebar" id="sidebar">
    <div class="brand-container">
        <a href="/" class="sidebar-brand">
            <img src="/image/logo_techhub1.png" alt="Logo">
        </a>
        <h3>TECHHUB ADMIN</h3>
    </div>

    <ul class="sidebar-menu">
        <?php if ($admin_role == 2): ?>
        <li class="nav-item">
            <a class="nav-link <?= ($current_page == 'admin' || $current_page == '') ? 'active' : '' ?>"
                href="/admin/index">
                <i class="bi bi-speedometer2"></i> Tổng quan
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'product' ? 'active' : '' ?>" href="/product/manage">
                <i class="bi bi-box-seam"></i> Sản phẩm
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'category' ? 'active' : '' ?>" href="/category">
                <i class="bi bi-tags"></i> Danh mục
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'brand' ? 'active' : '' ?>" href="/brand">
                <i class="bi bi-star"></i> Thương hiệu
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'attribute' ? 'active' : '' ?>" href="/attribute">
                <i class="bi bi-grid-3x3-gap"></i> Biến Thể
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'coupon' ? 'active' : '' ?>" href="/coupon">
                <i class="bi bi-ticket-perforated"></i> Mã giảm giá
            </a>
        </li>

        <li class="nav-item mt-3 mb-2 px-3">
            <small class="text-uppercase text-white fw-bold" style="font-size: 11px; letter-spacing: 1px;">Người dùng</small>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'user' ? 'active' : '' ?>" href="/user">
                <i class="bi bi-people"></i> Khách hàng
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'adminmanage' ? 'active' : '' ?>" href="/adminmanage">
                <i class="bi bi-person-badge"></i> Quản trị viên
            </a>
        </li>
        <?php endif; ?>
    </ul>

    <div class="logout-item">
        <a class="nav-link text-danger bg-danger bg-opacity-10 justify-content-center fw-bold" href="/auth/logout">
            <i class="bi bi-box-arrow-right text-danger"></i> Đăng xuất
        </a>
    </div>
</aside><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/layout/components/admin/sidebar.blade.php ENDPATH**/ ?>