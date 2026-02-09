@extends('layout.clientLayout')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 p-5">
                <div class="mb-4 text-success">
                    <i class="bi bi-check-circle-fill" style="font-size: 5rem;"></i>
                </div>
                
                <h2 class="fw-bold mb-3">Đặt hàng thành công!</h2>
                <p class="text-muted mb-4">
                    Cảm ơn bạn đã tin tưởng TechHub.<br>
                    Đơn hàng của bạn đang được xử lý và sẽ sớm được giao đến bạn.
                </p>

                <div class="d-flex justify-content-center gap-3">
                    <a href="/shop" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm
                    </a>
                    <a href="/profile/orders" class="btn btn-primary rounded-pill px-4 shadow fw-bold">
                        Xem đơn hàng <i class="bi bi-box-seam ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        localStorage.removeItem('cart');

        const badges = document.querySelectorAll('.badge-cart');
        badges.forEach(el => {
            el.innerText = '0';
            el.style.display = 'none';
        });
    });
</script>
@endsection