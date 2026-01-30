

<?php $__env->startSection('title', 'Đặt lại mật khẩu'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-5 text-start">
        <h2 class="fw-bold text-dark mb-2">Tạo mật khẩu mới 🔒</h2>
        <p class="text-muted">Mật khẩu mới của bạn phải khác với mật khẩu sử dụng trước đó.</p>
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger rounded-3 mb-4"><?php echo e($_SESSION['error']); ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/auth/handleResetPassword" method="POST">
        <input type="hidden" name="token" value="<?php echo e($token); ?>">

        <div class="mb-4 text-start">
            <label class="form-label">Mật khẩu mới</label>
            <input type="password" name="password" class="form-control py-3 ps-4" placeholder="******" required>
        </div>

        <div class="mb-4 text-start">
            <label class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" name="confirm_password" class="form-control py-3 ps-4" placeholder="******" required>
        </div>
        
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-primary btn-primary-modern text-white">ĐẶT LẠI MẬT KHẨU</button>
        </div>
    </form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.authLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/auth/reset_password.blade.php ENDPATH**/ ?>