

<?php $__env->startSection('title', 'Quên mật khẩu'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-5 text-center">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
            <i class="bi bi-key-fill fs-1"></i>
        </div>
        <h2 class="fw-bold text-dark mb-2">Quên mật khẩu?</h2>
        <p class="text-muted">Đừng lo lắng! Nhập email của bạn và chúng tôi sẽ gửi link khôi phục.</p>
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger d-flex align-items-center rounded-3 mb-4"><?php echo e($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/auth/sendResetLink" method="POST">
        <div class="mb-4 text-start">
            <label class="form-label">Email đã đăng ký</label>
            <input type="email" name="email" class="form-control py-3 ps-4" placeholder="name@example.com" required>
        </div>
        
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-primary btn-primary-modern text-white">GỬI LINK KHÔI PHỤC</button>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="/auth/login" class="text-decoration-none text-muted fw-medium">
            <i class="bi bi-arrow-left me-2"></i>Quay lại Đăng nhập
        </a>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.authLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/auth/forgot_password.blade.php ENDPATH**/ ?>