

<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --primary-color: #009981;
        }

        .text-brand {
            color: var(--primary-color) !important;
        }

        .btn-brand {
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-brand:hover {
            background-color: #007a67;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 153, 129, 0.2);
        }

        .img-logo {
            width: 50px;
            height: 50px;
            object-fit: contain;
            border: 1px solid #eee;
            padding: 2px;
            background: #fff;
            border-radius: 4px;
        }
        
        .table thead th {
            background-color: #f8f9fa;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            color: #666;
            border-bottom: 2px solid #eee;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-brand">
                    <i class="bi bi-patch-check-fill me-2"></i>QUẢN LÝ THƯƠNG HIỆU
                </h4>
                <a href="/brand/create" class="btn btn-brand btn-sm px-3 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Thêm mới
                </a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show m-3 border-0 shadow-sm" role="alert" style="background-color: #e6f6f4; color: #00816d;">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Thành công!</strong> <?= $_SESSION['success']; ?>
                    <?php unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 100px;">Logo</th>
                            <th>Thông tin thương hiệu</th>
                            <th>Mô tả chi tiết</th>
                            <th class="text-center pe-4" style="width: 160px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($brands)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Hiện chưa có thương hiệu nào trong hệ thống.
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach($brands as $brand): ?>
                        <tr>
                            <td class="ps-4">
                                <img src="<?= !empty($brand['logo']) ? '/' . $brand['logo'] : 'https://placehold.co/50x50?text=Brand' ?>" 
                                     class="img-logo" 
                                     onerror="this.src='https://placehold.co/50x50?text=Error'">
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($brand['name']) ?></div>
                                <small class="text-muted text-uppercase" style="font-size: 0.7rem;">Mã ID: #<?= $brand['id'] ?></small>
                            </td>
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 350px;" title="<?= htmlspecialchars($brand['description'] ?? '') ?>">
                                    <?= htmlspecialchars($brand['description'] ?? 'Không có mô tả cho thương hiệu này.') ?>
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="btn-group">
                                    <a href="/brand/edit/<?= $brand['id'] ?>" class="btn btn-outline-primary btn-sm" title="Chỉnh sửa">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="/brand/delete/<?= $brand['id'] ?>" 
                                       class="btn btn-outline-danger btn-sm ms-1"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa thương hiệu này không?');"
                                       title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/brand/index.blade.php ENDPATH**/ ?>