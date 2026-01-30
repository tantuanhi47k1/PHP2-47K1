

<?php $__env->startSection('title', 'Đăng ký'); ?>

<?php $__env->startSection('content'); ?>
    <div class="mb-5 text-start">
        <h2 class="fw-bold text-dark mb-2">Tạo tài khoản mới 🚀</h2>
        <p class="text-muted">Điền thông tin bên dưới để bắt đầu hành trình mua sắm.</p>
    </div>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger d-flex align-items-center rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-3 fs-5"></i>
            <div><?php echo e($_SESSION['error']); ?></div>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/auth/storeRegister" method="POST">
        <div class="mb-4">
            <label class="form-label">Họ và tên đầy đủ</label>
            <input type="text" class="form-control py-3" name="full_name" placeholder="Ví dụ: Nguyễn Văn A" required>
        </div>
        <div class="mb-4">
            <label class="form-label">Địa chỉ Email</label>
            <input type="email" class="form-control py-3" name="email" placeholder="name@example.com" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <label class="form-label">Mật khẩu</label>
                <input type="password" class="form-control py-3" name="password" placeholder="Ít nhất 6 ký tự" required>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" class="form-control py-3" name="confirm_password" placeholder="Xác nhận lại" required>
            </div>
        </div>

        <div class="d-grid mb-4">
            <button class="btn btn-primary btn-primary-modern text-white" type="submit">TẠO TÀI KHOẢN</button>
        </div>
    </form>

    <div class="text-center mt-4">
        <p class="text-muted mb-0">Đã có tài khoản? <a href="/auth/login" class="fw-bold text-decoration-none" style="color: var(--primary-color);">Đăng nhập tại đây</a></p>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.authLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/auth/register.blade.php ENDPATH**/ ?>