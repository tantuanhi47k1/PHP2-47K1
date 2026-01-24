

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-rulers me-2"></i>Quản lý Kích thước (Size)</h5>
            <a href="/size/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm mới
            </a>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên Size</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($sizes)): ?>
                        <?php $__currentLoopData = $sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>#<?php echo e($s['id']); ?></td>
                            <td class="fw-bold"><?php echo e($s['name']); ?></td>
                            <td class="text-center">
                                <?php if($s['status'] == 1): ?>
                                    <span class="badge bg-success bg-opacity-10 text-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">Ẩn</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="/size/edit/<?php echo e($s['id']); ?>" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="/size/delete/<?php echo e($s['id']); ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">Chưa có dữ liệu</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/product/size/index.blade.php ENDPATH**/ ?>