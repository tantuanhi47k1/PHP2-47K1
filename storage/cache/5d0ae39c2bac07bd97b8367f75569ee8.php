

<?php $__env->startSection('content'); ?>
<style>
    .text-brand { color: #009981 !important; }
    .btn-warning { background-color: #ffc107; color: #000; border: none; }
    .btn-warning:hover { background-color: #e0a800; color: #000; }
    .current-variant-img { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #eee; margin-bottom: 10px; }
    #image-preview { max-width: 120px; border-radius: 8px; display: none; margin-top: 10px; border: 2px solid #009981; }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-warning"><i class="bi bi-pencil-square me-2"></i>CHỈNH SỬA BIẾN THỂ</h5>
                    <small class="text-muted">Sản phẩm: <span class="fw-bold"><?= htmlspecialchars($product['name']) ?></span></small>
                </div>
                <div class="card-body p-4">
                    <form action="/variant/update/<?= $variant['id'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-12 text-center mb-3">
                                <label class="form-label d-block fw-bold small text-muted text-uppercase">Ảnh biến thể</label>
                                
                                <?php 
                                    $imageModel = new ProductImageModel();
                                    $currentImg = $imageModel->getImagesByVariantId($variant['id'])[0] ?? null;
                                ?>
                                <div class="d-flex justify-content-center gap-4 align-items-end">
                                    <div>
                                        <small class="d-block text-muted mb-1">Hiện tại</small>
                                        <img src="/<?= $currentImg['image_path'] ?? 'image/no-image.png' ?>" class="current-variant-img" onerror="this.src='https://placehold.co/120x120?text=No+Img'">
                                    </div>
                                    <div id="preview-container" style="display: none;">
                                        <small class="d-block text-success mb-1">Mới (Xem trước)</small>
                                        <img id="image-preview" src="#">
                                    </div>
                                </div>

                                <input type="file" name="variant_image" class="form-control mt-2" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted">Để trống nếu muốn giữ nguyên ảnh cũ.</small>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Tên biến thể</label>
                                <input type="text" name="variant_name" class="form-control" value="<?= htmlspecialchars($variant['variant_name'] ?? '') ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Mã SKU</label>
                                <input type="text" name="sku" class="form-control" value="<?= htmlspecialchars($variant['sku']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Giá bán (VNĐ)</label>
                                <input type="number" name="price" class="form-control" value="<?= (int)$variant['price'] ?>" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Số lượng trong kho</label>
                                <input type="number" name="stock_quantity" class="form-control" value="<?= $variant['stock_quantity'] ?>" required>
                            </div>

                            <hr class="my-3">
                            <h6 class="fw-bold text-muted">Thay đổi thuộc tính</h6>

                            <?php foreach($attributes as $attr): ?>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold"><?= htmlspecialchars($attr['name']) ?></label>
                                <select name="attributes[]" class="form-select" required>
                                    <?php foreach($attr['values'] as $val): ?>
                                        <option value="<?= $val['id'] ?>" 
                                            <?= in_array($val['id'], $selectedAttributes) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($val['value']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endforeach; ?>

                            <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                                <a href="/variant/index/<?= $product['id'] ?>" class="btn btn-light border px-4">Quay lại</a>
                                <button type="submit" class="btn btn-warning px-4 fw-bold">
                                    Cập nhật thay đổi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('preview-container');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                container.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/variant/edit.blade.php ENDPATH**/ ?>