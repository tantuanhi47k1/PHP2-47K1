

<?php $__env->startSection('title', 'Đăng ký tài khoản'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow border-0 rounded-3">
                <div class="row g-0">
                    <div class="col-md-5 d-none d-md-block bg-primary text-white p-4 d-flex flex-column justify-content-center align-items-center rounded-start">
                        <h4 class="fw-bold mb-3">Tham gia cùng chúng tôi</h4>
                        <p class="text-center small">Tạo tài khoản để theo dõi đơn hàng, lưu danh sách yêu thích và nhận nhiều ưu đãi hấp dẫn.</p>
                        <i class="bi bi-cart-check-fill display-1 mt-3 text-white-50"></i>
                    </div>

                    <div class="col-md-7">
                        <div class="card-body p-4 p-lg-5">
                            <h4 class="fw-bold text-center mb-4">Đăng Ký Thành Viên</h4>

                            
                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <div><?= $_SESSION['error'] ?></div>
                                </div>
                                <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>

                            <form action="/auth/storeRegister" method="POST">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Họ và tên</label>
                                    <input type="text" name="full_name" class="form-control" placeholder="Ví dụ: Nguyễn Văn A" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="email@domain.com" required>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Mật khẩu</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Nhập lại mật khẩu</label>
                                        <input type="password" name="confirm_password" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control" placeholder="09xxxxxxxx">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">Địa chỉ</label>
                                        <input type="text" name="address" class="form-control" placeholder="Tỉnh/Thành phố">
                                    </div>
                                </div>

                                <div class="form-check mb-4">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label small text-muted" for="terms">
                                        Tôi đồng ý với <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a>
                                    </label>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary fw-bold py-2">ĐĂNG KÝ TÀI KHOẢN</button>
                                </div>
                            </form>

                            <div class="text-center mt-3">
                                <p class="small text-muted mb-0">Đã có tài khoản? <a href="/auth/login" class="fw-bold text-decoration-none">Đăng nhập ngay</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/auth/register.blade.php ENDPATH**/ ?>