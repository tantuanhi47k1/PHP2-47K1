

<?php $__env->startSection('title', 'Cửa Hàng'); ?>

<?php $__env->startSection('content'); ?>

<style>
    .product-img-frame { position: relative; width: 100%; padding-top: 100%; overflow: hidden; background-color: #fff; border-bottom: 1px solid #f0f0f0; }
    .product-img-frame img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: contain; padding: 15px; transition: transform 0.5s ease; }
    .product-card { transition: all 0.3s ease; border: 1px solid #eee; }
    .product-card:hover { box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; transform: translateY(-5px); border-color: transparent; }
    .product-card:hover .product-img-frame img { transform: scale(1.1); }
    .sidebar-card { background: #fff; border: 1px solid #eee; border-radius: 12px; overflow: hidden; margin-bottom: 24px; }
    .sidebar-header { background: #f8f9fa; padding: 15px 20px; font-weight: bold; border-bottom: 1px solid #eee; color: #333; }
    .category-list .list-group-item { border: none; padding: 12px 20px; transition: all 0.2s; border-bottom: 1px solid #f8f9fa; display: flex; justify-content: space-between; align-items: center; }
    .category-list .list-group-item:last-child { border-bottom: none; }
    .category-list .list-group-item:hover, .category-list .list-group-item.active { background-color: #f0f7ff; color: #0d6efd; padding-left: 25px; }
    .pagination .page-link { border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin: 0 5px; border: none; color: #333; font-weight: 600; }
    .pagination .page-item.active .page-link { background-color: #0d6efd; color: white; }
    .btn-wishlist { border-color: #dee2e6; color: #dc3545; transition: 0.2s; }
    .btn-wishlist:hover, .btn-wishlist.active { background-color: #dc3545; color: #fff; border-color: #dc3545; }
</style>

<div class="container py-5">
    <div class="row">
        
        <div class="col-lg-3 order-2 order-lg-1 mb-4">

            <div class="sidebar-card shadow-sm">
                <div class="p-3">
                    <form action="/product" method="GET">
                        <?php if(!empty($currentCategory)): ?>
                            <input type="hidden" name="category" value="<?php echo e($currentCategory); ?>">
                        <?php endif; ?>
                        <?php if(!empty($currentPriceRange)): ?>
                            <input type="hidden" name="price_range" value="<?php echo e($currentPriceRange); ?>">
                        <?php endif; ?>
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control border-end-0" placeholder="Tìm kiếm..." value="<?php echo e($keyword ?? ''); ?>">
                            <button class="btn btn-outline-secondary border-start-0 bg-white" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="sidebar-card shadow-sm">
                <div class="sidebar-header">
                    <i class="bi bi-list-ul me-2 text-primary"></i> Danh mục
                </div>
                <div class="list-group list-group-flush category-list">
                    <a href="/product" class="list-group-item list-group-item-action <?php echo e(empty($currentCategory) ? 'active' : ''); ?>">
                        <span>Tất cả</span>
                    </a>

                    <?php if(isset($categories) && is_array($categories)): ?>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="/product?category=<?php echo e($cat['id']); ?>" class="list-group-item list-group-item-action <?php echo e((isset($currentCategory) && $currentCategory == $cat['id']) ? 'active' : ''); ?>">
                                <span><?php echo e($cat['name']); ?></span>
                                <span class="badge bg-light text-secondary rounded-pill"><?php echo e($cat['product_count'] ?? 0); ?></span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="sidebar-card shadow-sm">
                <div class="sidebar-header">
                    <i class="bi bi-cash-coin me-2 text-primary"></i> Lọc theo giá
                </div>
                <div class="p-3">
                    <form action="/product" method="GET">
                        <?php if(!empty($keyword)): ?>
                            <input type="hidden" name="keyword" value="<?php echo e($keyword); ?>">
                        <?php endif; ?>
                        <?php if(!empty($currentCategory)): ?>
                            <input type="hidden" name="category" value="<?php echo e($currentCategory); ?>">
                        <?php endif; ?>

                        <div class="mb-2 form-check">
                            <input class="form-check-input" type="radio" name="price_range" value="" id="priceAll" 
                                <?php echo e(empty($currentPriceRange) ? 'checked' : ''); ?> onchange="this.form.submit()">
                            <label class="form-check-label" for="priceAll">Tất cả mức giá</label>
                        </div>

                        <div class="mb-2 form-check">
                            <input class="form-check-input" type="radio" name="price_range" value="1" id="price1" 
                                <?php echo e((isset($currentPriceRange) && $currentPriceRange == '1') ? 'checked' : ''); ?> onchange="this.form.submit()">
                            <label class="form-check-label" for="price1">Dưới 3 triệu</label>
                        </div>

                        <div class="mb-2 form-check">
                            <input class="form-check-input" type="radio" name="price_range" value="2" id="price2" 
                                <?php echo e((isset($currentPriceRange) && $currentPriceRange == '2') ? 'checked' : ''); ?> onchange="this.form.submit()">
                            <label class="form-check-label" for="price2">Từ 3 - 10 triệu</label>
                        </div>

                        <div class="mb-2 form-check">
                            <input class="form-check-input" type="radio" name="price_range" value="3" id="price3" 
                                <?php echo e((isset($currentPriceRange) && $currentPriceRange == '3') ? 'checked' : ''); ?> onchange="this.form.submit()">
                            <label class="form-check-label" for="price3">Từ 10 - 50 triệu</label>
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="radio" name="price_range" value="4" id="price4" 
                                <?php echo e((isset($currentPriceRange) && $currentPriceRange == '4') ? 'checked' : ''); ?> onchange="this.form.submit()">
                            <label class="form-check-label" for="price4">Trên 50 triệu</label>
                        </div>
                        
                        <div class="d-grid">
                            <a href="/product" class="btn btn-outline-secondary btn-sm">Bỏ lọc</a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="rounded-3 overflow-hidden shadow-sm d-none d-lg-block">
                <img src="https://olymstore.net/storage/30.12.2023/Olymstore%20001663%20(1).jpg" class="w-100" alt="Banner">
            </div>
        </div>

        <div class="col-lg-9 order-1 order-lg-2 mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded-3">
                <div>
                    <h4 class="fw-bold mb-0 text-primary">
                        <?php if(!empty($keyword)): ?>
                            Kết quả tìm kiếm: "<?php echo e($keyword); ?>"
                        <?php else: ?>
                            Tất cả sản phẩm
                        <?php endif; ?>
                    </h4>
                    <small class="text-muted">Hiển thị <?php echo e(count($products)); ?> / <?php echo e($totalProducts ?? 0); ?> kết quả</small>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-2 text-muted small d-none d-md-block">Sắp xếp:</span>
                    <select class="form-select form-select-sm rounded-pill border-0 shadow-sm" style="width: 150px;">
                        <option>Mới nhất</option>
                        <option>Giá thấp đến cao</option>
                        <option>Giá cao đến thấp</option>
                    </select>
                </div>
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-3 g-3">
                <?php if(!empty($products) && count($products) > 0): ?>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm product-card rounded-3 overflow-hidden">
                                <div class="position-relative product-img-frame">
                                    <a href="/product/detail/<?php echo e($item['id']); ?>">
                                        <?php 
                                            $imgSrc = 'https://placehold.co/300x300?text=No+Image';
                                            if (!empty($item['image'])) {
                                                $imgSrc = (strpos($item['image'], 'http') === 0) ? $item['image'] : '/' . $item['image'];
                                            }
                                        ?>
                                        <img src="<?php echo e($imgSrc); ?>" alt="<?php echo e($item['name']); ?>" onerror="this.src='https://placehold.co/300x300?text=Error'">
                                    </a>
                                </div>

                                <div class="card-body d-flex flex-column p-3">
                                    <h6 class="card-title text-truncate mb-2" style="font-size: 0.95rem;">
                                        <a href="/product/detail/<?php echo e($item['id']); ?>" class="text-decoration-none text-dark fw-bold" title="<?php echo e($item['name']); ?>">
                                            <?php echo e($item['name']); ?>

                                        </a>
                                    </h6>

                                    <div class="mb-3 text-primary">
                                        <?php if(isset($item['variant_price']) && $item['variant_price'] > 0): ?>
                                            <small class="text-muted text-dark" style="font-size: 0.75rem">Từ:</small> 
                                            <span class="fw-bold"><?php echo e(number_format($item['variant_price'], 0, ',', '.')); ?>đ</span>
                                        <?php elseif(isset($item['base_price'])): ?>
                                            <span class="fw-bold"><?php echo e(number_format($item['base_price'], 0, ',', '.')); ?>đ</span>
                                        <?php else: ?>
                                            <span class="text-muted small">Liên hệ</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-auto d-flex gap-2">
                                        <button class="btn btn-outline-primary flex-grow-1 btn-sm rounded-pill fw-bold hover-shadow" 
                                                onclick="addToCart({id: <?php echo e($item['id']); ?>, name: '<?php echo e($item['name']); ?>', price: <?php echo e($item['base_price']); ?>, image: '<?php echo e($imgSrc); ?>', quantity: 1})">
                                            Thêm vào giỏ
                                        </button>
                                        
                                        <button class="btn btn-wishlist btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                                                style="width: 32px; height: 32px;"
                                                onclick="toggleWishlist(this, <?php echo e($item['id']); ?>)" 
                                                title="Yêu thích">
                                            <i class="bi bi-heart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-search text-muted opacity-25" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">Không tìm thấy sản phẩm nào phù hợp.</p>
                        <a href="/product" class="btn btn-primary rounded-pill px-4">Xem tất cả sản phẩm</a>
                    </div>
                <?php endif; ?>
            </div>

            <?php if(isset($totalPages) && $totalPages > 1): ?>
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?php echo e(($currentPage <= 1) ? 'disabled' : ''); ?>">
                            <a class="page-link" href="?page=<?php echo e($currentPage - 1); ?>&category=<?php echo e($currentCategory ?? ''); ?>&keyword=<?php echo e($keyword ?? ''); ?>&price_range=<?php echo e($currentPriceRange ?? ''); ?>">&laquo;</a>
                        </li>
                        
                        <?php for($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo e(($currentPage == $i) ? 'active' : ''); ?>">
                                <a class="page-link" href="?page=<?php echo e($i); ?>&category=<?php echo e($currentCategory ?? ''); ?>&keyword=<?php echo e($keyword ?? ''); ?>&price_range=<?php echo e($currentPriceRange ?? ''); ?>"><?php echo e($i); ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php echo e(($currentPage >= $totalPages) ? 'disabled' : ''); ?>">
                            <a class="page-link" href="?page=<?php echo e($currentPage + 1); ?>&category=<?php echo e($currentCategory ?? ''); ?>&keyword=<?php echo e($keyword ?? ''); ?>&price_range=<?php echo e($currentPriceRange ?? ''); ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
    function toggleWishlist(btn, productId) {
        btn.classList.toggle('active');
        
        let icon = btn.querySelector('i');
        if (btn.classList.contains('active')) {
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
            console.log('Added ' + productId);
        } else {
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
            console.log('Removed ' + productId);
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/client/product/index.blade.php ENDPATH**/ ?>