@extends('layout.clientLayout')
@section('title', 'Sản phẩm yêu thích')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h3 class="fw-bold">Sản phẩm yêu thích ❤️</h3>
        <p class="text-muted">Danh sách những món đồ công nghệ bạn đang quan tâm</p>
    </div>

    @if(empty($products))
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-heartbreak text-muted opacity-25" style="font-size: 5rem;"></i>
            </div>
            <h5 class="text-muted">Danh sách trống!</h5>
            <p class="mb-4">Bạn chưa yêu thích sản phẩm nào cả.</p>
            <a href="/product" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-search me-2"></i>Khám phá sản phẩm ngay
            </a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach($products as $item)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 product-card position-relative">

                        <div class="position-relative bg-light rounded-top-4 overflow-hidden product-img-frame" style="padding-top: 100%;">
                            <a href="/product/detail/{{ $item['id'] }}">
                                @php
                                    $imgSrc = !empty($item['image']) ? '/' . $item['image'] : 'https://placehold.co/300x300?text=No+Image';
                                @endphp
                                
                                <img src="{{ $imgSrc }}" 
                                     class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain p-4 transition-transform"
                                     alt="{{ $item['name'] }}"
                                     onerror="this.onerror=null; this.src='https://placehold.co/300x300?text=TechHub';">
                            </a>
                            
                            {{-- Nút xóa (X) --}}
                            <button class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle shadow-sm remove-fav-btn d-flex align-items-center justify-content-center" 
                                    style="width: 32px; height: 32px;"
                                    data-id="{{ $item['id'] }}" 
                                    title="Bỏ thích">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <div class="card-body text-center d-flex flex-column">
                            <h6 class="text-truncate fw-bold mb-2">
                                <a href="/product/detail/{{ $item['id'] }}" class="text-decoration-none text-dark stretched-link">
                                    {{ $item['name'] ?? 'Sản phẩm chưa đặt tên' }}
                                </a>
                            </h6>
                            
                            <div class="text-primary fw-bold mb-3 fs-5">
                                {{ number_format($item['base_price'] ?? 0, 0, ',', '.') }}đ
                            </div>
                            
                            <div class="mt-auto">
                                <a href="/product/detail/{{ $item['id'] }}" class="btn btn-outline-primary rounded-pill w-100 btn-sm fw-bold position-relative" style="z-index: 2;">
                                    Xem chi tiết
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<style>
    .product-img-frame img {
        transition: transform 0.3s ease;
    }
    .product-card:hover .product-img-frame img {
        transform: scale(1.05);
    }
    .remove-fav-btn {
        z-index: 10;
        opacity: 0.8;
        transition: all 0.2s;
    }
    .remove-fav-btn:hover {
        opacity: 1;
        transform: scale(1.1);
    }
</style>

<script>
    document.querySelectorAll('.remove-fav-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            if(!confirm('Bạn có chắc muốn bỏ sản phẩm này khỏi danh sách yêu thích?')) return;
            
            const productId = this.getAttribute('data-id');
            const cardCol = this.closest('.col');

            cardCol.style.opacity = '0.5';

            const formData = new FormData();
            formData.append('product_id', productId);

            fetch('/favorite/toggle', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success' && data.action === 'removed') {
                    cardCol.remove();

                    if(document.querySelectorAll('.remove-fav-btn').length === 0) {
                        location.reload();
                    }
                } else {
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                    cardCol.style.opacity = '1';
                }
            })
            .catch(err => {
                console.error(err);
                cardCol.style.opacity = '1';
            });
        });
    });
</script>
@endsection