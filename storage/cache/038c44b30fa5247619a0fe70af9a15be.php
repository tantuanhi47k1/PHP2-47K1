

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4 px-4">
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Quản lý biến thể</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/product/manage">Sản phẩm</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold"><?php echo e($product['name']); ?></li>
                </ol>
            </nav>
        </div>
        <a href="/product/manage" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4">
                <h6 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-plus-circle me-2"></i>Thêm phiên bản mới</h6>
                <form action="/variant/store" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo e($product['id']); ?>">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-primary">TÊN PHIÊN BẢN (HIỂN THỊ)</label>
                        <input type="text" name="variant_name" class="form-control shadow-sm border-primary border-opacity-25" 
                               placeholder="VD: Màu Đen, Bản 128GB..." required>
                        <div class="form-text small">Tên này sẽ hiện thị trên trang chi tiết để khách hàng chọn.</div>
                    </div>

                    <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">CHỌN <?php echo e(strtoupper($attr['name'])); ?></label>
                        <select name="attribute_values[]" class="form-select shadow-sm" required>
                            <option value="">-- Chọn <?php echo e($attr['name']); ?> --</option>
                            <?php $__currentLoopData = $attr['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val['id']); ?>"><?php echo e($val['value']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">GIÁ BÁN (Đ)</label>
                        <input type="number" name="price" class="form-control shadow-sm" placeholder="Nhập giá..." required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">SỐ LƯỢNG KHO</label>
                        <input type="number" name="stock" class="form-control shadow-sm" placeholder="Nhập số lượng..." required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">ẢNH BIẾN THỂ (NẾU CÓ)</label>
                        <input type="file" name="image" class="form-control shadow-sm">
                        <div class="form-text small">Để trống nếu dùng chung ảnh sản phẩm.</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm py-2">
                        <i class="bi bi-save me-2"></i>LƯU BIẾN THỂ
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <form action="/variant/updateAll" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo e($product['id']); ?>">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3" width="80">Ảnh</th>
                                    <th>Phiên bản</th>
                                    <th width="180">Giá bán (đ)</th>
                                    <th width="120">Tồn kho</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($variants)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                        Sản phẩm này chưa có biến thể nào.
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php $__currentLoopData = $variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="ps-3">
                                            <img src="/<?php echo e($v['image'] ?? $product['image']); ?>" 
                                                 class="rounded border shadow-sm object-fit-cover" 
                                                 style="width: 50px; height: 50px;"
                                                 onerror="this.src='https://placehold.co/50x50?text=No+Img'">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">
                                                <?php echo e($v['variant_name'] ?? $v['sku_info']); ?>

                                            </div>
                                            <code class="small text-muted" style="font-size: 0.7rem;"><?php echo e($v['sku']); ?></code>
                                        </td>
                                        <td>
                                            <input type="number" name="prices[<?php echo e($v['id']); ?>]" 
                                                   value="<?php echo e((int)$v['price']); ?>" 
                                                   class="form-control form-control-sm fw-bold text-primary border-primary border-opacity-25 shadow-sm">
                                        </td>
                                        <td>
                                            <input type="number" name="stocks[<?php echo e($v['id']); ?>]" 
                                                   value="<?php echo e($v['stock_quantity']); ?>" 
                                                   class="form-control form-control-sm shadow-sm border-opacity-25">
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="/variant/edit/<?php echo e($v['id']); ?>" class="btn btn-sm btn-outline-primary" title="Sửa chi tiết">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/variant/delete/<?php echo e($v['id']); ?>/<?php echo e($product['id']); ?>" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('Bạn chắc chắn muốn xóa phiên bản này?');" title="Xóa">
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
                    <?php if(!empty($variants)): ?>
                    <div class="card-footer bg-white py-3">
                        <button type="submit" class="btn btn-success btn-sm fw-bold px-4 shadow-sm">
                            <i class="bi bi-check-all me-1"></i> CẬP NHẬT NHANH GIÁ & KHO
                        </button>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .object-fit-cover { object-fit: cover; }
    .breadcrumb-item + .breadcrumb-item::before { content: ">"; }
    .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1); }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/admin/variant/index.blade.php ENDPATH**/ ?>