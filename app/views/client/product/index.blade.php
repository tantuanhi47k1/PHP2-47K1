@extends('layout.clientLayout')

@section('title', 'Cửa Hàng')

@section('content')
<div class="container">
    <h2 class="text-center mb-4 fw-bold">Tất Cả Sản Phẩm</h2>
    <div class="row">
        @foreach ($products as $item)
            @if(isset($item['status']) && $item['status'] == 1) 
            <div class="col-md-3 col-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="position-relative">
                        <img src="/uploads/{{ $item['image'] }}" class="card-img-top" alt="{{ $item['name'] }}" style="height: 250px; object-fit: cover;">
                        
                        @if(!empty($item['sale_price']) && $item['sale_price'] > 0)
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                -{{ round((($item['price'] - $item['sale_price'])/$item['price'])*100) }}%
                            </span>
                        @endif
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title text-truncate">
                            <a href="/product/detail/{{ $item['id'] }}" class="text-decoration-none text-dark">
                                {{ $item['name'] }}
                            </a>
                        </h5>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            @if(!empty($item['sale_price']) && $item['sale_price'] > 0)
                                <span class="text-danger fw-bold">{{ number_format($item['sale_price'], 0, ',', '.') }} đ</span>
                                <span class="text-muted text-decoration-line-through small">{{ number_format($item['price'], 0, ',', '.') }} đ</span>
                            @else
                                <span class="fw-bold">{{ number_format($item['price'], 0, ',', '.') }} đ</span>
                            @endif
                        </div>
                        <a href="/product/detail/{{ $item['id'] }}" class="btn btn-outline-primary btn-sm mt-3 w-100">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>
@endsection