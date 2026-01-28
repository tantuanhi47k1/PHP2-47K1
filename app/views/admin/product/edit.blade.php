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

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #555;
        }

        .img-edit-preview {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .image-container {
            position: relative;
            display: inline-block;
        }

        .btn-remove-img {
            position: absolute;
            top: -5px;
            right: -5px;
            padding: 0 5px;
            border-radius: 50%;
            font-size: 12px;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-brand m-0">Cập nhật Sản phẩm #<?= $product['id'] ?></h4>
                    <a href="/product" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Quay lại</a>
                </div>

                @if (isset($mess))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><?= $mess ?></div>
                    </div>
                @endif

                <form action="/product/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="card p-4">
                        <div class="row g-4">
                            <div class="col-md-7">
                                <div class="mb-3">
                                    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required
                                        value="<?= htmlspecialchars($product['name']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Giá bán gốc (VND) <span class="text-danger">*</span></label>
                                    <input type="number" name="base_price" class="form-control" required
                                        value="<?= $product['base_price'] ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mô tả ngắn</label>
                                    <textarea name="short_description" class="form-control" rows="2"><?= htmlspecialchars($product['short_description'] ?? '') ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mô tả chi tiết</label>
                                    <textarea name="description" class="form-control" rows="6"><?= htmlspecialchars($product['description']) ?></textarea>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-4">
                                    <label class="form-label">Album hình ảnh</label>
                                    <div class="row g-2 mb-3">
                                        @if (!empty($images))
                                            @foreach ($images as $img)
                                                <div class="col-4 image-container">
                                                    <img src="/<?= $img['image_path'] ?>" class="img-edit-preview">
                                                    @if ($img['is_thumbnail'])
                                                        <span
                                                            class="badge bg-success position-absolute bottom-0 start-0 m-1"
                                                            style="font-size: 10px;">Đại diện</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="col-12"><small class="text-muted fst-italic">Chưa có ảnh
                                                    nào.</small></div>
                                        @endif
                                    </div>
                                    <label class="form-label small text-muted">Thêm ảnh mới (chọn nhiều)</label>
                                    <input type="file" name="images[]" class="form-control form-control-sm" multiple
                                        accept="image/*">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select" required>
                                        @foreach ($categories as $c)
                                            <option value="<?= $c['id'] ?>"
                                                <?= $c['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($c['name']) ?>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Thương hiệu</label>
                                    <select name="brand_id" class="form-select">
                                        <option value="">-- Chọn thương hiệu --</option>
                                        @foreach ($brands as $b)
                                            <option value="<?= $b['id'] ?>"
                                                <?= $product['brand_id'] == $b['id'] ? 'selected' : '' ?>>
                                                <?= $b['name'] ?>
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select">
                                        <?php
                                        $currentStatus = isset($product['status']) ? $product['status'] : 1;
                                        ?>
                                        <option value="1" <?= $currentStatus == 1 ? 'selected' : '' ?>>Đang bán
                                        </option>
                                        <option value="0"
                                            <?= (string) $currentStatus === '0' ? 'selected' : '' ?>>Tạm ẩn</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-brand w-100 fw-bold py-2">
                                    <i class="bi bi-check-lg me-1"></i> Lưu thay đổi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
