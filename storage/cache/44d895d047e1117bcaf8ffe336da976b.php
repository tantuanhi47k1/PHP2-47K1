

<?php $__env->startSection('title', 'Đăng nhập'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-5 text-start">
        <h2 class="fw-bold text-dark mb-2">Chào mừng trở lại! 👋</h2>
        <p class="text-muted">Vui lòng đăng nhập để tiếp tục mua sắm.</p>
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger d-flex align-items-center rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
            <div><?php echo e($_SESSION['error']); ?></div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success d-flex align-items-center rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-3 fs-5"></i>
            <div><?php echo e($_SESSION['success']); ?></div>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form action="/auth/handleUserLogin" method="POST">
        <div class="mb-4">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0 ps-3 py-3" style="border-color: #eee; border-top-left-radius: 12px; border-bottom-left-radius: 12px;"><i class="bi bi-envelope text-muted"></i></span>
                <input type="email" class="form-control border-start-0 ps-0 py-3" id="email" name="email" placeholder="name@example.com" required style="border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
            </div>
        </div>

        <div class="mb-4">
             <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label mb-0">Mật khẩu</label>
                <a href="/auth/forgotPassword" class="text-decoration-none small fw-semibold" style="color: var(--primary-color);">Quên mật khẩu?</a>
            </div>
            <div class="input-group">
                <span class="input-group-text bg-transparent border-end-0 ps-3 py-3" style="border-color: #eee; border-top-left-radius: 12px; border-bottom-left-radius: 12px;"><i class="bi bi-lock text-muted"></i></span>
                <input type="password" class="form-control border-start-0 ps-0 py-3" id="password" name="password" placeholder="******" required style="border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
            </div>
        </div>

        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe" style="width: 1.2em; height: 1.2em;">
                <label class="form-check-label text-muted ms-1" for="rememberMe">Ghi nhớ đăng nhập</label>
            </div>
        </div>

        <div class="d-grid mb-4">
            <button class="btn btn-primary btn-primary-modern text-white" type="submit">ĐĂNG NHẬP NGAY</button>
        </div>

        <div class="position-relative mb-4 text-center">
            <hr class="text-muted opacity-25 my-0">
            <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted small text-uppercase fw-bold">Hoặc tiếp tục với</span>
        </div>

        <div class="d-grid">
            <a href="/auth/googleLogin" class="btn btn-google-modern d-flex align-items-center justify-content-center text-decoration-none">
                <img src="https://i.pinimg.com/originals/74/65/f3/7465f30319191e2729668875e7a557f2.png" alt="Google" width="24" class="me-3">
                <span class="text-dark">Đăng nhập bằng Google</span>
            </a>
        </div>
    </form>

    <div class="text-center mt-5">
        <p class="text-muted mb-0">Chưa có tài khoản? <a href="/auth/register" class="fw-bold text-decoration-none" style="color: var(--primary-color);">Đăng ký miễn phí</a></p>
    </div>
    <div class="text-center mt-3">
        <a href="/" class="text-decoration-none text-muted small fw-medium"><i class="bi bi-arrow-left me-1"></i> Quay về trang chủ</a>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.authLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/auth/login.blade.php ENDPATH**/ ?>