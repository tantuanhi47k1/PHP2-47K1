

<?php $__env->startSection('content'); ?>

    <style>
        .text-brand { color: #009981 !important; }
        .btn-brand { background-color: #009981; color: white; }
        .btn-brand:hover { background-color: #007a67; color: white; }
        .img-thumb { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
        .badge-variant:hover { background-color: #0dcaf0 !important; color: white !important; transition: 0.3s; }
    </style>

    <div class="container-fluid px-4 py-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-brand"><i class="bi bi-box-seam me-2"></i>Sản phẩm</h4>
                <a href="/product/create" class="btn btn-brand btn-sm shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Thêm mới
                </a>
            </div>

            <?php if (isset($mess)): ?>
            <div class="alert alert-success d-flex align-items-center m-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div><?= $mess ?></div>
            </div>
            <?php endif; ?>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá gốc</th>
                            <th class="text-center">Biến thể</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center pe-4">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($products)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Chưa có sản phẩm nào.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach($products as $p): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="/<?= $p['thumbnail_path'] ?? 'image/no-image.png' ?>" class="img-thumb me-3" onerror="this.src='https://placehold.co/60x60?text=No+Img'">
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($p['name']) ?></div>
                                        <small class="text-muted">ID: #<?= $p['id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-secondary border">
                                    <?= htmlspecialchars($p['category_name'] ?? 'Không có') ?>
                                </span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= number_format($p['base_price'], 0, ',', '.') ?> đ</div>
                            </td>
                            
                            <td class="text-center">
                                <a href="/variant/index/<?= $p['id'] ?>" class="text-decoration-none">
                                    <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info badge-variant">
                                        <i class="bi bi-layers me-1"></i> <?= $p['variant_count'] ?? 0 ?> biến thể
                                    </span>
                                </a>
                            </td>

                            <td class="text-center">
                                <?php if(isset($p['status']) && $p['status'] == 1): ?>
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Hoạt động</span>
                                <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">Ẩn</span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="text-center pe-4">
                                <a href="/variant/index/<?= $p['id'] ?>" class="btn btn-sm btn-light border text-info" title="Quản lý biến thể">
                                    <i class="bi bi-diagram-3"></i>
                                </a>

                                <a href="/product/edit/<?= $p['id'] ?>" class="btn btn-sm btn-light border text-primary" title="Sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="/product/delete/<?= $p['id'] ?>" class="btn btn-sm btn-light border text-danger ms-1" 
                                   onclick="return confirm('Xóa sản phẩm này sẽ xóa toàn bộ biến thể và ảnh liên quan?');" title="Xóa">
                                    <i class="bi bi-trash"></i>
                                </a>
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
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/product/index.blade.php ENDPATH**/ ?>