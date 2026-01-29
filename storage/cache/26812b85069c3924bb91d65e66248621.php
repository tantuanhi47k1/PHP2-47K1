

<?php $__env->startSection('title', $product['name'] ?? 'Chi tiết sản phẩm'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="position-relative" style="padding-top: 100%; overflow: hidden;">
                    <img src="/<?php echo e($product['image'] ?? 'image/product/default.png'); ?>" 
                         class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain p-3" 
                         alt="<?php echo e($product['name']); ?>"
                         onerror="this.src='https://placehold.co/500x500?text=No+Image'">
                </div>
            </div>

            <?php if(isset($images) && count($images) > 0): ?>
            <div class="d-flex gap-2 mt-3 overflow-auto pb-2">
                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="/<?php echo e($img['image_path']); ?>" 
                     class="rounded border" 
                     style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                     onclick="document.querySelector('.object-fit-contain').src=this.src">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold text-dark"><?php echo e($product['name']); ?></h1>
            
            <div class="mb-3">
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                    <?php echo e(isset($product['category_name']) ? $product['category_name'] : 'Sản phẩm'); ?>

                </span>

                <?php if(isset($product['status']) && $product['status'] == 1): ?>
                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill ms-2">Còn hàng</span>
                <?php else: ?>
                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill ms-2">Hết hàng</span>
                <?php endif; ?>
            </div>

            <div class="fs-3 mb-4 text-primary fw-bold">
                <?php if(isset($product['variant_price']) && $product['variant_price'] > 0): ?>
                    <?php echo e(number_format($product['variant_price'], 0, ',', '.')); ?> đ
                    <?php if(isset($product['max_price']) && $product['max_price'] > $product['variant_price']): ?>
                        <span class="text-muted fs-5 fw-normal"> - <?php echo e(number_format($product['max_price'], 0, ',', '.')); ?> đ</span>
                    <?php endif; ?>
                <?php elseif(isset($product['base_price'])): ?>
                    <?php echo e(number_format($product['base_price'], 0, ',', '.')); ?> đ
                <?php else: ?>
                    Liên hệ
                <?php endif; ?>
            </div>

            <p class="text-muted lead fs-6"><?php echo e($product['short_description'] ?? 'Chưa có mô tả ngắn.'); ?></p>

            <hr class="my-4 opacity-25">

            <form action="/cart/add" method="POST">
                <input type="hidden" name="id" value="<?php echo e($product['id']); ?>">

                <div class="mb-4">
                    <label class="fw-bold mb-2">Số lượng:</label>
                    <div class="input-group" style="width: 140px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="this.nextElementSibling.stepDown()">-</button>
                        <input type="number" name="quantity" value="1" min="1" class="form-control text-center">
                        <button class="btn btn-outline-secondary" type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-block">
                    <button class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm fw-bold me-md-2" type="submit">
                        <i class="bi bi-cart-plus me-2"></i> Thêm vào giỏ
                    </button>
                    <button class="btn btn-outline-danger btn-lg px-5 rounded-pill fw-bold" type="submit">
                        Mua ngay
                    </button>
                </div>
            </form>

            <div class="mt-4 p-3 bg-light rounded-3 small text-muted">
                <div class="d-flex align-items-center mb-2"><i class="bi bi-shield-check text-success me-2"></i> Bảo hành chính hãng 12 tháng</div>
                <div class="d-flex align-items-center mb-2"><i class="bi bi-arrow-repeat text-primary me-2"></i> Đổi trả trong 7 ngày nếu lỗi</div>
                <div class="d-flex align-items-center"><i class="bi bi-truck text-warning me-2"></i> Miễn phí vận chuyển đơn > 500k</div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                    <h4 class="fw-bold border-start border-4 border-primary ps-3 mb-0">Mô tả chi tiết</h4>
                </div>
                <div class="card-body px-4 pb-4 text-muted" style="line-height: 1.8;">
                    <?php echo $product['description'] ?? 'Đang cập nhật...'; ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/client/product/detail.blade.php ENDPATH**/ ?>