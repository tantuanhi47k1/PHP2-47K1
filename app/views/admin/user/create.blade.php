@extends('layout.adminLayout')

@section('content')
<style>
    .text-brand { color: #009981 !important; }
    .btn-brand { background-color: #009981; color: white; }
    .btn-brand:hover { background-color: #007a67; color: white; }
    #preview-avatar { width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #009981; display: none; margin: 10px auto; }
    .placeholder-avatar { width: 100px; height: 100px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; margin: 10px auto; color: #ccc; font-size: 2rem; border: 2px dashed #ddd; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-brand"><i class="bi bi-person-plus-fill me-2"></i>Thêm thành viên mới</h5>
                    <a href="/user/index" class="btn btn-outline-secondary btn-sm">Quay lại danh sách</a>
                </div>
                <div class="card-body p-4">
                    <form action="/user/store" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <label class="form-label d-block fw-bold small text-muted text-uppercase">Ảnh đại diện</label>
                                <div id="avatar-container">
                                    <div class="placeholder-avatar" id="placeholder"><i class="bi bi-person"></i></div>
                                    <img id="preview-avatar" src="#">
                                </div>
                                <div class="mt-3 mx-auto" style="max-width: 300px;">
                                    <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*" onchange="previewFile(this)">
                                    <small class="text-muted">Định dạng hỗ trợ: JPG, PNG, WEBP.</small>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control" placeholder="Nhập đầy đủ họ tên..." required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Địa chỉ Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" placeholder="vi-du@gmail.com" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" placeholder="09xx xxx xxx">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Mật khẩu khởi tạo <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                                <small class="text-muted">Mật khẩu sẽ được mã hóa tự động khi lưu.</small>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold small">Địa chỉ liên hệ</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="Số nhà, tên đường, tỉnh thành..."></textarea>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-brand w-100 fw-bold py-2 shadow-sm">
                                    <i class="bi bi-check-circle-fill me-1"></i> Xác nhận tạo tài khoản
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
    function previewFile(input) {
        const preview = document.getElementById('preview-avatar');
        const placeholder = document.getElementById('placeholder');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection