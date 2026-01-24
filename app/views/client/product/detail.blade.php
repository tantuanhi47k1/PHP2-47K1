@extends('layout.clientLayout')
@section('title', $product['name'])

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="/uploads/{{ $product['image'] }}" class="img-fluid rounded shadow-sm w-100" alt="{{ $product['name'] }}">
        </div>

        <div class="col-md-6">
            <h1 class="fw-bold">{{ $product['name'] }}</h1>
            <div class="mb-3">
                <span class="badge bg-success">Còn hàng: {{ $product['quantity'] }}</span>
                <span class="badge bg-info">Mã SP: #{{ $product['id'] }}</span>
            </div>

            <div class="fs-4 mb-4">
                @if(!empty($product['sale_price']) && $product['sale_price'] > 0)
                    <span class="text-danger fw-bold me-2">{{ number_format($product['sale_price'], 0, ',', '.') }} đ</span>
                    <span class="text-muted text-decoration-line-through fs-5">{{ number_format($product['price'], 0, ',', '.') }} đ</span>
                @else
                    <span class="fw-bold">{{ number_format($product['price'], 0, ',', '.') }} đ</span>
                @endif
            </div>

            <p class="text-muted">{{ $product['short_description'] ?? '' }}</p>

            <div class="d-grid gap-2 d-md-block mt-4">
                <button class="btn btn-primary btn-lg px-5 me-2" type="button">
                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ
                </button>
                <button class="btn btn-outline-danger btn-lg px-5" type="button">Mua ngay</button>
            </div>

            <hr class="my-4">
            
            <div class="product-description">
                <h5 class="fw-bold">Mô tả sản phẩm</h5>
                <p>{!! nl2br($product['description'] ?? '') !!}</p>
            </div>
        </div>
    </div>
</div>
@endsection