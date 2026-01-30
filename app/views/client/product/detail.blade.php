@extends('layout.clientLayout')

@section('title', $product['name'])

@section('content')
<style>
    :root { 
        --primary-color: #4f46e5; 
        --text-main: #1e293b;
        --text-muted: #64748b;
        --bg-light: #f8fafc;
    }

    body { background-color: #fcfcfc; color: var(--text-main); }

    /* 1. Hình ảnh sản phẩm */
    .product-img-holder {
        background: #fff;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 420px;
        position: relative;
        overflow: hidden;
    }
    .product-detail-img { 
        max-width: 100%;
        max-height: 380px;
        object-fit: contain;
        transition: all 0.4s ease;
    }

    /* 2. Typography */
    .product-name { 
        font-size: 2.2rem;
        font-weight: 800; 
        color: var(--text-main);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .price-display { 
        color: var(--primary-color); 
        font-size: 2rem;
        font-weight: 800; 
        margin-bottom: 1.5rem;
    }

    /* 3. Biến thể (Variants) */
    .variant-selector input[type="radio"] { display: none; }
    .variant-label {
        display: inline-flex;
        align-items: center;
        padding: 10px 18px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-weight: 600;
        font-size: 0.9rem;
        margin-right: 10px;
        margin-bottom: 10px;
        color: var(--text-muted);
        background: white;
    }
    .variant-selector input[type="radio"]:checked + .variant-label {
        border-color: var(--primary-color);
        background: #f5f7ff;
        color: var(--primary-color);
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.1);
    }

    /* 4. Số lượng & Buttons */
    .qty-group {
        background: #fff;
        border-radius: 14px;
        width: fit-content;
        border: 1.5px solid #e2e8f0;
        overflow: hidden;
    }
    .qty-btn {
        width: 42px;
        height: 42px;
        border: none;
        background: #fff;
        transition: 0.2s;
    }
    .qty-btn:hover { background: #f1f5f9; }
    .qty-input {
        border: none;
        width: 50px;
        text-align: center;
        font-weight: 700;
    }

    .btn-add-cart {
        padding: 14px 28px;
        border-radius: 14px;
        font-weight: 700;
        background: var(--text-main);
        border: none;
        transition: 0.3s;
    }
    .btn-add-cart:hover { 
        background: var(--primary-color); 
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(79, 70, 229, 0.2);
    }
    
    .btn-wishlist {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        border: 1.5px solid #e2e8f0;
        color: #94a3b8;
        background: #fff;
        transition: 0.3s;
    }
    .btn-wishlist:hover { color: #ef4444; border-color: #ef4444; background: #fff5f5; }

    /* 5. Khối dịch vụ (Service Badges) */
    .service-item {
        background: #fff;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
    }
    .service-item:hover {
        background: #fff;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    /* 6. Mô tả chi tiết */
    .product-description img {
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        margin: 20px 0;
    }
</style>

<div class="container py-5">
    <div class="row g-5">
        <div class="col-lg-5">
            <div class="sticky-top" style="top: 100px; z-index: 10;">
                <div class="product-img-holder shadow-sm">
                    <img src="/{{ $product['image'] ?? 'image/product/default.png' }}" 
                         class="product-detail-img" 
                         id="main-product-image"
                         alt="{{ $product['name'] }}">
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="ps-lg-3">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted small">Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="/product" class="text-decoration-none text-muted small">Sản phẩm</a></li>
                        <li class="breadcrumb-item active fw-bold text-primary small">{{ $product['name'] }}</li>
                    </ol>
                </nav>

                <div class="d-flex align-items-center gap-2 mb-2">
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2" style="font-size: 0.7rem; letter-spacing: 0.5px;">CAM KẾT CHÍNH HÃNG</span>
                    <span class="text-muted small fw-medium">ID: #{{ $product['id'] }}</span>
                </div>

                <h1 class="product-name">{{ $product['name'] }}</h1>
                
                <div class="price-display">
                    <span id="display-price">{{ number_format($product['variant_price'] ?? $product['base_price'], 0, ',', '.') }}đ</span>
                </div>

                <div class="p-3 mb-4 bg-light rounded-4 border-start border-4 border-primary">
                    <p class="text-muted mb-0 small" style="line-height: 1.6;">
                        {{ $product['short_description'] ?? 'Chào mừng bạn đến với TechHub Shop. Sản phẩm này được bảo hành chính hãng và hỗ trợ trả góp 0%.' }}
                    </p>
                </div>

                <form action="/cart/add" method="POST" id="add-to-cart-form">
                    <input type="hidden" name="id" value="{{ $product['id'] }}"> 
                    <input type="hidden" name="variant_id" id="selected-variant-id" value="">

                    @if(!empty($variants))
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark mb-3">LỰA CHỌN PHIÊN BẢN</label>
                        <div class="variant-selector d-flex flex-wrap">
                            @foreach($variants as $index => $v)
                                <input type="radio" name="variant_option" 
                                       id="variant_{{ $v['id'] }}" 
                                       value="{{ $v['id'] }}"
                                       data-price="{{ $v['price'] }}"
                                       data-image="/{{ $v['image'] }}"
                                       data-price-formatted="{{ number_format($v['price'], 0, ',', '.') }}đ"
                                       {{ $index == 0 ? 'checked' : '' }}>
                                
                                <label class="variant-label shadow-sm" for="variant_{{ $v['id'] }}">
                                    @if(!empty($v['variant_name']))
                                        {{ $v['variant_name'] }}
                                    @elseif(!empty($v['sku']))
                                        {{ str_replace('SKU-', '', $v['sku']) }}
                                    @else
                                        Bản #{{ $index + 1 }}
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="d-flex align-items-center gap-3 mb-5">
                        <div class="qty-group d-flex align-items-center shadow-sm">
                            <button class="qty-btn" type="button" onclick="changeQty(-1)"><i class="bi bi-dash"></i></button>
                            <input type="number" name="quantity" id="quantity" class="qty-input" value="1" min="1">
                            <button class="qty-btn" type="button" onclick="changeQty(1)"><i class="bi bi-plus"></i></button>
                        </div>

                        <button type="submit" class="btn btn-dark btn-add-cart flex-grow-1 ajax-add-cart-detail shadow-sm text-uppercase">
                            <i class="bi bi-cart3 me-2"></i> Thêm vào giỏ hàng
                        </button>

                        <button type="button" class="btn btn-wishlist shadow-sm">
                            <i class="bi bi-heart"></i>
                        </button>
                    </div>
                </form>
                
                <div class="product-services pt-4 border-top">
                    <div class="row g-3">
                        <div class="col-6 col-md-4">
                            <div class="service-item d-flex align-items-center gap-3 p-3 rounded-4">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="bi bi-shield-check fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small">Bảo hành 12th</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">Chính hãng 100%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="service-item d-flex align-items-center gap-3 p-3 rounded-4">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="bi bi-truck fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small">Giao hàng 2h</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">Miễn phí nội thành</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-4">
                            <div class="service-item d-flex align-items-center gap-3 p-3 rounded-4">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                    <i class="bi bi-arrow-repeat fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold small">Đổi trả 7 ngày</div>
                                    <div class="text-muted" style="font-size: 0.7rem;">Lỗi là đổi mới</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-light mt-5 py-5 border-top">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h4 class="fw-bold text-dark mb-0">Thông tin chi tiết</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="product-description" style="line-height: 1.8; color: #475569;">
                            {!! $product['description'] ?? '<p class="text-muted">Đang cập nhật nội dung chi tiết cho sản phẩm này...</p>' !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <h4 class="fw-bold text-dark mb-0">Thông số kỹ thuật</h4>
                    </div>
                    <div class="card-body p-4">
                        <table class="table table-striped table-borderless mb-0 small">
                            <tbody>
                                <tr>
                                    <td class="text-muted py-2">Thương hiệu</td>
                                    <td class="fw-bold py-2 text-end text-primary">{{ $product['brand_name'] ?? 'Đang cập nhật' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Danh mục</td>
                                    <td class="fw-bold py-2 text-end">{{ $product['category_name'] ?? 'Thiết bị điện tử' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Tình trạng</td>
                                    <td class="fw-bold py-2 text-end text-success">Mới 100%</td>
                                </tr>
                                <tr>
                                    <td class="text-muted py-2">Giao hàng</td>
                                    <td class="fw-bold py-2 text-end">Toàn quốc</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-4 p-4 rounded-4 text-white shadow-sm" style="background: linear-gradient(135deg, #4f46e5, #818cf8);">
                    <h6 class="fw-bold mb-3"><i class="bi bi-patch-check me-2"></i>Đặc quyền TechHub</h6>
                    <ul class="list-unstyled mb-0 small opacity-90">
                        <li class="mb-2">- Giảm thêm 5% cho khách hàng cũ</li>
                        <li class="mb-2">- Vệ sinh máy miễn phí định kỳ</li>
                        <li>- Trả góp 0% qua thẻ tín dụng</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const variantRadios = document.querySelectorAll('input[name="variant_option"]');
    const priceDisplay = document.getElementById('display-price');
    const variantIdInput = document.getElementById('selected-variant-id');
    const mainImg = document.getElementById('main-product-image');

    function updateUI() {
        const selected = document.querySelector('input[name="variant_option"]:checked');
        if (selected) {
            priceDisplay.innerText = selected.getAttribute('data-price-formatted');
            variantIdInput.value = selected.value;
            
            const newImgSrc = selected.getAttribute('data-image');
            if (newImgSrc && newImgSrc !== '/') {
                mainImg.style.opacity = '0.4';
                setTimeout(() => {
                    mainImg.src = newImgSrc;
                    mainImg.style.opacity = '1';
                }, 150);
            }
        }
    }

    variantRadios.forEach(radio => radio.addEventListener('change', updateUI));
    document.addEventListener('DOMContentLoaded', updateUI);

    function changeQty(amt) {
        const qtyInput = document.getElementById('quantity');
        let val = parseInt(qtyInput.value) + amt;
        qtyInput.value = val < 1 ? 1 : val;
    }

    document.querySelector('.ajax-add-cart-detail').addEventListener('click', function(e) {
        e.preventDefault();
        const form = document.getElementById('add-to-cart-form');
        const formData = new FormData(form);

        fetch('/cart/add', {
            method: 'POST',
            body: new URLSearchParams(formData)
        })
        .then(response => {
            Swal.fire({
                icon: 'success',
                title: '<span style="font-family: sans-serif; font-size: 1rem;">Đã thêm vào giỏ hàng!</span>',
                showConfirmButton: false,
                timer: 1200,
                toast: true,
                position: 'top-end'
            });
            
            const badge = document.querySelector('.badge-cart');
            if(badge) {
                let current = parseInt(badge.innerText) || 0;
                let added = parseInt(document.getElementById('quantity').value);
                badge.innerText = current + added;
            }
        });
    });
</script>
@endsection