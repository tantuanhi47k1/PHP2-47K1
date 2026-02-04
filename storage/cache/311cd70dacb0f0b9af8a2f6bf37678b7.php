

<?php $__env->startSection('title', 'Cửa Hàng'); ?>

<?php $__env->startSection('content'); ?>

<?php
    $limit = 9; 
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $totalProducts = count($products);
    $totalPages = ceil($totalProducts / $limit);
    if ($page < 1) $page = 1;
    if ($page > $totalPages) $page = $totalPages;
    
    $offset = ($page - 1) * $limit;
    $displayProducts = array_slice($products, $offset, $limit);

    $categories = [
        ['id' => 1, 'name' => 'Điện thoại', 'count' => 15],
        ['id' => 2, 'name' => 'Laptop', 'count' => 8],
        ['id' => 3, 'name' => 'Phụ kiện', 'count' => 20],
        ['id' => 4, 'name' => 'Đồng hồ', 'count' => 5],
    ];
?>

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
    .sidebar-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
    }
    .sidebar-header {
        background: #f8f9fa;
        padding: 15px 20px;
        font-weight: bold;
        border-bottom: 1px solid #eee;
        color: #333;
    }
    .category-list .list-group-item {
        border: none;
        padding: 12px 20px;
        transition: all 0.2s;
        border-bottom: 1px solid #f8f9fa;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .category-list .list-group-item:last-child { border-bottom: none; }
    .category-list .list-group-item:hover {
        background-color: #f0f7ff;
        color: #0d6efd;
        padding-left: 25px;
    }
    .pagination .page-link {
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 5px;
        border: none;
        color: #333;
        font-weight: 600;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        color: white;
    }
</style>

<div class="container py-5">
    <div class="row">
        
        
        <div class="col-lg-3 order-2 order-lg-1 mb-4">

            <div class="sidebar-card shadow-sm">
                <div class="p-3">
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="text" name="keyword" class="form-control border-end-0" placeholder="Tìm kiếm..." value="<?php echo e($_GET['keyword'] ?? ''); ?>">
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
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="?category=<?php echo e($cat['id']); ?>" class="list-group-item list-group-item-action">
                            <span><?php echo e($cat['name']); ?></span>
                            <span class="badge bg-light text-secondary rounded-pill"><?php echo e($cat['count']); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="sidebar-card shadow-sm">
                <div class="sidebar-header">
                    <i class="bi bi-funnel me-2 text-primary"></i> Khoảng giá
                </div>
                <div class="p-3">
                    <form action="" method="GET">
                        <div class="mb-3">
                            <label class="form-label small text-muted">Giá từ:</label>
                            <input type="number" class="form-control form-control-sm" placeholder="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Đến:</label>
                            <input type="number" class="form-control form-control-sm" placeholder="10.000.000">
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary btn-sm fw-bold">Áp dụng</button>
                        </div>
                    </form>
                </div>
            </div>

            
            <div class="rounded-3 overflow-hidden shadow-sm d-none d-lg-block">
                <img src="https://img.freepik.com/free-vector/modern-sale-banner-template-with-fluid-shapes_1361-1389.jpg" class="w-100" alt="Banner">
            </div>

        </div>

        
        <div class="col-lg-9 order-1 order-lg-2 mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded-3">
                <div>
                    <h4 class="fw-bold mb-0 text-primary">Tất cả sản phẩm</h4>
                    <small class="text-muted">Hiển thị <?php echo e(count($displayProducts)); ?> / <?php echo e($totalProducts); ?> kết quả</small>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-2 text-muted small d-none d-md-block">Sắp xếp:</span>
                    <select class="form-select form-select-sm rounded-pill border-0 shadow-sm" style="width: 150px;">
                        <option>Mới nhất</option>
                        <option>Giá thấp đến cao</option>
                        <option>Giá cao đến thấp</option>
                        <option>Bán chạy</option>
                    </select>
                </div>
            </div>

            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-3 g-3">
                <?php if(!empty($displayProducts)): ?>
                    <?php $__currentLoopData = $displayProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(isset($item['status']) && $item['status'] == 1): ?> 
                        <div class="col">
                            <div class="card h-100 shadow-sm product-card rounded-3 overflow-hidden">
                                <div class="position-relative product-img-frame">
                                    <a href="/product/detail/<?php echo e($item['id']); ?>">
                                        <img src="/<?php echo e($item['image'] ?? 'image/product/default.png'); ?>" 
                                             alt="<?php echo e($item['name']); ?>"
                                             onerror="this.src='https://placehold.co/300x300?text=No+Image'">
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

                                    <div class="mt-auto">
                                        <form action="/cart/add" method="POST">
                                            <input type="hidden" name="id" value="<?php echo e($item['id']); ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-outline-primary w-100 btn-sm rounded-pill fw-bold hover-shadow">
                                                Thêm vào giỏ
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <i class="bi bi-search text-muted opacity-25" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">Không tìm thấy sản phẩm nào.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($totalPages > 1): ?>
            <div class="d-flex justify-content-center mt-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item <?php echo e(($page <= 1) ? 'disabled' : ''); ?>">
                            <a class="page-link" href="?page=<?php echo e($page - 1); ?>">&laquo;</a>
                        </li>
                        <?php for($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?php echo e(($page == $i) ? 'active' : ''); ?>">
                                <a class="page-link" href="?page=<?php echo e($i); ?>"><?php echo e($i); ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?php echo e(($page >= $totalPages) ? 'disabled' : ''); ?>">
                            <a class="page-link" href="?page=<?php echo e($page + 1); ?>">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/client/product/index.blade.php ENDPATH**/ ?>