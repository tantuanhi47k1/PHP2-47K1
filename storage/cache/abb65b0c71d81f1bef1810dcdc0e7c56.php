<header>
    <style>
        .navbar-brand { letter-spacing: 0.5px; }

        .nav-link { transition: all 0.2s ease; font-size: 0.95rem; font-weight: 500; }
        .nav-link:hover, .nav-link.active { color: #0d6efd !important; }

        .dropdown-menu { border-radius: 0.5rem; margin-top: 12px !important; border: none; }
        .dropdown-item { padding: 8px 20px; font-size: 0.9rem; transition: all 0.2s; }
        .dropdown-item:hover { background-color: #f0f7ff; color: #0d6efd; padding-left: 24px; }

        .badge-cart { font-size: 0.6rem; padding: 0.35em 0.5em; top: 5px; right: 5px; }

        .btn-auth { font-weight: 600; font-size: 0.85rem; letter-spacing: 0.3px; transition: all 0.3s; }
        .btn-auth:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2); }
    </style>

    <div class="bg-primary text-white py-2 small d-none d-lg-block">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="bi bi-envelope-fill me-2 opacity-75"></i> support@myshop.com
                <span class="mx-3 opacity-50">|</span>
                <i class="bi bi-telephone-fill me-2 opacity-75"></i> 1900 7799
            </div>
            <div>
                <a href="#" class="text-white text-decoration-none me-4 opacity-75 hover-opacity-100">
                    <i class="bi bi-question-circle me-1"></i> Trợ giúp
                </a>
                <a href="#" class="text-white text-decoration-none me-4 opacity-75 hover-opacity-100">
                    <i class="bi bi-truck me-1"></i> Tra cứu đơn hàng
                </a>
                <a href="/admin" class="text-white text-decoration-none opacity-75 hover-opacity-100">
                    <i class="bi bi-shop me-1"></i> Kênh người bán
                </a>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-3 d-flex align-items-center" href="/">
                <i class="bi bi-bag-heart-fill me-2"></i> TECHHUB SHOP
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">

                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 text-uppercase">
                    <li class="nav-item me-2">
                        <a class="nav-link active" href="/">Trang chủ</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="/product">Sản phẩm</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="#">Giới thiệu</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item me-3 d-none d-lg-block">
                        <a class="nav-link text-dark rounded-circle p-2 hover-bg-light" href="#">
                            <i class="bi bi-search fs-5"></i>
                        </a>
                    </li>

                    <li class="nav-item me-4 position-relative">
                        <a class="nav-link text-dark p-2" href="/cart">
                            <i class="bi bi-handbag fs-4"></i>
                            <span class="position-absolute badge rounded-pill bg-danger badge-cart border border-2 border-white">
                                <?php echo e(isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0); ?>

                            </span>
                        </a>
                    </li>

                    <li class="border-end mx-2 h-50 d-none d-lg-block" style="min-height: 24px; border-color: #eee !important;"></li>

                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown ms-2">
                            <a class="nav-link dropdown-toggle text-dark d-flex align-items-center ps-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($_SESSION['user_name'])); ?>&background=0d6efd&color=fff&size=128" 
                                     class="rounded-circle border border-2 border-white shadow-sm me-2" width="38" height="38" alt="Avatar">
                                <span class="fw-bold d-none d-lg-inline-block"><?php echo e($_SESSION['user_name']); ?></span>
                            </a>
                            
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg animate slideIn">
                                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                                    <li>
                                        <a class="dropdown-item text-primary fw-bold" href="/admin/index">
                                            <i class="bi bi-speedometer2 me-2"></i> Trang quản trị
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider my-2"></li>
                                <?php endif; ?>
                                
                                <li><a class="dropdown-item" href="/profile"><i class="bi bi-person-gear me-2 text-muted"></i> Hồ sơ cá nhân</a></li>
                                <li><a class="dropdown-item" href="/orders"><i class="bi bi-box-seam me-2 text-muted"></i> Đơn mua của tôi</a></li>
                                <li><hr class="dropdown-divider my-2"></li>
                                <li>
                                    <a class="dropdown-item text-danger fw-semibold" href="/auth/logout">
                                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item ms-lg-3 d-flex align-items-center gap-2">
                            <a class="btn btn-outline-primary btn-auth rounded-pill px-4 py-2" href="/auth/login">Đăng nhập</a>
                            <a class="btn btn-primary btn-auth rounded-pill px-4 py-2 text-white shadow-sm" href="/auth/register">Đăng ký</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
</header><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/layout/components/client/header.blade.php ENDPATH**/ ?>