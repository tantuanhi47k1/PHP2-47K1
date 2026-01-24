
<?php $__env->startSection('title', $product['name']); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="/uploads/<?php echo e($product['image']); ?>" class="img-fluid rounded shadow-sm w-100" alt="<?php echo e($product['name']); ?>">
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold"><?php echo e($product['name']); ?></h1>
            <div class="mb-3">
                <span class="badge bg-success">Còn hàng: <?php echo e($product['quantity']); ?></span>
                <span class="badge bg-info">Mã SP: #<?php echo e($product['id']); ?></span>
            </div>

            <div class="fs-4 mb-4">
                <?php if(!empty($product['sale_price']) && $product['sale_price'] > 0): ?>
                    <span class="text-danger fw-bold me-2"><?php echo e(number_format($product['sale_price'], 0, ',', '.')); ?> đ</span>
                    <span class="text-muted text-decoration-line-through fs-5"><?php echo e(number_format($product['price'], 0, ',', '.')); ?> đ</span>
                <?php else: ?>
                    <span class="fw-bold"><?php echo e(number_format($product['price'], 0, ',', '.')); ?> đ</span>
                <?php endif; ?>
            </div>

            <p class="text-muted"><?php echo e($product['short_description'] ?? ''); ?></p>

            <div class="d-grid gap-2 d-md-block mt-4">
                <button class="btn btn-primary btn-lg px-5 me-2" type="button">
                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                </button>
                <button class="btn btn-outline-danger btn-lg px-5" type="button">Mua ngay</button>
            </div>

            <hr class="my-4">
            
            <div class="product-description">
                <h5 class="fw-bold">Mô tả sản phẩm</h5>
                <p><?php echo nl2br($product['description'] ?? ''); ?></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/product/detail.blade.php ENDPATH**/ ?>