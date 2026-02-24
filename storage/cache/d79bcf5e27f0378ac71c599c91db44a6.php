

<?php $__env->startSection('content'); ?>
<style>
    .dashboard-wrapper { background-color: #f8f9fa; min-height: 100vh; }
    .stat-card { border: none; border-radius: 16px; transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    .icon-shape { width: 48px; height: 48px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    .table-card { border-radius: 16px; border: none; }
    .table thead th { background-color: #f8fafc; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; border-top: none; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid py-4 px-4 dashboard-wrapper">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark mb-1">Xin chào, <?= $_SESSION['admin_name'] ?? 'Admin' ?>! 👋</h3>
            <p class="text-muted">Đây là tổng quan cửa hàng của bạn hôm nay.</p>
        </div>
    </div>
    
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Sản phẩm</small>
                        <h3 class="mb-0 fw-bold"><?php echo e($totalProducts); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-cart-check fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Đơn chờ duyệt</small>
                        <h3 class="mb-0 fw-bold"><?php echo e($newOrders); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Doanh thu tháng</small>
                        <h4 class="mb-0 fw-bold text-danger"><?php echo e(number_format($monthlyRevenue, 0, ',', '.')); ?>đ</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Khách hàng</small>
                        <h3 class="mb-0 fw-bold"><?php echo e($totalCustomers); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card table-card shadow-sm p-4">
                <h5 class="fw-bold mb-4">Biểu đồ doanh thu 7 ngày qua</h5>
                <canvas id="revenueChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card table-card shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Đơn hàng gần đây</h5>
                    <a href="/adminOrder/index" class="btn btn-light btn-sm fw-bold">Xem tất cả</a>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="ps-4 fw-bold">#<?php echo e($order['id']); ?></td>
                                <td><?php echo e($order['fullname']); ?></td>
                                <td><?php echo e(date('d/m/Y H:i', strtotime($order['created_at']))); ?></td>
                                <td class="fw-bold text-danger"><?php echo e(number_format($order['total_money'], 0, ',', '.')); ?>đ</td>
                                <td>
                                    <?php if($order['status'] == 1): ?> <span class="badge bg-warning text-dark px-3">Chờ duyệt</span>
                                    <?php elseif($order['status'] == 2): ?> <span class="badge bg-info px-3">Đang giao</span>
                                    <?php elseif($order['status'] == 3): ?> <span class="badge bg-success px-3">Đã giao</span>
                                    <?php else: ?> <span class="badge bg-danger px-3">Đã hủy</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card table-card shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold mb-0">Sản phẩm sắp hết hàng</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php $__currentLoopData = $lowStockProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                            <div class="d-flex align-items-center">
                                <img src="/<?php echo e($product['image'] ?? 'public/images/default.jpg'); ?>" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-0 fw-bold small text-truncate" style="max-width: 180px;"><?php echo e($product['name']); ?></h6>
                                    <small class="text-danger fw-bold">Còn lại: <?php echo e($product['stock']); ?></small>
                                </div>
                            </div>
                            <a href="/product/edit/<?php echo e($product['id']); ?>" class="btn btn-sm btn-light"><i class="bi bi-pencil"></i></a>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');

        const chartLabels = <?php echo json_encode($chartData['dates']); ?>;
        const chartData = <?php echo json_encode($chartData['revenues']); ?>;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: chartData,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#6366f1',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('vi-VN') + 'đ';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/dashboard.blade.php ENDPATH**/ ?>