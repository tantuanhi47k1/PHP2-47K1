

<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --primary-color: #009981;
        }

        .text-brand {
            color: var(--primary-color) !important;
        }

        .btn-brand {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-brand:hover {
            background-color: #007a67;
            color: white;
        }

        .bg-brand-light {
            background-color: rgba(0, 153, 129, 0.1);
            color: var(--primary-color);
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }

        .font-monospace {
            font-family: 'Courier New', Courier, monospace;
            letter-spacing: 1px;
        }
    </style>

    <div class="container-fluid py-5">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-brand m-0"><i class="bi bi-ticket-perforated me-2"></i>Quản lý Mã giảm giá</h4>
                <a href="/coupon/create" class="btn btn-brand btn-sm shadow-sm px-3 py-2">
                    <i class="bi bi-plus-lg me-1"></i> Thêm mã mới
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Mã Coupon</th>
                            <th>Chi tiết giảm</th>
                            <th>Mức giảm tối đa</th>
                            <th>Đơn tối thiểu</th>
                            <th>Lượt dùng</th>
                            <th>Thời hạn</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-center pe-4">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($coupons)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">Chưa có mã giảm giá nào được tạo.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach($coupons as $c): ?>
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-primary bg-light px-2 py-1 border rounded font-monospace">
                                    <?= htmlspecialchars($c['code']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <?php if($c['discount_type'] == 'percentage'): ?>
                                        <span class="text-dark fw-bold"><?= (float)$c['discount_value'] ?>%</span>
                                        <small class="text-info" style="font-size: 0.75rem;">Theo phần trăm</small>
                                    <?php else: ?>
                                        <span class="text-dark fw-bold"><?= number_format($c['discount_value'], 0, ',', '.') ?> đ</span>
                                        <small class="text-warning" style="font-size: 0.75rem;">Tiền mặt cố định</small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?php if($c['max_discount_amount']): ?>
                                    <span class="text-dark"><?= number_format($c['max_discount_amount'], 0, ',', '.') ?> đ</span>
                                <?php else: ?>
                                    <span class="text-muted">Không giới hạn</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="text-muted"><?= number_format($c['min_order_value'], 0, ',', '.') ?> đ</span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark small">Tối đa: <?= $c['usage_limit'] ?? '∞' ?></span>
                                    <small class="text-muted" style="font-size: 0.7rem;">Đã dùng: 0</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column" style="font-size: 0.85rem;">
                                    <small class="text-success"><i class="bi bi-play-circle me-1"></i><?= date('d/m/Y', strtotime($c['start_date'])) ?></small>
                                    <?php if($c['end_date']): ?>
                                        <small class="text-danger mt-1"><i class="bi bi-stop-circle me-1"></i><?= date('d/m/Y', strtotime($c['end_date'])) ?></small>
                                    <?php else: ?>
                                        <small class="text-muted mt-1"><i class="bi bi-infinity me-1"></i>Vô thời hạn</small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <?php if($c['status'] == 1): ?>
                                    <span class="badge bg-brand-light rounded-pill px-3">Đang chạy</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3">Tạm dừng</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="/coupon/edit/<?= $c['id'] ?>" class="btn btn-sm btn-light border text-primary" title="Chỉnh sửa">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="/coupon/delete/<?= $c['id'] ?>" class="btn btn-sm btn-light border text-danger" 
                                       onclick="return confirm('Xóa mã [<?= htmlspecialchars($c['code']) ?>]?');" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/coupon/index.blade.php ENDPATH**/ ?>