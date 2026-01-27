@extends('layout.adminLayout')

@section('content')
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-4">Chào mừng, <?= $_SESSION['admin_name'] ?>!</h3>
    
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Tổng sản phẩm</small>
                        <h2 class="mb-0 fw-bold">120</h2>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small>Đơn hàng mới</small>
                        <h2 class="mb-0 fw-bold">15</h2>
                    </div>
                    <i class="bi bi-cart-check fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection