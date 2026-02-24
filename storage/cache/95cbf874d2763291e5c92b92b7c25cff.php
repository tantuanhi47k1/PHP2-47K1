

<?php $__env->startSection('title', 'Giỏ hàng của bạn'); ?>

<?php $__env->startSection('content'); ?>

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

    .d-none { display: none !important; }
</style>

<div class="cart-container py-5">
    <div class="container">
        
        <div class="d-flex align-items-center mb-4">
            <h2 class="fw-bold mb-0">Giỏ hàng</h2>
            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill ms-3 fs-6">
                <span id="cart-count-page">0</span> sản phẩm
            </span>
        </div>

        <div id="cart-has-items" class="d-none">
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
                        
                        <div class="card-body p-0" id="cart-list">
                            </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="/" class="btn btn-outline-secondary rounded-pill px-4 fw-bold">
                            <i class="bi bi-arrow-left me-2"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card summary-card p-4 bg-white">
                        <h5 class="fw-bold mb-4">Cộng giỏ hàng</h5>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Tổng tiền hàng:</span>
                            <span class="fw-bold" id="subtotal-price">0đ</span>
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
                            <span class="fw-bold fs-4 text-primary" id="final-total-price">0đ</span>
                        </div>

                        <div class="d-grid mb-3">
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <a href="/checkout" class="btn btn-primary btn-lg rounded-pill fw-bold shadow py-3">
                                    TIẾN HÀNH THANH TOÁN
                                </a>
                            <?php else: ?>
                                <a href="#" onclick="requireLogin(event)" class="btn btn-primary btn-lg rounded-pill fw-bold shadow py-3">
                                    TIẾN HÀNH THANH TOÁN
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="d-flex align-items-center justify-content-center text-muted small gap-2">
                            <i class="bi bi-shield-lock-fill"></i> Bảo mật thanh toán 100%
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="cart-empty" class="text-center py-5 bg-white rounded-4 shadow-sm d-none">
            <div class="mb-4">
                <i class="bi bi-cart-x text-muted opacity-25" style="font-size: 5rem;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Giỏ hàng của bạn đang trống!</h4>
            <p class="text-muted mb-4">Hãy chọn thêm vài món đồ xịn xò vào nhé.</p>
            <a href="/" class="btn btn-primary btn-lg rounded-pill fw-bold px-5 shadow-sm">
                MUA SẮM NGAY
            </a>
        </div>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const formatCurrency = (amount) => {
        return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(amount);
    };

    function renderCartPage() {
        const cart = getCart();
        const cartList = document.getElementById('cart-list');
        const hasItemsDiv = document.getElementById('cart-has-items');
        const emptyDiv = document.getElementById('cart-empty');
        const countSpan = document.getElementById('cart-count-page');
        
        const subtotalSpan = document.getElementById('subtotal-price');
        const finalTotalSpan = document.getElementById('final-total-price');

        const totalQty = cart.reduce((sum, item) => sum + parseInt(item.quantity), 0);
        countSpan.innerText = totalQty;

        if (cart.length === 0) {
            hasItemsDiv.classList.add('d-none');
            emptyDiv.classList.remove('d-none');
        } else {
            hasItemsDiv.classList.remove('d-none');
            emptyDiv.classList.add('d-none');
            cartList.innerHTML = '';

            let totalPrice = 0;

            cart.forEach((item, index) => {
                let itemTotal = item.price * item.quantity;
                totalPrice += itemTotal;

                let displayName = item.name;
                if(item.variant_name) {
                    displayName += ` <span class="badge bg-light text-dark border ms-1">${item.variant_name}</span>`;
                }

                const row = `
                    <div class="row align-items-center p-3 cart-item mx-0">
                        <div class="col-6 d-flex align-items-center">
                            <a href="/product/detail/${item.id}">
                                <img src="${item.image}" 
                                     alt="${item.name}" 
                                     class="rounded-3 border" 
                                     style="width: 70px; height: 70px; object-fit: cover;">
                            </a>
                            <div class="ms-3">
                                <h6 class="fw-bold mb-1 text-truncate" style="max-width: 250px;">
                                    <a href="/product/detail/${item.id}" class="text-dark text-decoration-none">
                                        ${displayName}
                                    </a>
                                </h6>
                                <div class="small text-muted mb-2">${formatCurrency(item.price)}</div>
                                <button onclick="removeItem(${index})" class="btn-remove p-0 border-0 bg-transparent">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </div>
                        </div>

                        <div class="col-3 d-flex justify-content-center">
                            <div class="input-group qty-input-group">
                                <button class="qty-btn" onclick="updateItemQty(${index}, -1)"><i class="bi bi-dash"></i></button>
                                <input type="number" readonly value="${item.quantity}" class="form-control text-center rounded qty-input">
                                <button class="qty-btn" onclick="updateItemQty(${index}, 1)"><i class="bi bi-plus"></i></button>
                            </div>
                        </div>

                        <div class="col-3 text-end fw-bold text-primary fs-6">
                            ${formatCurrency(itemTotal)}
                        </div>
                    </div>
                `;
                cartList.insertAdjacentHTML('beforeend', row);
            });

            subtotalSpan.innerText = formatCurrency(totalPrice);
            finalTotalSpan.innerText = formatCurrency(totalPrice);
        }
    }

    function updateItemQty(index, change) {
        let cart = getCart();
        if (cart[index]) {
            let newQty = parseInt(cart[index].quantity) + change;
            if (newQty > 0) {
                cart[index].quantity = newQty;
                saveCart(cart);
                renderCartPage();
            }
        }
    }

    function removeItem(index) {
        Swal.fire({
            title: 'Bạn chắc chắn?',
            text: "Muốn xóa sản phẩm này khỏi giỏ hàng?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đúng, xóa nó!',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                let cart = getCart();
                cart.splice(index, 1);
                saveCart(cart);
                renderCartPage();
                
                Swal.fire(
                    'Đã xóa!',
                    'Sản phẩm đã được xóa khỏi giỏ hàng.',
                    'success'
                )
            }
        })
    }

    function requireLogin(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Chưa đăng nhập!',
            text: "Bạn cần đăng nhập để có thể tiến hành thanh toán đơn hàng.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Đăng nhập ngay',
            cancelButtonText: 'Để sau'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/auth/login';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', renderCartPage);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/cart/index.blade.php ENDPATH**/ ?>