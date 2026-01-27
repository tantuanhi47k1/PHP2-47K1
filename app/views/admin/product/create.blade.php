@extends('layout.adminLayout')
@section('content')
    <style>
        :root { --primary-color: #009981; }
        .text-brand { color: var(--primary-color) !important; }
        .btn-brand { background-color: var(--primary-color); color: white; }
        .btn-brand:hover { background-color: #007a67; color: white; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); border-radius: 0.5rem; }
        .form-label { font-weight: 600; font-size: 0.9rem; color: #555; }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-brand m-0">Thêm Sản phẩm mới</h4>
                    <a href="/product" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Quay lại
                    </a>
                </div>

                @if (isset($mess))
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><?= $mess ?></div>
                    </div>
                @endif

                <form action="/product/store" method="POST" enctype="multipart/form-data">
                    <div class="card p-4">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" required placeholder="Nhập tên sản phẩm...">
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Giá bán gốc (VND) <span class="text-danger">*</span></label>
                                        <input type="number" name="base_price" class="form-control" required placeholder="500000">
                                        <small class="text-muted">Giá này sẽ là giá mặc định nếu biến thể không có giá riêng.</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mô tả ngắn</label>
                                    <textarea name="short_description" class="form-control" rows="2"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mô tả chi tiết</label>
                                    <textarea name="description" class="form-control" rows="5"></textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Hình ảnh sản phẩm</label>
                                    <input type="file" name="images[]" class="form-control" multiple accept="image/*">
                                    <div class="form-text text-muted small">Có thể chọn nhiều ảnh cùng lúc. Ảnh đầu tiên sẽ là ảnh đại diện.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-select" required>
                                        <option value="">-- Chọn danh mục --</option>
                                        @foreach ($categories as $c)
                                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Thương hiệu</label>
                                    <select name="brand_id" class="form-select">
                                        <option value="">-- Chọn thương hiệu --</option>
                                        @foreach ($brands as $b)
                                            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['name']) ?></option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Trạng thái</label>
                                    <select name="status" class="form-select">
                                        <option value="1">Đang bán</option>
                                        <option value="0">Tạm ẩn</option>
                                    </select>
                                </div>

                                <div class="alert alert-info small">
                                    <i class="bi bi-info-circle me-1"></i> Sau khi lưu, bạn có thể thêm các biến thể (Size, Màu sắc) cho sản phẩm này.
                                </div>

                                <hr>
                                <button type="submit" class="btn btn-brand w-100 fw-bold py-2">
                                    <i class="bi bi-save me-1"></i> Lưu sản phẩm
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection