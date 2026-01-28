<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));
$current_page = $segments[0] ?? 'admin';

// Giả định bạn lưu role vào session khi đăng nhập
$admin_role = $_SESSION['admin_role'] ?? 1;
?>

<style>
    .sidebar {
        width: 260px;
        background-color: #1a1d21;
        min-height: 100vh;
        color: #aeb7c1;
        transition: all 0.3s;
    }

    .sidebar-brand {
        padding: 20px 24px;
        display: block;
        text-decoration: none;
        color: white;
        font-weight: bold;
        font-size: 1.25rem;
        border-bottom: 1px solid #2d3238;
    }

    .sidebar-brand i {
        color: #009981;
    }

    .sidebar-menu {
        list-style: none;
        margin-top: 15px;
    }

    .sidebar-menu .nav-item {
        margin: 4px 12px;
    }

    .sidebar-menu .nav-link {
        color: #aeb7c1;
        padding: 12px 15px;
        display: flex;
        align-items: center;
        text-decoration: none;
        border-radius: 8px;
        transition: all 0.2s;
    }

    .sidebar-menu .nav-link i {
        margin-right: 12px;
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .sidebar-menu .nav-link.active {
        background-color: rgba(0, 153, 129, 0.15);
        color: #009981 !important;
        font-weight: 600;
    }

    .sidebar-menu .nav-link:hover:not(.active) {
        background-color: rgba(255, 255, 255, 0.05);
        color: white;
    }

    .logout-item {
        border-top: 1px solid #2d3238;
        margin-top: 20px !important;
        padding-top: 20px !important;
    }

    .role-badge-sidebar {
        font-size: 0.65rem;
        background: #2d3238;
        padding: 2px 6px;
        border-radius: 4px;
        margin-left: auto;
    }
</style>

<aside class="sidebar" id="sidebar">
    <a href="/admin/index" class="sidebar-brand">
        <i class="bi bi-shield-lock-fill me-2"></i> TechHub Shop
    </a>

    <ul class="sidebar-menu p-0">


        <?php if ($admin_role == 2): ?>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'admin' || $current_page == '' ? 'active' : '' ?>"
                href="/admin/index">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'product' ? 'active' : '' ?>" href="/product">
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
            <a class="nav-link <?= $current_page == 'coupon' ? 'active' : '' ?>" href="/coupon">
                <i class="bi bi-ticket"></i> Mã giảm giá
            </a>
        </li>
        
        <hr style="border-color: #2d3238; margin: 10px 20px;">

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'user' ? 'active' : '' ?>" href="/user">
                <i class="bi bi-people"></i> Khách hàng
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?= $current_page == 'adminmanage' ? 'active' : '' ?>" href="/adminmanage">
                <i class="bi bi-shield-check"></i> Quản trị viên
            </a>
        </li>

        <?php endif; ?>

        <li class="nav-item logout-item">
            <a class="nav-link text-danger" href="/auth/logout">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </a>
        </li>
    </ul>
</aside>
<?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/layout/components/admin/sidebar.blade.php ENDPATH**/ ?>