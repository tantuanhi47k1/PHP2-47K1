@extends('layout.adminLayout')

@section('content')
<style>
    .text-brand { color: #009981 !important; }
    .btn-brand { background-color: #009981; color: white; }
    .btn-brand:hover { background-color: #007a67; color: white; }
    #image-preview { max-width: 200px; border-radius: 8px; display: none; margin-top: 10px; border: 1px solid #ddd; }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-brand">
                        <i class="bi bi-plus-square-dotted me-2"></i>THÊM BIẾN THỂ MỚI
                    </h5>
                    <small class="text-muted">Sản phẩm: <span class="fw-bold text-dark"><?= htmlspecialchars($product['name']) ?></span></small>
                </div>
                <div class="card-body p-4">
                    <form action="/variant/store/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Tên biến thể (Ví dụ: iPhone 17 - Màu Cam)</label>
                                <input type="text" name="variant_name" class="form-control" 
                                       placeholder="Nhập tên gọi cụ thể cho phiên bản này..." required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Mã SKU (Duy nhất)</label>
                                <input type="text" name="sku" class="form-control" placeholder="VD: IP17-ORANGE-128" required>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Giá biến thể (VNĐ)</label>
                                <input type="number" name="price" class="form-control" placeholder="0" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Số lượng tồn kho</label>
                                <input type="number" name="stock_quantity" class="form-control" value="0" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-primary"><i class="bi bi-image me-1"></i>Ảnh riêng cho biến thể này</label>
                                <input type="file" name="variant_image" class="form-control" accept="image/*" onchange="previewImage(this)">
                                <small class="text-muted d-block mt-1">Chọn ảnh đúng với màu sắc hoặc đặc điểm của biến thể này.</small>
                                <img id="image-preview" src="#" alt="Preview">
                            </div>

                            <hr class="my-3">
                            <h6 class="fw-bold text-muted"><i class="bi bi-tags me-1"></i> Lựa chọn thuộc tính</h6>

                            <?php foreach($attributes as $attr): ?>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold"><?= htmlspecialchars($attr['name']) ?></label>
                                <select name="attributes[]" class="form-select" required>
                                    <option value="">-- Chọn <?= htmlspecialchars($attr['name']) ?> --</option>
                                    <?php foreach($attr['values'] as $val): ?>
                                        <option value="<?= $val['id'] ?>"><?= htmlspecialchars($val['value']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <?php endforeach; ?>

                            <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                                <a href="/variant/index/<?= $product['id'] ?>" class="btn btn-light border px-4">Hủy bỏ</a>
                                <button type="submit" class="btn btn-brand px-4">
                                    Xác nhận thêm
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
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection