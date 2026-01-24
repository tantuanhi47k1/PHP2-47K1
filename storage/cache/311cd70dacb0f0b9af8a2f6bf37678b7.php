

<?php $__env->startSection('title', 'Cửa Hàng'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h2 class="text-center mb-4 fw-bold">Tất Cả Sản Phẩm</h2>
    <div class="row">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($item['status']) && $item['status'] == 1): ?> 
            <div class="col-md-3 col-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="position-relative">
                        <img src="/uploads/<?php echo e($item['image']); ?>" class="card-img-top" alt="<?php echo e($item['name']); ?>" style="height: 250px; object-fit: cover;">
                        
                        <?php if(!empty($item['sale_price']) && $item['sale_price'] > 0): ?>
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                -<?php echo e(round((($item['price'] - $item['sale_price'])/$item['price'])*100)); ?>%
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title text-truncate">
                            <a href="/product/detail/<?php echo e($item['id']); ?>" class="text-decoration-none text-dark">
                                <?php echo e($item['name']); ?>

                            </a>
                        </h5>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <?php if(!empty($item['sale_price']) && $item['sale_price'] > 0): ?>
                                <span class="text-danger fw-bold"><?php echo e(number_format($item['sale_price'], 0, ',', '.')); ?> đ</span>
                                <span class="text-muted text-decoration-line-through small"><?php echo e(number_format($item['price'], 0, ',', '.')); ?> đ</span>
                            <?php else: ?>
                                <span class="fw-bold"><?php echo e(number_format($item['price'], 0, ',', '.')); ?> đ</span>
                            <?php endif; ?>
                        </div>
                        <a href="/product/detail/<?php echo e($item['id']); ?>" class="btn btn-outline-primary btn-sm mt-3 w-100">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/client/product/index.blade.php ENDPATH**/ ?>