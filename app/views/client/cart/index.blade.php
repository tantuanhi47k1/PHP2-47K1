@extends('layout.clientLayout')

@section('title', 'Giỏ hàng của bạn')

@section('content')

<style>
    .cart-container { background-color: #f8f9fa; min-height: 80vh; }
    .cart-item { transition: background 0.2s; border-bottom: 1px solid #eee; }
    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background-color: #fff; }
    
    .qty-input-group { width: 120px; }
    .qty-btn { border: 1px solid #dee2e6; background: #fff; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; }
    .qty-btn:hover { background: #f1f3f5; }
    .qty-input { border: 1px solid #dee2e6; border-left: none; border-right: none; text-align: center; width: 50px; height: 35px; }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    
    .summary-card { position: sticky; top: 100px; border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-radius: 16px; }
    .btn-remove { color: #adb5bd; transition: 0.2s; font-size: 0.9rem; }
    .btn-remove:hover { color: #dc3545; text-decoration: underline; }
</style>

<div class="cart-container py-5">
    <div class="container">
        
        <div class="d-flex align-items-center mb-4">
            <h2 class="fw-bold mb-0">Giỏ hàng</h2>
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill ms-3 fs-6">
                {{ isset($cart) ? count($cart) : 0 }} sản phẩm
            </span>
        </div>

        @if(isset($_SESSION['success']))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {!! $_SESSION['success'] !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @php unset($_SESSION['success']); @endphp
        @endif

        @if(isset($cart) && count($cart) > 0)
            <form action="/cart/update" method="POST">
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                            <div class="card-header bg-white py-3 border-bottom">
                                <div class="row fw-bold text-secondary small text-uppercase">
                                    <div class="col-6">Sản phẩm</div>
                                    <div class="col-3 text-center">Số lượng</div>
                                    <div class="col-3 text-end">Tạm tính</div>
                                </div>
                            </div>
                            
                            <div class="card-body p-0">
                                @foreach($cart as $id => $item)
                                    <div class="row align-items-center p-3 cart-item mx-0">
                                        <div class="col-6 d-flex align-items-center">
                                            <a href="/product/detail/{{ $id }}">
                                                <img src="/{{ $item['image'] ?? 'image/product/default.png' }}" 
                                                     alt="{{ $item['name'] }}" 
                                                     class="rounded-3 border" 
                                                     style="width: 70px; height: 70px; object-fit: cover;">
                                            </a>
                                            <div class="ms-3">
                                                <h6 class="fw-bold mb-1 text-truncate" style="max-width: 200px;">
                                                    <a href="/product/detail/{{ $id }}" class="text-dark text-decoration-none">
                                                        {{ $item['name'] }}
                                                    </a>
                                                </h6>
                                                <div class="small text-muted mb-2">{{ number_format($item['price']) }}đ</div>
                                                <a href="/cart/remove/{{ $id }}" class="btn-remove p-0 border-0 bg-transparent" onclick="return confirm('Bạn chắc chắn muốn xóa sản phẩm này?')">
                                                    <i class="bi bi-trash"></i> Xóa
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-3 d-flex justify-content-center">
                                            <div class="input-group qty-input-group">
                                                <input type="number" name="quantity[{{ $id }}]" value="{{ $item['quantity'] }}" min="1" class="form-control text-center rounded">
                                            </div>
                                        </div>

                                        <div class="col-3 text-end fw-bold text-primary fs-6">
                                            {{ number_format($item['price'] * $item['quantity']) }}đ
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="/" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
                                <i class="bi bi-arrow-left me-2"></i> Tiếp tục mua sắm
                            </a>
                            <button type="submit" class="btn btn-warning text-dark rounded-pill px-4 fw-bold shadow-sm">
                                <i class="bi bi-arrow-clockwise me-2"></i> Cập nhật giỏ hàng
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card summary-card p-4 bg-white">
                            <h5 class="fw-bold mb-4">Cộng giỏ hàng</h5>
                            
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Tổng tiền hàng:</span>
                                <span class="fw-bold">{{ number_format($totalPrice) }}đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Giảm giá:</span>
                                <span class="text-success">-0đ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-muted">Vận chuyển:</span>
                                <span class="text-success fw-bold">Miễn phí</span>
                            </div>
                            
                            <hr class="border-secondary border-opacity-10 my-4">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold fs-5">TỔNG CỘNG:</span>
                                <span class="fw-bold fs-4 text-primary">{{ number_format($totalPrice) }}đ</span>
                            </div>

                            <div class="d-grid mb-3">
                                <a href="/checkout" class="btn btn-primary btn-lg rounded-pill fw-bold shadow py-3">
                                    TIẾN HÀNH THANH TOÁN
                                </a>
                            </div>

                            <div class="d-flex align-items-center justify-content-center text-muted small gap-2">
                                <i class="bi bi-shield-lock-fill"></i> Bảo mật thanh toán 100%
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <div class="mb-4">
                    <i class="bi bi-cart-x text-muted opacity-25" style="font-size: 5rem;"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Giỏ hàng của bạn đang trống!</h4>
                <p class="text-muted mb-4">Hãy chọn thêm vài món đồ xịn xò vào nhé.</p>
                <a href="/" class="btn btn-primary btn-lg rounded-pill fw-bold px-5 shadow-sm">
                    MUA SẮM NGAY
                </a>
            </div>
        @endif
        
    </div>
</div>

@endsection