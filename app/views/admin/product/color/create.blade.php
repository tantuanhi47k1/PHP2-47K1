@extends('layout.adminLayout')

@section('content')

    <style>
        .text-brand { color: #009981 !important; }
        .btn-brand { background-color: #009981; color: white; border: none; }
        .btn-brand:hover { background-color: #007a67; color: white; }
    </style>

    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 fw-bold text-brand">
                            <i class="bi bi-plus-circle me-2"></i>Thêm mới Màu sắc
                        </h4>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="/color/store" method="POST">                        
                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold text-secondary">Tên gọi</label>
                                <input type="text" 
                                       class="form-control form-control-lg border-2 @isset($errors['name']) is-invalid @endisset" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Ví dụ: Đỏ, Xanh..."
                                       required>
                                @isset($errors['name'])
                                    <div class="invalid-feedback">{{ $errors['name'] }}</div>
                                @endisset
                                <div class="form-text">Lưu ý: Tên không được trùng lặp trong hệ thống.</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/color/index" class="btn btn-light border">
                                    <i class="bi bi-arrow-left me-1"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-brand px-4">
                                    <i class="bi bi-save me-1"></i> Lưu dữ liệu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection