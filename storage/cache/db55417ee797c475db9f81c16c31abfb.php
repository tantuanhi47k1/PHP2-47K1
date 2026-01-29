

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-4">Chào mừng, <?= $_SESSION['admin_name'] ?>!</h3>
    
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Tổng sản phẩm</small>
                        <h2 class="mb-0 fw-bold">120</h2>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Đơn hàng mới</small>
                        <h2 class="mb-0 fw-bold">15</h2>
                    </div>
                    <i class="bi bi-cart-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/admin/dashboard.blade.php ENDPATH**/ ?>