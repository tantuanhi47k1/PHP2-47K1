

<?php $__env->startSection('title', 'TechHub - Thế Giới Công Nghệ'); ?>

<?php $__env->startSection('content'); ?>

    <style>
        .hero-section {
            position: relative;
            padding: 100px 0;
            color: white;
            border-radius: 0 0 50px 50px;
            margin-bottom: 50px;
            background:
                linear-gradient(rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.55)),
                url('https://png.pngtree.com/thumb_back/fw800/back_our/20190622/ourmid/pngtree-boao-blue-technology-map-banner-background-image_207139.jpg');

            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }


        .hero-badge {
            background: rgba(99, 102, 241, 0.2);
            color: #818cf8;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .category-item {
            transition: all 0.3s ease;
            text-align: center;
            display: inline-block;
            width: 100%;
        }

        .category-icon {
            width: 100px;
            height: 100px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 2.2rem;
            color: #6366f1;
            transition: 0.3s;
            border: 1px solid #eee;
        }

        .category-item:hover .category-icon {
            background: #6366f1;
            color: white;
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);
        }

        .product-card {
            border: none;
            border-radius: 20px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: #fff;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
        }

        .product-img-frame {
            padding-top: 100%;
            position: relative;
            overflow: hidden;
        }

        .product-img-frame img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 25px;
            transition: 0.5s;
        }

        .btn-cart-quick {
            background: #f1f5f9;
            color: #334155;
            border: none;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-cart-quick:hover {
            background: #6366f1;
            color: white;
            transform: rotate(-10deg);
        }

        .btn-buy-now {
            background: #1e293b;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
        }

        .btn-buy-now:hover {
            background: #6366f1;
            color: white;
            box-shadow: 0 8px 15px rgba(99, 102, 241, 0.3);
        }

    </style>

    <section class="hero-section shadow-lg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <span class="hero-badge mb-3 d-inline-block">NEW ARRIVAL 2026</span>
                    <h1 class="display-3 fw-bold mb-4">Nâng Tầm Trải Nghiệm <span class="text-primary">Công Nghệ</span></h1>
                    <p class="lead opacity-75 mb-5">Khám phá bộ sưu tập thiết bị thông minh hàng đầu tại TechHub. Chất lượng
                        đỉnh cao, bảo hành dài hạn.</p>
                    <div class="d-flex gap-3">
                        <a href="/shop" class="btn btn-primary btn-lg px-4 rounded-pill fw-bold shadow">Mua Ngay</a>
                        <a href="#featured" class="btn btn-outline-light btn-lg px-4 rounded-pill">Xem Ưu Đãi</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="/image/hero_product.png" class="img-fluid" alt="TechHub Hero"
                        onerror="this.src='https://placehold.co/600x400/transparent/white?text=TechHub+Premium'">
                </div>
            </div>
        </div>
    </section>

    <div class="container mb-5 mt-n5">
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="p-4 border-0 rounded-4 bg-white shadow-sm">
                    <i class="bi bi-truck fs-2 text-primary mb-2"></i>
                    <h6 class="fw-bold mb-1">Giao hàng miễn phí</h6>
                    <small class="text-muted">Đơn hàng từ 1.000.000đ</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 border-0 rounded-4 bg-white shadow-sm">
                    <i class="bi bi-shield-check fs-2 text-primary mb-2"></i>
                    <h6 class="fw-bold mb-1">Chính hãng 100%</h6>
                    <small class="text-muted">Cam kết chất lượng</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 border-0 rounded-4 bg-white shadow-sm">
                    <i class="bi bi-headset fs-2 text-primary mb-2"></i>
                    <h6 class="fw-bold mb-1">Hỗ trợ 24/7</h6>
                    <small class="text-muted">Tư vấn chuyên nghiệp</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-4 border-0 rounded-4 bg-white shadow-sm">
                    <i class="bi bi-arrow-repeat fs-2 text-primary mb-2"></i>
                    <h6 class="fw-bold mb-1">Đổi trả dễ dàng</h6>
                    <small class="text-muted">Trong vòng 7 ngày</small>
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5 py-4">
        <h4 class="fw-bold mb-5 text-center text-dark">Danh Mục Nổi Bật</h4>
        
        <?php if(isset($categories) && !empty($categories)): ?>
            <div class="row row-cols-2 row-cols-md-4 g-4 justify-content-center text-center">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $icon = 'bi-grid';
                        $name = mb_strtolower($cat['name'], 'UTF-8');
                        
                        if(strpos($name, 'tai nghe') !== false) $icon = 'bi-headphones';
                        elseif(strpos($name, 'laptop') !== false) $icon = 'bi-laptop';
                        elseif(strpos($name, 'điện thoại') !== false) $icon = 'bi-phone';
                        elseif(strpos($name, 'đồng hồ') !== false) $icon = 'bi-watch';
                        elseif(strpos($name, 'chuột') !== false) $icon = 'bi-mouse';
                        elseif(strpos($name, 'bàn phím') !== false) $icon = 'bi-keyboard';
                    ?>

                    <div class="col">
                        <a href="/category/<?php echo e($cat['id']); ?>" class="text-decoration-none category-item">
                            <div class="category-icon shadow-sm"><i class="bi <?php echo e($icon); ?>"></i></div>
                            <span class="fw-bold text-dark fs-5"><?php echo e($cat['name']); ?></span>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center text-muted">Đang cập nhật danh mục...</div>
        <?php endif; ?>
    </div>

    <div class="container mb-5" id="featured">
        <div class="d-flex justify-content-between align-items-end mb-4 px-2">
            <div>
                <h3 class="fw-bold mb-1 text-dark">Sản Phẩm Mới Nhất</h3>
                <p class="text-muted mb-0 small">Cập nhật công nghệ mới nhất mỗi ngày</p>
            </div>
            <a href="/shop" class="btn btn-link text-primary fw-bold text-decoration-none p-0">Xem tất cả <i
                    class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(isset($item['status']) && $item['status'] == 1): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm product-card border-0">
                            <div class="product-img-frame bg-light rounded-top-4">
                                <a href="/product/detail/<?php echo e($item['id']); ?>">
                                    <img src="/<?php echo e($item['image'] ?? 'image/product/default.png'); ?>"
                                        alt="<?php echo e($item['name']); ?>"
                                        onerror="this.src='https://placehold.co/300x300?text=TechHub'">
                                </a>
                            </div>
                            <div class="card-body p-4 d-flex flex-column">
                                <h6 class="mb-2 text-truncate text-center">
                                    <a href="/product/detail/<?php echo e($item['id']); ?>"
                                        class="text-decoration-none text-dark fw-bold" title="<?php echo e($item['name']); ?>">
                                        <?php echo e($item['name']); ?>

                                    </a>
                                </h6>
                                <div class="text-primary fw-bold fs-5 mb-4 text-center">
                                    <?php echo e(number_format($item['variant_price'] ?? $item['base_price'], 0, ',', '.')); ?>đ
                                </div>

                                <div class="mt-auto">
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn-cart-quick js-add-to-cart" 
                                                data-id="<?php echo e($item['id']); ?>" 
                                                data-name="<?php echo e($item['name']); ?>"
                                                data-price="<?php echo e($item['base_price']); ?>"
                                                data-image="/<?php echo e($item['image'] ?? 'image/product/default.png'); ?>"
                                                title="Thêm vào giỏ hàng">
                                            <i class="bi bi-bag-plus fs-5"></i>
                                        </button>
                                        <a href="/product/detail/<?php echo e($item['id']); ?>"
                                            class="btn-buy-now text-decoration-none">
                                            Xem Ngay
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <section class="container mb-5 pb-5">
        <div class="p-5 bg-primary rounded-5 text-white shadow-lg position-relative overflow-hidden border-0">
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-3">Nhận Ưu Đãi Độc Quyền!</h2>
                    <p class="mb-0 opacity-75">Đăng ký để nhận thông báo về sản phẩm mới và mã giảm giá 20%.</p>
                </div>
                <div class="col-md-4 mt-4 mt-md-0">
                    <div class="input-group">
                        <input type="email" class="form-control rounded-pill-start border-0 py-3 ps-4"
                            placeholder="Email của bạn...">
                        <button class="btn btn-dark rounded-pill-end px-4 fw-bold">Gửi Ngay</button>
                    </div>
                </div>
            </div>
            <div class="position-absolute top-50 start-0 translate-middle-y bg-white opacity-10 rounded-circle"
                style="width: 200px; height: 200px; margin-left: -100px;"></div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // SỬA LẠI: DÙNG HÀM addToCart() CỦA LOCALSTORAGE (cart.js)
    document.querySelectorAll('.js-add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Lấy dữ liệu từ data attributes
            const product = {
                id: this.getAttribute('data-id'),
                name: this.getAttribute('data-name'),
                price: parseFloat(this.getAttribute('data-price')),
                image: this.getAttribute('data-image'),
                variant_id: null, // Ở trang chủ mặc định thêm bản gốc
                variant_name: '',
                quantity: 1
            };
            
            // Gọi hàm từ cart.js
            addToCart(product);

            // Thông báo
            Swal.fire({
                icon: 'success',
                title: 'Đã thêm vào giỏ hàng!',
                showConfirmButton: false,
                timer: 1200,
                toast: true,
                position: 'top-end'
            });
        });
    });
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/home/index.blade.php ENDPATH**/ ?>