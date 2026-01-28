@extends('layout.adminLayout')

@section('content')
<style>
    .text-brand { color: #009981 !important; }
    .btn-brand { background-color: #009981; color: white; }
    .btn-brand:hover { background-color: #007a67; color: white; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #eee; }
    .variant-img { width: 55px; height: 55px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
    .badge-attr { font-size: 0.75rem; font-weight: 500; }
</style>

<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0 fw-bold text-brand"><i class="bi bi-diagram-3-fill me-2"></i>Quản lý biến thể</h4>
                <small class="text-muted">Sản phẩm gốc: <span class="fw-bold text-dark"><?= htmlspecialchars($product['name']) ?></span></small>
            </div>
            <div class="d-flex gap-2">
                <a href="/product/index" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Quay lại sản phẩm
                </a>
                <a href="/variant/create/<?= $product['id'] ?>" class="btn btn-brand btn-sm shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Thêm biến thể mới
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4" style="width: 350px;">Thông tin biến thể</th>
                        <th>SKU</th>
                        <th>Giá bán</th>
                        <th>Kho hàng</th>
                        <th class="text-center pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($variants)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Chưa có biến thể nào cho sản phẩm này.
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($variants as $v): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="/<?= $v['variant_image'] ?? 'image/no-image.png' ?>" 
                                     class="variant-img shadow-sm me-3" 
                                     onerror="this.src='https://placehold.co/60x60?text=No+Img'">
                                     <div class="fw-bold text-dark mb-0">
                                         <?= htmlspecialchars($v['variant_name'] ?? 'Chưa đặt tên') ?>
                                     </div>
                                
                            </div>
                        </td>

                        <td>
                            <div>
                                    <code class="text-muted small"><?= htmlspecialchars($v['sku']) ?></code>
                                </div>
                        </td>

                        <td>
                            <div class="fw-bold text-danger"><?= number_format($v['price'], 0, ',', '.') ?> đ</div>
                        </td>

                        <td>
                            <?php if($v['stock_quantity'] <= 5): ?>
                                <span class="badge bg-light text-warning border border-warning px-2">
                                    <i class="bi bi-exclamation-triangle me-1"></i>Chỉ còn <?= $v['stock_quantity'] ?>
                                </span>
                            <?php else: ?>
                                <span class="badge bg-light text-success border border-success px-2">
                                    Còn <?= $v['stock_quantity'] ?> sản phẩm
                                </span>
                            <?php endif; ?>
                        </td>

                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="/variant/edit/<?= $v['id'] ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/variant/delete/<?= $v['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Bạn chắc chắn muốn xóa biến thể [<?= htmlspecialchars($v['variant_name']) ?>] này chứ?');" title="Xóa">
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
@endsection