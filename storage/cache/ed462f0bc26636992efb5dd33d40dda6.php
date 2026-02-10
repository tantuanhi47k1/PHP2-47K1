
<?php $__env->startSection('title', 'Chi tiết đơn hàng #' . $order['id']); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <a href="/profile?tab=orders" class="text-decoration-none text-muted mb-3 d-inline-block">
                <i class="bi bi-arrow-left"></i> Quay lại danh sách
            </a>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold">Đơn hàng #<?php echo e($order['id']); ?></h5>
                            <small class="text-muted">Ngày đặt: <?php echo e(date('d/m/Y H:i', strtotime($order['created_at']))); ?></small>
                        </div>
                        <div>
                            <?php if($order['status'] == 1): ?> <span class="badge bg-warning text-dark">Chờ xử lý</span>
                            <?php elseif($order['status'] == 2): ?> <span class="badge bg-info">Đang giao</span>
                            <?php elseif($order['status'] == 3): ?> <span class="badge bg-success">Hoàn thành</span>
                            <?php else: ?> <span class="badge bg-danger">Đã hủy</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-uppercase small text-muted">Địa chỉ nhận hàng</h6>
                            <p class="mb-1 fw-bold"><?php echo e($order['fullname']); ?></p>
                            <p class="mb-1 text-muted"><?php echo e($order['phone']); ?></p>
                            <p class="mb-0 text-muted"><?php echo e($order['address']); ?></p>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <h6 class="fw-bold text-uppercase small text-muted">Thanh toán</h6>
                            <p class="mb-1 text-uppercase"><?php echo e($order['payment_method'] == 'cod' ? 'Thanh toán khi nhận hàng' : $order['payment_method']); ?></p>
                            <p class="fst-italic text-muted">"<?php echo e($order['note'] ?: 'Không có ghi chú'); ?>"</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="bg-light">
                                <tr><th>Sản phẩm</th><th class="text-center">Giá</th><th class="text-center">SL</th><th class="text-end">Tạm tính</th></tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php $img = !empty($item['product_image']) ? '/' . $item['product_image'] : 'https://placehold.co/50'; ?>
                                                <img src="<?php echo e($img); ?>" class="rounded border me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <div class="fw-bold"><?php echo e($item['product_name']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center"><?php echo e(number_format($item['price'], 0, ',', '.')); ?>đ</td>
                                        <td class="text-center">x<?php echo e($item['quantity']); ?></td>
                                        <td class="text-end fw-bold"><?php echo e(number_format($item['total_price'], 0, ',', '.')); ?>đ</td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td colspan="3" class="text-end pt-4">Tổng tiền hàng</td>
                                    <td class="text-end pt-4"><?php echo e(number_format($order['total_money'], 0, ',', '.')); ?>đ</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end border-0 pb-0">Phí vận chuyển</td>
                                    <td class="text-end border-0 pb-0">Miễn phí</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end border-0 pt-3"><span class="fw-bold fs-5">Thành tiền</span></td>
                                    <td class="text-end border-0 pt-3"><span class="fw-bold fs-4 text-primary"><?php echo e(number_format($order['total_money'], 0, ',', '.')); ?>đ</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/client/profile/order_detail.blade.php ENDPATH**/ ?>