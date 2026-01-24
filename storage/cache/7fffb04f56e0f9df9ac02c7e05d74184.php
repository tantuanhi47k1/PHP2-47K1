

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">Cập Nhật Size</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/size/update/<?php echo e($size['id']); ?>" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tên Size <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?php echo e($size['name']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="1" <?php echo e($size['status'] == 1 ? 'selected' : ''); ?>>Hoạt động</option>
                                <option value="0" <?php echo e($size['status'] == 0 ? 'selected' : ''); ?>>Tạm ẩn</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="/size" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/product/size/edit.blade.php ENDPATH**/ ?>