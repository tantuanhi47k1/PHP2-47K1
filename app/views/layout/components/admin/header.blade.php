<header class="top-header">
    <button class="btn btn-light d-lg-none" id="sidebarToggle">
        <i class="bi bi-list fs-4"></i>
    </button>

    <div class="d-none d-md-block fw-bold text-secondary">
        Quản trị hệ thống
    </div>

    <div class="d-flex align-items-center">
        <div class="dropdown">
            <button class="btn btn-outline-success btn-sm dropdown-toggle d-flex align-items-center gap-2"
                type="button" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle"></i> 
                <?= $_SESSION['admin_name'] ?? 'Quản trị viên' ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li><a class="dropdown-item" href="/user/profile"><i class="bi bi-person me-2"></i>Hồ sơ</a></li>
                <li><a class="dropdown-item" href="/settings"><i class="bi bi-gear me-2"></i>Cài đặt</a></li>
                <li><hr class="dropdown-divider"></li>
                
                <?php if(isset($_SESSION['admin_id'])): ?>
                    <li>
                        <a class="dropdown-item text-danger" href="/auth/logout">
                            <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a class="dropdown-item text-primary" href="/auth/adminLogin">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Đăng nhập Admin
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</header>