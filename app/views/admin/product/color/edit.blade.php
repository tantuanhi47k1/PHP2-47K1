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
                            <i class="bi bi-pencil-square me-2"></i>Chỉnh sửa thông tin
                        </h4>
                    </div>
                    
                    <div class="card-body p-4">
                        <form action="/color/update/<?= $item['id'] ?>" method="POST">
                            
                            <div class="mb-3">
                                <label class="form-label text-muted small">ID Color: #<?= $item['id'] ?></label>
                            </div>

                            <div class="mb-4">
                                <label for="name" class="form-label fw-bold text-secondary">Tên gọi mới</label>
                                <input type="text" 
                                       class="form-control form-control-lg border-2" 
                                       id="name" 
                                       name="name" 
                                       value="<?= htmlspecialchars($item['name']) ?>"
                                       required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="/color/index" class="btn btn-light border">
                                    <i class="bi bi-x-lg me-1"></i> Hủy bỏ
                                </a>
                                <button type="submit" class="btn btn-brand px-4">
                                    <i class="bi bi-check-lg me-1"></i> Cập nhật ngay
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection