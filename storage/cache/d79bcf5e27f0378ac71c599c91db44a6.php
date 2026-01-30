

<?php $__env->startSection('content'); ?>
<style>
    /* Tổng thể nền */
    .dashboard-wrapper { background-color: #f8f9fa; min-height: 100vh; }
    
    /* Card thông số */
    .stat-card {
        border: none;
        border-radius: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }
    .icon-shape {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    /* Bảng dữ liệu */
    .table-card { border-radius: 16px; border: none; }
    .table thead th { 
        background-color: #f8fafc; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 1px; 
        border-top: none; 
    }
</style>

<div class="container-fluid py-4 px-4 dashboard-wrapper">
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark mb-1">Xin chào, <?= $_SESSION['admin_name'] ?>! 👋</h3>
            <p class="text-muted">Đây là những gì đang diễn ra với cửa hàng của bạn hôm nay.</p>
        </div>
    </div>
    
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card shadow-sm p-3">
                <div class="d-flex align-items-center">
                    <div class="icon-shape bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Sản phẩm</small>
                        <h3 class="mb-0 fw-bold">120</h3>
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
                        <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Đơn hàng mới</small>
                        <h3 class="mb-0 fw-bold">15</h3>
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
                        <h3 class="mb-0 fw-bold">45.2M</h3>
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
                        <h3 class="mb-0 fw-bold">1,024</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card table-card shadow-sm">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Đơn hàng gần đây</h5>
                    <a href="/order" class="btn btn-light btn-sm fw-bold">Xem tất cả</a>
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
                            <tr>
                                <td class="ps-4 fw-bold">#DH1001</td>
                                <td>Nguyễn Văn A</td>
                                <td>29/01/2026</td>
                                <td class="fw-bold">2,500,000đ</td>
                                <td><span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Hoàn tất</span></td>
                            </tr>
                            <tr>
                                <td class="ps-4 fw-bold">#DH1002</td>
                                <td>Trần Thị B</td>
                                <td>28/01/2026</td>
                                <td class="fw-bold">1,200,000đ</td>
                                <td><span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3">Chờ xử lý</span></td>
                            </tr>
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
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/40" class="rounded me-3">
                                <div>
                                    <h6 class="mb-0 fw-bold small">Tai nghe Sony WH-1000XM5</h6>
                                    <small class="text-danger">Còn lại: 2</small>
                                </div>
                            </div>
                            <a href="/product/edit/1" class="btn btn-sm btn-light"><i class="bi bi-plus"></i></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                            <div class="d-flex align-items-center">
                                <img src="https://via.placeholder.com/40" class="rounded me-3">
                                <div>
                                    <h6 class="mb-0 fw-bold small">Bàn phím Akko 3068B</h6>
                                    <small class="text-danger">Còn lại: 0</small>
                                </div>
                            </div>
                            <a href="/product/edit/2" class="btn btn-sm btn-light"><i class="bi bi-plus"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/dashboard.blade.php ENDPATH**/ ?>