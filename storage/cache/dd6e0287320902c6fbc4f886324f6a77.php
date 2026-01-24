

<?php $__env->startSection('content'); ?>

    <style>
        .text-brand { color: #009981 !important; }
        .btn-brand { background-color: #009981; color: white; }
        .btn-brand:hover { background-color: #007a67; color: white; }
        .table-v-middle td, .table-v-middle th { vertical-align: middle; }
    </style>

    <div class="container-fluid px-4 py-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-brand">
                    <i class="bi bi-palette me-2"></i>Quản lý Màu sắc
                </h4>
                <a href="/color/create" class="btn btn-brand btn-sm shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Thêm màu mới
                </a>
            </div>

            <?php if(isset($mess)): ?>
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?php echo e($mess); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-v-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 100px;">ID</th>
                                <th>Tên màu sắc</th>
                                <th>Ngày tạo</th>
                                <th class="text-center pe-4" style="width: 150px;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($colors) || count($colors) == 0): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Chưa có dữ liệu màu sắc nào.
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 text-muted">#<?php echo e($color['id']); ?></td>
                                    <td>
                                        <span class="fw-bold text-dark"><?php echo e($color['name']); ?></span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <?php echo e(date('d/m/Y H:i', strtotime($color['created_at']))); ?>

                                        </small>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group">
                                            <a href="/color/edit/<?php echo e($color['id']); ?>" 
                                               class="btn btn-sm btn-outline-primary" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="/color/delete/<?php echo e($color['id']); ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa màu [<?php echo e($color['name']); ?>] này?');" 
                                               title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/admin/product/color/index.blade.php ENDPATH**/ ?>