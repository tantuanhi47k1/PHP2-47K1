

<?php $__env->startSection('title', 'Đăng nhập'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5" style="min-height: 80vh;">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary text-uppercase">Đăng Nhập</h3>
                        <p class="text-muted">Chào mừng bạn quay trở lại!</p>
                    </div>

                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?= $_SESSION['error'] ?></div>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div><?= $_SESSION['success'] ?></div>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form action="/auth/handleUserLogin" method="POST">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                            <label for="floatingInput">Địa chỉ Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                            <label for="floatingPassword">Mật khẩu</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label text-muted" for="rememberMe">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none small">Quên mật khẩu?</a>
                        </div>

                        
                        <div class="d-grid mb-3">
                            <button class="btn btn-primary btn-lg fw-bold" type="submit">ĐĂNG NHẬP</button>
                        </div>

                        
                        <div class="position-relative my-4">
                            <hr class="text-muted opacity-25">
                            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small">HOẶC</span>
                        </div>

                        
                        <div class="d-grid">
                            <a href="/auth/googleLogin" class="btn btn-outline-danger btn-lg fw-bold d-flex align-items-center justify-content-center">
                                <i class="bi bi-google me-2"></i> 
                                Đăng nhập bằng Google
                            </a>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Chưa có tài khoản? <a href="/auth/register" class="fw-bold text-primary text-decoration-none">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/auth/login.blade.php ENDPATH**/ ?>