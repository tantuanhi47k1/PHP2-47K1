

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-brand"><i class="bi bi-plus-circle-fill me-2"></i>THÊM THƯƠNG HIỆU MỚI</h5>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger border-0 small mb-4">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="/brand/store" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4 text-center border-end">
                                <label class="form-label d-block fw-bold mb-3">Logo thương hiệu</label>
                                <div class="mb-3">
                                    <div class="preview-container mb-3 mx-auto" style="width: 150px; height: 150px; border: 2px dashed #dee2e6; border-radius: 10px; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f8f9fa;">
                                        <img id="preview" src="https://placehold.co/150x150?text=No+Logo" 
                                             class="img-fluid" style="max-height: 100%; object-fit: contain;">
                                    </div>
                                </div>
                                <div class="px-2">
                                    <input type="file" name="logo" class="form-control form-control-sm" id="logoInput" accept="image/*" required>
                                    <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">
                                        Nên chọn ảnh vuông, nền trắng hoặc trong suốt (PNG).
                                    </small>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Tên thương hiệu <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" placeholder="Ví dụ: Apple, Samsung, Sony..." required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Mô tả ngắn</label>
                                    <textarea name="description" class="form-control" rows="5" placeholder="Mô tả về thương hiệu và các sản phẩm chủ đạo..."></textarea>
                                </div>

                                <hr class="my-4 text-secondary opacity-25">

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="/brand" class="btn btn-light px-4 border">Quay lại</a>
                                    <button type="submit" class="btn btn-brand px-4 text-white" style="background-color: #009981; border: none;">
                                        <i class="bi bi-save me-1"></i> Lưu dữ liệu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('logoInput').onchange = evt => {
        const file = evt.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert("File quá lớn! Vui lòng chọn file dưới 2MB.");
                evt.target.value = "";
                return;
            }
            document.getElementById('preview').src = URL.createObjectURL(file);
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/admin/brand/create.blade.php ENDPATH**/ ?>