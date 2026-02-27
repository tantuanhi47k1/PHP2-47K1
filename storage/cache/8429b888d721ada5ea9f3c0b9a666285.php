

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
    .btn-remove { color: #adb5bd; transition: 0.2s; font-size: 0.9rem; cursor: pointer; }
    .btn-remove:hover { color: #dc3545; text-decoration: underline; }

    .coupon-input { font-size: 1rem !important; padding: 0.35rem 0.75rem; border-radius: 6px; border: 1px solid #dee2e6; box-shadow: none !important; }
    .coupon-input:focus { border-color: #6c757d; }
    .coupon-btn { font-size: 1rem !important; padding: 0.35rem 1rem; border-radius: 6px; white-space: nowrap; }

    .coupon-ticket { background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 99%, #fecfef 100%); border-radius: 12px; position: relative; overflow: hidden; transition: transform 0.2s; }
    .coupon-ticket:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(255, 154, 158, 0.4) !important; }
    .coupon-ticket::before, .coupon-ticket::after { content: ''; position: absolute; top: 50%; width: 20px; height: 20px; background-color: #f8f9fa; border-radius: 50%; transform: translateY(-50%); }
    .coupon-ticket::before { left: -10px; }
    .coupon-ticket::after { right: -10px; }
    .coupon-code-box { border: 1px dashed rgba(255,255,255,0.8); background: rgba(255,255,255,0.2); border-radius: 6px; }

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
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <div class="row fw-bold text-secondary small text-uppercase">
                                <div class="col-6">Sản phẩm</div>
                                <div class="col-3 text-center">Số lượng</div>
                                <div class="col-3 text-end">Tạm tính</div>
                            </div>
                        </div>
                        
                        <div class="card-body p-0" id="cart-list"></div>
                    </div>

                    <?php if(isset($availableCoupons) && count($availableCoupons) > 0): ?>
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-ticket-perforated text-danger me-2"></i>Voucher dành cho bạn</h5>
                        <div class="row g-3">
                            <?php $__currentLoopData = $availableCoupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-6">
                                <div class="coupon-ticket shadow-sm p-3 h-100 d-flex flex-column justify-content-center">
                                    <div class="text-center mb-2">
                                        <h6 class="fw-bold text-white mb-1">
                                            <?php if($cp['discount_type'] == 'percent'): ?>
                                                Giảm <?php echo e($cp['discount_value']); ?>%
                                            <?php else: ?>
                                                Giảm <?php echo e(number_format($cp['discount_value'], 0, ',', '.')); ?>đ
                                            <?php endif; ?>
                                        </h6>
                                        <small class="text-white opacity-75 d-block" style="font-size: 0.8rem;">Đơn tối thiểu <?php echo e(number_format($cp['min_order_value'], 0, ',', '.')); ?>đ</small>
                                    </div>
                                    
                                    <div class="coupon-code-box p-2 mt-auto d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-white fs-6 font-monospace mb-0 ps-2"><?php echo e($cp['code']); ?></span>
                                        <button class="btn btn-light btn-sm fw-bold text-danger btn-copy-coupon rounded-3 px-3" data-code="<?php echo e($cp['code']); ?>">Copy</button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between mt-2">
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
                            <span class="text-muted">Giảm giá: 
                                <?php if(isset($coupon)): ?> 
                                    <br><small class="badge bg-success bg-opacity-10 text-success border border-success mt-1"><?php echo e($coupon['code']); ?></small> 
                                <?php endif; ?>
                            </span>
                            <span class="text-success fw-bold" id="discount-amount">-<?php echo e(number_format($discountAmount ?? 0, 0, ',', '.')); ?>đ</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Vận chuyển:</span>
                            <span class="text-success fw-bold">Miễn phí</span>
                        </div>
                        
                        <hr class="border-secondary border-opacity-10 my-4">
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase mb-2">Mã giảm giá</label>
                            <form action="/cart/applyCoupon" method="POST" class="d-flex gap-2 m-0">
                                <input type="text" name="coupon_code" id="coupon_input_field" class="form-control form-control-sm text-uppercase coupon-input" placeholder="Nhập mã..." 
                                       value="<?php echo e(isset($coupon) ? $coupon['code'] : ''); ?>" 
                                       <?php echo e(isset($coupon) ? 'readonly' : ''); ?>>
                                <?php if(isset($coupon)): ?>
                                    <a href="/cart/removeCoupon" class="btn btn-danger btn-sm coupon-btn d-flex align-items-center justify-content-center" title="Gỡ mã"><i class="bi bi-x-lg"></i></a>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-dark btn-sm fw-bold coupon-btn">Áp dụng</button>
                                <?php endif; ?>
                            </form>
                        </div>

                        <hr class="border-secondary border-opacity-10 my-4">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold fs-5">TỔNG CỘNG:</span>
                            <span class="fw-bold fs-4 text-primary" id="final-total-price">0đ</span>
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

    const serverCouponCode = '<?php echo e($coupon['code'] ?? ''); ?>';
    const serverDiscountAmount = <?php echo e($discountAmount ?? 0); ?>;

    function renderCartPage() {
        const cart = getCart();
        const cartList = document.getElementById('cart-list');
        const hasItemsDiv = document.getElementById('cart-has-items');
        const emptyDiv = document.getElementById('cart-empty');
        const countSpan = document.getElementById('cart-count-page');
        
        const subtotalSpan = document.getElementById('subtotal-price');
        const finalTotalSpan = document.getElementById('final-total-price');

        if (serverCouponCode !== '') {
            localStorage.setItem('coupon_code', serverCouponCode);
            localStorage.setItem('discount_amount', serverDiscountAmount);
        } else {
            localStorage.removeItem('coupon_code');
            localStorage.removeItem('discount_amount');
        }

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
                                     class="rounded-3 border bg-white" 
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

            let finalPrice = totalPrice - serverDiscountAmount;
            if (finalPrice < 0) finalPrice = 0;
            
            finalTotalSpan.innerText = formatCurrency(finalPrice);
        }
    }

    function updateItemQty(index, change) {
        let cart = getCart();
        if (cart[index]) {
            let newQty = parseInt(cart[index].quantity) + change;
            if (newQty > 0) {
                cart[index].quantity = newQty;
                saveCart(cart);
                window.location.reload(); 
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
                window.location.reload();
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

    document.addEventListener('DOMContentLoaded', () => {
        renderCartPage();

        document.querySelectorAll('.btn-copy-coupon').forEach(button => {
            button.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                const originalText = this.innerText;
                const inputField = document.getElementById('coupon_input_field');

                navigator.clipboard.writeText(code).then(() => {
                    this.innerText = 'Đã Copy';
                    this.classList.replace('text-danger', 'text-success');

                    if(inputField && !inputField.hasAttribute('readonly')) {
                        inputField.value = code;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Đã copy mã: ' + code,
                        showConfirmButton: false,
                        timer: 1500,
                        toast: true,
                        position: 'top-end'
                    });

                    setTimeout(() => {
                        this.innerText = originalText;
                        this.classList.replace('text-success', 'text-danger');
                    }, 2000);
                });
            });
        });
    });
</script>

<?php if(isset($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: '<?= $_SESSION['success'] ?>',
            timer: 2500,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    </script>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Thông báo',
            text: '<?= $_SESSION['error'] ?>',
            confirmButtonColor: '#d33'
        });
    </script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/client/cart/index.blade.php ENDPATH**/ ?>