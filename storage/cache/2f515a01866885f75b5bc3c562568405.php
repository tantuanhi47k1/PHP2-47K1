

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">Thêm Size Mới</h5>
                </div>
                <div class="card-body p-4">
                    
                    <?php if(isset($mess)): ?>
                        <div class="alert alert-danger"><?php echo e($mess); ?></div>
                    <?php endif; ?>

                    <form action="/size/store" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tên Size <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Ví dụ: XL, 42..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <input type="text" name="description" class="form-control" placeholder="Mô tả thêm (nếu có)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="1">Hoạt động</option>
                                <option value="0">Tạm ẩn</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="/size" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary px-4">Lưu lại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/product/size/create.blade.php ENDPATH**/ ?>