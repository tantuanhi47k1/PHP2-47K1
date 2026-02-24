

<?php $__env->startSection('title', 'Đăng nhập Quản trị'); ?>

<?php $__env->startSection('content'); ?>
<style>
    body {
        background: #0f172a !important;
        background-image: radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                          radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                          radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .admin-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        overflow: hidden;
        width: 100%;
        max-width: 400px;
    }

    .admin-header {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
        position: relative;
    }
    
    .admin-logo-box {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
    }

    .form-control-admin {
        background-color: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 15px 12px 45px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        height: 50px;
    }

    .form-control-admin:focus {
        background-color: #fff;
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .input-icon-wrapper {
        position: relative;
        margin-bottom: 20px;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.1rem;
        transition: color 0.3s;
    }

    .form-control-admin:focus + .input-icon,
    .form-control-admin:focus ~ .input-icon {
        color: #6366f1;
    }

    .btn-admin {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        color: white;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 600;
        letter-spacing: 0.5px;
        font-size: 1rem;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-admin:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px -10px rgba(79, 70, 229, 0.5);
        color: white;
    }

    .link-create {
        color: #64748b;
        font-size: 0.85rem;
        text-decoration: none;
        transition: 0.3s;
    }
    .link-create:hover {
        color: #4f46e5;
    }
</style>

<div class="admin-card">
    <div class="admin-header">
        <div class="admin-logo-box">
            <i class="bi bi-shield-lock-fill fs-2 text-white"></i>
        </div>
        <h4 class="fw-bold mb-1">QUẢN TRỊ VIÊN</h4>
        <p class="mb-0 opacity-75 small">Đăng nhập để vào hệ thống</p>
    </div>

    <div class="p-4 p-md-5">
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger d-flex align-items-center small rounded-3 mb-4" role="alert">
                <i class="bi bi-exclamation-octagon-fill me-2"></i>
                <div><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            </div>
        <?php endif; ?>

        <form action="/auth/handleAdminLogin" method="POST">
            
            <div class="input-icon-wrapper">
                <input type="email" name="email" class="form-control form-control-admin" placeholder="Email quản trị" required>
                <i class="bi bi-envelope input-icon"></i>
            </div>

            <div class="input-icon-wrapper">
                <input type="password" name="password" class="form-control form-control-admin" placeholder="Mật khẩu bảo mật" required>
                <i class="bi bi-lock input-icon"></i>
            </div>

            <button type="submit" class="btn btn-admin mt-2">
                TRUY CẬP HỆ THỐNG <i class="bi bi-arrow-right ms-2"></i>
            </button>

            <div class="text-center mt-4 pt-3 border-top border-light">
                <a href="/auth/adminRegister" class="link-create">
                    Chưa có tài khoản? <span class="fw-bold text-dark">Đăng ký mới</span>
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.authLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/admin/auth/login.blade.php ENDPATH**/ ?>