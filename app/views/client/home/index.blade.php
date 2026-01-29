@extends('layout.clientLayout')

@section('title', 'Cửa Hàng')

@section('content')

<style>
    .product-img-frame {
        position: relative;
        width: 100%;
        padding-top: 100%;
        overflow: hidden;
        background-color: #fff;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-img-frame img {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        object-fit: contain;
        padding: 15px;
        transition: transform 0.5s ease;
    }

    .product-card {
        transition: all 0.3s ease;
        border: 1px solid #eee;
    }

    .product-card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        transform: translateY(-5px);
        border-color: transparent;
    }

    .product-card:hover .product-img-frame img {
        transform: scale(1.1);
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
        <h3 class="fw-bold text-dark border-start border-4 border-primary ps-3 mb-0">
            Tất Cả Sản Phẩm
        </h3>
        <span class="text-muted small">{{ count($products) }} sản phẩm</span>
    </div>

    @if(isset($_SESSION['success']))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ $_SESSION['success'] }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @php unset($_SESSION['success']); @endphp
    @endif

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @if(!empty($products))
            @foreach ($products as $item)
                @if(isset($item['status']) && $item['status'] == 1) 
                <div class="col">
                    <div class="card h-100 shadow-sm product-card rounded-3 overflow-hidden">

                        <div class="position-relative product-img-frame">
                            <a href="/product/detail/{{ $item['id'] }}">
                                <img src="/{{ $item['image'] ?? 'image/product/default.png' }}" 
                                     alt="{{ $item['name'] }}"
                                     onerror="this.src='https://placehold.co/300x300?text=No+Image'">
                            </a>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-truncate mb-2">
                                <a href="/product/detail/{{ $item['id'] }}" class="text-decoration-none text-dark fw-bold" title="{{ $item['name'] }}">
                                    {{ $item['name'] }}
                                </a>
                            </h6>

                            <div class="mb-3 text-primary">
                                @if(isset($item['variant_price']) && $item['variant_price'] > 0)
                                    <small class="text-muted text-dark">Giá từ:</small> 
                                    <span class="fw-bold fs-5">{{ number_format($item['variant_price'], 0, ',', '.') }}đ</span>
                                
                                @elseif(isset($item['base_price']))
                                    <span class="fw-bold fs-5">{{ number_format($item['base_price'], 0, ',', '.') }}đ</span>
                                @else
                                    <span class="text-muted small">Liên hệ</span>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <form action="/cart/add" method="POST">
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <input type="hidden" name="quantity" value="1">
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill fw-bold hover-shadow">
                                            <i class="bi bi-cart-plus me-1"></i> Thêm vào giỏ
                                        </button>
                                        <a href="/product/detail/{{ $item['id'] }}" class="btn btn-primary btn-sm rounded-pill fw-bold text-white shadow-sm">
                                            Xem chi tiết
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        @else
            <div class="col-12 text-center py-5">
                <i class="bi bi-box2 text-muted opacity-25" style="font-size: 4rem;"></i>
                <p class="text-muted mt-3 fs-5">Chưa có sản phẩm nào trong hệ thống.</p>
                <a href="/" class="btn btn-outline-primary rounded-pill mt-2">Quay về trang chủ</a>
            </div>
        @endif
    </div>
</div>
@endsection