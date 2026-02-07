

<?php $__env->startSection('title', 'Liên hệ với TechHub'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .contact-info-box {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 16px;
        height: 100%;
    }
    .contact-icon {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        font-size: 1.2rem;
    }
</style>

<div class="container py-5">
    <div class="row mb-5">
        <div class="col-lg-12 text-center">
            <h2 class="fw-bold text-dark">Liên hệ với chúng tôi</h2>
            <p class="text-muted">Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn 24/7</p>
        </div>
    </div>

    <div class="row g-5">
        <div class="col-lg-5">
            <div class="contact-info-box shadow-sm">
                <h4 class="fw-bold mb-4">Thông tin liên lạc</h4>
                
                <div class="d-flex mb-4">
                    <div class="contact-icon flex-shrink-0 me-3">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Địa chỉ</h6>
                        <p class="text-muted mb-0 small">123 Đường Công Nghệ, Quận 1, TP. Hồ Chí Minh</p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="contact-icon flex-shrink-0 me-3">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Hotline</h6>
                        <p class="text-muted mb-0 small">1900 7799 - (028) 3888 9999</p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="contact-icon flex-shrink-0 me-3">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Email</h6>
                        <p class="text-muted mb-0 small">support@techhub.com</p>
                    </div>
                </div>

                <div class="d-flex">
                    <div class="contact-icon flex-shrink-0 me-3">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Giờ làm việc</h6>
                        <p class="text-muted mb-0 small">Thứ 2 - Chủ Nhật: 8:00 - 22:00</p>
                    </div>
                </div>

                <hr class="my-4 text-muted opacity-25">
                
                <div class="rounded-4 overflow-hidden border">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.424367980077!2d106.6976333!3d10.7746269!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f385570472f%3A0x1787491df6ed1d96!2sIndependence%20Palace!5e0!3m2!1sen!2s!4v1700000000000" 
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 p-md-5">
                    <h4 class="fw-bold mb-4">Gửi tin nhắn cho TechHub</h4>

                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success d-flex align-items-center rounded-3 mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> <?php echo e($_SESSION['success']); ?>

                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger d-flex align-items-center rounded-3 mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo e($_SESSION['error']); ?>

                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    <form action="/contact/send" method="POST">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control py-2" 
                                    value="<?php echo e($user['full_name'] ?? ''); ?>" required placeholder="Nhập họ tên...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control py-2" 
                                    value="<?php echo e($user['email'] ?? ''); ?>" required placeholder="Nhập email...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control py-2" 
                                    value="<?php echo e($user['phone'] ?? ''); ?>" placeholder="Nhập số điện thoại...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Chủ đề</label>
                                <input type="text" name="subject" class="form-control py-2" placeholder="Vấn đề cần hỗ trợ...">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Nội dung tin nhắn <span class="text-danger">*</span></label>
                                <textarea name="message" class="form-control" rows="5" required placeholder="Bạn cần chúng tôi hỗ trợ gì?"></textarea>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill fw-bold shadow-sm">
                                    <i class="bi bi-send me-2"></i> Gửi Tin Nhắn
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/contact/index.blade.php ENDPATH**/ ?>