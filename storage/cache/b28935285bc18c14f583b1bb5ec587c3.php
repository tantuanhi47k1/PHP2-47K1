

<?php $__env->startSection('content'); ?>

    <style>
        .img-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .hover-shadow:hover {
            background-color: #f8f9fa;
        }

        .btn-variant {
            background-color: #e3f2fd;
            color: #0d6efd;
            border: 1px solid #0d6efd;
        }

        .btn-variant:hover {
            background-color: #0d6efd;
            color: white;
        }
    </style>

    <div class="container-fluid px-4 py-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-box-seam me-2"></i>Quản lý Sản phẩm</h5>
                <a href="/product/create" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Thêm mới sản phẩm
                </a>
            </div>

            <div class="card-body">
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4">Sản phẩm</th>
                                <th>Danh mục</th>
                                <th>Giá gốc</th>
                                <th class="text-center">Biến thể</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-end pe-4">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($products)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                        Chưa có sản phẩm nào.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover-shadow">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="/<?= $p['image'] ?? 'image/no-image.png' ?>"
                                                    class="img-thumb me-3"
                                                    onerror="this.src='https://placehold.co/60x60?text=No+Image'">
                                                <div>
                                                    <div class="fw-bold text-dark"><?= htmlspecialchars($p['name']) ?></div>
                                                    <small class="text-muted">Brand: <?= htmlspecialchars($p['brand_name'] ?? 'ThinkHub') ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-secondary border fw-normal">
                                                <?= htmlspecialchars($p['category_name'] ?? 'N/A') ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">
                                                <?= number_format($p['base_price'] ?? 0, 0, ',', '.') ?> đ
                                            </div>
                                            <?php if(isset($p['variant_price']) && $p['variant_price'] > 0): ?>
                                                <small class="text-primary" style="font-size: 0.7rem;">
                                                    <i class="bi bi-tag-fill me-1"></i>Giá biến thể từ: <?= number_format($p['variant_price'], 0, ',', '.') ?> đ
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="/variant/index/<?= $p['id'] ?>" class="btn btn-sm btn-variant rounded-pill px-3 shadow-sm"
                                                title="Quản lý các thuộc tính Màu, RAM, Size...">
                                                <i class="bi bi-layers-half me-1"></i>
                                                <?= $p['variant_count'] ?? 0 ?> phiên bản
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <?php if(($p['status'] ?? 1) == 1): ?>
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Đang bán</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">Tạm ẩn</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group shadow-sm rounded">
                                                <a href="/product/edit/<?= $p['id'] ?>" class="btn btn-sm btn-outline-primary"
                                                    title="Sửa thông tin chung">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/product/delete/<?= $p['id'] ?>"
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Cảnh báo: Xóa sản phẩm sẽ xóa tất cả biến thể liên quan! Bạn chắc chắn chứ?');"
                                                    title="Xóa sản phẩm">
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
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/admin/product/index.blade.php ENDPATH**/ ?>