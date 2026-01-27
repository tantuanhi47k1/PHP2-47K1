

<?php $__env->startSection('content'); ?>
<style>
    body { background: #f4f6f9; height: 100vh; display: flex; align-items: center; justify-content: center; }
    .register-box { width: 450px; }
    .card { border-radius: 15px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .btn-brand { background-color: #009981; color: white; font-weight: 600; }
    .btn-brand:hover { background-color: #007a67; color: white; }
    .text-brand { color: #009981; }
</style>

<div class="register-box">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-brand"><i class="bi bi-person-plus-fill"></i> CREATE ADMIN</h2>
        <p class="text-muted">Đăng ký tài khoản quản trị nội bộ</p>
    </div>

    <div class="card p-4">
        <div class="card-body">
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger small"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <form action="/auth/storeAdmin" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Họ và tên</label>
                    <input type="text" name="name" class="form-control" placeholder="Admin Name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email quản trị</label>
                    <input type="email" name="email" class="form-control" placeholder="admin@gmail.com" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    <div class="form-text mt-2 text-danger small">
                        <i class="bi bi-info-circle"></i> Sau khi tạo, tài khoản sẽ có <b>Role 1</b>. Bạn cần kích hoạt trong Database để sử dụng.
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-brand py-2">TẠO TÀI KHOẢN</button>
                </div>
            </form>
        </div>
    </div>
    <div class="text-center mt-3">
        <a href="/auth/adminLogin" class="text-decoration-none text-muted small">Quay lại Đăng nhập</a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.authLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/auth/register.blade.php ENDPATH**/ ?>