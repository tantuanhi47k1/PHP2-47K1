@extends('layout.adminLayout')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="mb-3">
                <a href="/variant/index/{{ $product['id'] }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left"></i> Quay lại quản lý biến thể
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-pencil-square me-2"></i>Chỉnh sửa biến thể
                    </h5>
                    <small class="text-muted">Sản phẩm: <strong>{{ $product['name'] }}</strong></small>
                </div>
                
                <div class="card-body p-4">
                    <form action="/variant/update/{{ $variant['id'] }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">

                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary small uppercase">Tên phiên bản (Hiển thị khách hàng)</label>
                            <input type="text" name="variant_name" value="{{ $variant['variant_name'] }}" 
                                   class="form-control shadow-sm border-primary border-opacity-25" 
                                   placeholder="VD: Màu Đen, Bản 256GB..." required>
                            <div class="form-text small">Tên này sẽ hiện thị thay cho mã SKU trên trang chi tiết sản phẩm.</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-bold text-secondary small uppercase">Cấu hình thuộc tính</label>
                                <div class="p-3 bg-light rounded-3 border">
                                    @foreach($attributes as $attr)
                                    <div class="mb-3 last-child-mb-0">
                                        <label class="form-label small fw-semibold">{{ $attr['name'] }}</label>
                                        <select name="attribute_values[]" class="form-select shadow-sm" required>
                                            <option value="">-- Chọn {{ $attr['name'] }} --</option>
                                            @foreach($attr['values'] as $val)
                                                <option value="{{ $val['id'] }}" 
                                                    {{ in_array($val['id'], $selectedIds) ? 'selected' : '' }}>
                                                    {{ $val['value'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold small text-secondary">Giá bán riêng (đ)</label>
                                <div class="input-group">
                                    <input type="number" name="price" value="{{ (int)$variant['price'] }}" 
                                           class="form-control shadow-sm fw-bold text-primary" required>
                                    <span class="input-group-text">₫</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-secondary">Số lượng tồn kho</label>
                                <input type="number" name="stock" value="{{ $variant['stock_quantity'] }}" 
                                       class="form-control shadow-sm" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-secondary">Hình ảnh biến thể</label>
                            <div class="d-flex align-items-start gap-3 p-3 border rounded-3 bg-light">
                                <div class="text-center">
                                    <p class="small text-muted mb-1">Hiện tại</p>
                                    <img src="/{{ $variant['image'] ?? $product['image'] }}" 
                                         class="rounded border shadow-sm object-fit-cover" 
                                         style="width: 100px; height: 100px;"
                                         onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="small text-muted mb-1">Thay đổi ảnh mới</p>
                                    <input type="file" name="image" class="form-control form-control-sm shadow-sm">
                                    <ul class="small text-muted mt-2 ps-3 mb-0">
                                        <li>Để trống nếu muốn giữ nguyên ảnh hiện tại.</li>
                                        <li>Định dạng: JPG, PNG, WebP. Tối đa 2MB.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                                <i class="bi bi-check-lg me-2"></i>Lưu thay đổi
                            </button>
                            <a href="/variant/index/{{ $product['id'] }}" class="btn btn-outline-secondary px-4">
                                Hủy bỏ
                            </a>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light border-top-0 py-3 px-4">
                    <div class="d-flex align-items-center text-muted small">
                        <i class="bi bi-info-circle me-2"></i>
                        Mã SKU hiện tại: <span class="badge bg-secondary ms-1">{{ $variant['sku'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .last-child-mb-0:last-child { margin-bottom: 0 !important; }
    .object-fit-cover { object-fit: cover; }
</style>
@endsection