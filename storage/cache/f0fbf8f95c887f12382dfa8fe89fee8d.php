

<?php $__env->startSection('title', 'Tạo tài khoản Quản trị'); ?>

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
        max-width: 450px;
    }

    .admin-header {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        padding: 35px 30px;
        text-align: center;
        color: white;
    }
    
    .admin-logo-box {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
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

    .system-note {
        background-color: #fffbeb;
        border: 1px solid #fcd34d;
        color: #92400e;
        border-radius: 10px;
        padding: 12px;
        font-size: 0.85rem;
        line-height: 1.4;
        display: flex;
        align-items: start;
        margin-bottom: 20px;
    }
</style>

<div class="admin-card">
    <div class="admin-header">
        <div class="admin-logo-box">
            <i class="bi bi-person-plus-fill fs-3 text-white"></i>
        </div>
        <h4 class="fw-bold mb-1">TẠO QUẢN TRỊ VIÊN</h4>
        <p class="mb-0 opacity-75 small">Đăng ký tài khoản hệ thống nội bộ</p>
    </div>

    <div class="p-4 p-md-5">
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger d-flex align-items-center small rounded-3 mb-4">
                <i class="bi bi-exclamation-octagon-fill me-2"></i>
                <div><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            </div>
        <?php endif; ?>

        <form action="/auth/storeAdmin" method="POST">

            <div class="input-icon-wrapper">
                <input type="text" name="name" class="form-control form-control-admin" placeholder="Họ và tên hiển thị" required>
                <i class="bi bi-person input-icon"></i>
            </div>

            <div class="input-icon-wrapper">
                <input type="email" name="email" class="form-control form-control-admin" placeholder="Email quản trị" required>
                <i class="bi bi-envelope input-icon"></i>
            </div>

            <div class="input-icon-wrapper">
                <input type="password" name="password" class="form-control form-control-admin" placeholder="Mật khẩu khởi tạo" required>
                <i class="bi bi-lock input-icon"></i>
            </div>

            <div class="system-note">
                <i class="bi bi-info-circle-fill me-2 fs-5 mt-1"></i>
                <div>
                    <strong>Lưu ý quan trọng:</strong><br>
                    Tài khoản sau khi tạo sẽ có <b>Trạng thái (Chờ duyệt)</b>. Vui lòng liên hệ Super Admin để kích hoạt nhé!.
                </div>
            </div>

            <button type="submit" class="btn btn-admin">
                XÁC NHẬN ĐĂNG KÝ
            </button>

            <div class="text-center mt-4 pt-3 border-top border-light">
                <a href="/auth/adminLogin" class="text-decoration-none text-muted small hover-text-primary">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại trang Đăng nhập
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.authLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/auth/register.blade.php ENDPATH**/ ?>