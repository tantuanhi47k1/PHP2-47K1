

<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --primary-color: #009981;
            --primary-hover: #007a67;
        }

        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
        }

        .text-brand { color: var(--primary-color) !important; }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .form-label.required::after {
            content: " *";
            color: red;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-brand mb-0">Cập nhật Danh mục</h4>
                    <a href="/category" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>

                <?php if(isset($mess)): ?>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div><?= $mess ?></div>
                </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="text-uppercase text-muted small fw-bold">ID Danh mục: #<?= $category['id'] ?></h6>
                    </div>
                    <div class="card-body p-4">
                        <form action="/category/update/<?= $category['id'] ?>" method="POST">
                            <div class="mb-3">
                                <label class="form-label required fw-bold text-secondary">Tên danh mục</label>
                                <input type="text" name="name" class="form-control"
                                    value="<?= htmlspecialchars($category['name']) ?>" required>
                                <div class="form-text small">Slug sẽ tự động cập nhật theo tên mới.</div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary py-2 fw-bold">
                                    <i class="bi bi-check-lg me-1"></i> Lưu thay đổi
                                </button>
                                <a href="/category" class="btn btn-light text-muted border-0 mt-2">Hủy bỏ</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/category/edit.blade.php ENDPATH**/ ?>