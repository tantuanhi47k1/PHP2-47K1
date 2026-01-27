

<?php $__env->startSection('content'); ?>
<style>
    body {
        background: #f4f6f9;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', sans-serif;
    }
    .login-box {
        width: 100%;
        max-width: 420px;
        padding: 15px;
    }
    .card {
        border-radius: 20px;
        border: none;
        box-shadow: 0 15px 35px rgba(0, 153, 129, 0.1);
        overflow: hidden;
    }
    .card-header {
        background: white;
        border: none;
        padding-top: 30px;
    }
    .btn-brand {
        background-color: #009981;
        color: white;
        font-weight: 600;
        padding: 12px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    .btn-brand:hover {
        background-color: #007a67;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 153, 129, 0.3);
    }
    .text-brand {
        color: #009981;
    }
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
        color: #6c757d;
    }
    .form-control {
        border-left: none;
        padding: 12px 15px;
        border-radius: 0 10px 10px 0;
    }
    .form-control:focus {
        border-color: #dee2e6;
        box-shadow: none;
    }
    .input-group:focus-within .input-group-text {
        border-color: #009981;
        color: #009981;
    }
    .input-group:focus-within .form-control {
        border-color: #009981;
    }
    /* Style mới cho link đăng ký */
    .register-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #f1f1f1;
        color: #6c757d;
        text-decoration: none;
        font-size: 0.9rem;
        transition: 0.2s;
    }
    .register-link:hover {
        color: #009981;
    }
    .register-link b {
        color: #009981;
    }
</style>

<div class="login-box">
    <div class="text-center mb-4">
        <div class="mb-3">
            <i class="bi bi-shield-lock-fill text-brand" style="font-size: 3rem;"></i>
        </div>
        <h2 class="fw-bold text-dark mb-1">ADMIN TECHHUB</h2>
        <p class="text-muted">Hệ thống quản lý cửa hàng</p>
    </div>

    <div class="card shadow">
        <div class="card-body p-4 p-md-5">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger border-0 small d-flex align-items-center mb-4" style="background-color: #fff5f5; color: #e53e3e;">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>
                    <div><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                </div>
            <?php endif; ?>

            <form action="/auth/handleAdminLogin" method="POST">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">EMAIL QUẢN TRỊ</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">MẬT KHẨU</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-brand">
                        ĐĂNG NHẬP NGAY
                    </button>
                </div>
                
                <a href="/auth/adminRegister" class="register-link">
                    Chưa có tài khoản? <b>Tạo Admin mới</b>
                </a>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.authLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/auth/login.blade.php ENDPATH**/ ?>