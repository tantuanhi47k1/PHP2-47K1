@extends('layout.adminLayout')

@section('content')
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
        }

        .btn-brand:hover {
            background-color: #007a67;
            color: white;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-brand m-0">Sửa Thương hiệu #<?= $brand['id'] ?></h4>
                    <a href="/brand" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>

                @if (isset($mess))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><?= $mess ?></div>
                    </div>
                @endif

                <form action="/brand/update/<?= $brand['id'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="card p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên thương hiệu <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required
                                value="<?= htmlspecialchars($brand['name']) ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Logo hiện tại</label>
                            <div class="mb-2">
                                <?php if(!empty($brand['logo'])): ?>
                                    <img src="/<?= $brand['logo'] ?>" class="img-thumbnail" style="height: 80px; object-fit: contain;">
                                <?php else: ?>
                                    <span class="text-muted small fst-italic">Chưa có logo</span>
                                <?php endif; ?>
                            </div>
                            <label class="form-label small text-muted">Thay logo mới</label>
                            <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Mô tả</label>
                            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($brand['description'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-brand w-100 fw-bold py-2">
                            <i class="bi bi-check-lg me-1"></i> Cập nhật thương hiệu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection