<header>
    
    <div class="bg-dark text-white py-1 small d-none d-lg-block">
        <div class="container d-flex justify-content-between">
            <div>
                <i class="bi bi-envelope me-1"></i> support@myshop.com
                <span class="mx-2">|</span>
                <i class="bi bi-telephone me-1"></i> 1900 1234
            </div>
            <div>
                <a href="#" class="text-white text-decoration-none me-3">Trợ giúp</a>
                <a href="#" class="text-white text-decoration-none">Theo dõi đơn hàng</a>
                <a href="/admin" class="text-white text-decoration-none">Quản trị</a>
            </div>
        </div>
    </div>

    
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            
            <a class="navbar-brand fw-bold text-primary fs-3" href="/">
                <i class="bi bi-shop me-1"></i> MY SHOP
            </a>

            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            
            <div class="collapse navbar-collapse" id="navbarContent">
                
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/product">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                </ul>

                
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    
                    <li class="nav-item me-3">
                        <a class="nav-link text-dark" href="#"><i class="bi bi-search fs-5"></i></a>
                    </li>

                    
                    <li class="nav-item me-4 position-relative">
                        <a class="nav-link text-dark" href="/cart">
                            <i class="bi bi-bag fs-5"></i>
                            
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                <?php echo e(isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0); ?>

                            </span>
                        </a>
                    </li>

                    
                    <li class="border-end mx-2 h-50 d-none d-lg-block"></li>

                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($_SESSION['user_name'])); ?>&background=random" 
                                     class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                                <span><?php echo e($_SESSION['user_name']); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                
                                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 1): ?>
                                    <li>
                                        <a class="dropdown-item text-primary fw-bold" href="/product/manage">
                                            <i class="bi bi-speedometer2 me-2"></i> Trang quản trị
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                
                                <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i> Hồ sơ cá nhân</a></li>
                                <li><a class="dropdown-item" href="/orders"><i class="bi bi-box-seam me-2"></i> Đơn mua</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="/auth/logout">
                                        <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-primary btn-sm px-3 rounded-pill me-2" href="/auth/login">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm px-3 rounded-pill text-white" href="/auth/register">Đăng ký</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
</header><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/layout/components/client/header.blade.php ENDPATH**/ ?>