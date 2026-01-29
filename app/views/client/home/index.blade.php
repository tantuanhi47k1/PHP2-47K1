@extends('layout.clientLayout')

@section('title', 'Trang chủ - My Shop')

@section('content')

{{-- 1. Banner quảng cáo --}}
<div class="bg-light py-5 mb-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold text-primary">Siêu Sale Mùa Hè</h1>
        <p class="lead text-muted mb-4">Giảm giá lên đến 50% cho các sản phẩm công nghệ.</p>
        <a href="/product" class="btn btn-primary btn-lg rounded-pill px-5">Mua ngay</a>
    </div>
</div>

{{-- 2. Danh sách sản phẩm nổi bật --}}
<div class="container mb-5">
    <h3 class="fw-bold mb-4 border-start border-4 border-primary ps-3">Sản phẩm mới nhất</h3>
    
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        @if(!empty($products))
            @foreach($products as $p)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm product-card">
                    {{-- Ảnh sản phẩm --}}
                    <div class="position-relative overflow-hidden">
                        <a href="/product/detail/{{ $p['id'] }}">
                            <img src="/public/image/product/{{ $p['image'] }}" class="card-img-top" alt="{{ $p['name'] }}"
                                 onerror="this.src='https://placehold.co/300x300?text=No+Image'">
                        </a>
                        {{-- Badge giảm giá (nếu có) --}}
                        @if($p['sale_price'] > 0)
                            <span class="position-absolute top-0 start-0 bg-danger text-white badge m-2">-Sale</span>
                        @endif
                    </div>

                    <div class="card-body">
                        {{-- Tên sản phẩm --}}
                        <h6 class="card-title text-truncate">
                            <a href="/product/detail/{{ $p['id'] }}" class="text-decoration-none text-dark fw-bold">
                                {{ $p['name'] }}
                            </a>
                        </h6>
                        
                        {{-- Giá --}}
                        <div class="d-flex align-items-center">
                            @if($p['sale_price'] > 0)
                                <span class="fw-bold text-danger me-2">{{ number_format($p['sale_price']) }}đ</span>
                                <small class="text-muted text-decoration-line-through">{{ number_format($p['price']) }}đ</small>
                            @else
                                <span class="fw-bold text-dark">{{ number_format($p['price']) }}đ</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top-0 p-3">
                        <button class="btn btn-outline-primary w-100 btn-sm rounded-pill">
                            <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center text-muted py-5">Chưa có sản phẩm nào.</div>
        @endif
    </div>
</div>

@endsection