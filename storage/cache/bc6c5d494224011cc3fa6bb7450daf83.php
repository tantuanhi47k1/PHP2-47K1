
<?php $__env->startSection('title', 'Quản lý Đơn Hàng'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .status-1 { background-color: #fff3cd !important; color: #856404 !important; border-color: #ffeeba !important; font-weight: 600; }
        .status-2 { background-color: #cff4fc !important; color: #055160 !important; border-color: #b6effb !important; font-weight: 600; }
        .status-3 { background-color: #d1e7dd !important; color: #0f5132 !important; border-color: #badbcc !important; font-weight: 600; }
        .status-4 { background-color: #f8d7da !important; color: #842029 !important; border-color: #f5c2c7 !important; font-weight: 600; }

        .form-select:focus { box-shadow: none !important; }
    </style>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Danh sách Đơn hàng</h3>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Mã ĐH</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th class="text-end pe-4">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-primary">#<?php echo e($order['id']); ?></td>
                                    <td>
                                        <div class="fw-bold"><?php echo e($order['fullname']); ?></div>
                                        <small class="text-muted"><?php echo e($order['phone']); ?></small>
                                    </td>
                                    <td><?php echo e(date('d/m/Y H:i', strtotime($order['created_at']))); ?></td>
                                    <td class="fw-bold text-danger"><?php echo e(number_format($order['total_money'], 0, ',', '.')); ?>đ
                                    </td>

                                    <td style="width: 200px;">
                                        <form action="/adminOrder/updateStatus" method="POST" class="d-flex gap-2 m-0">
                                            <input type="hidden" name="order_id" value="<?php echo e($order['id']); ?>">
                                            <select name="status" class="form-select form-select-sm status-<?php echo e($order['status']); ?>"
                                                data-original-status="<?php echo e($order['status']); ?>"
                                                onchange="confirmStatusChange(this)">
                                                <option value="1" class="status-1" <?php echo e($order['status'] == 1 ? 'selected' : ''); ?>>Chờ duyệt</option>
                                                <option value="2" class="status-2" <?php echo e($order['status'] == 2 ? 'selected' : ''); ?>>Đang giao</option>
                                                <option value="3" class="status-3" <?php echo e($order['status'] == 3 ? 'selected' : ''); ?>>Đã giao</option>
                                                <option value="4" class="status-4" <?php echo e($order['status'] == 4 ? 'selected' : ''); ?>>Đã hủy</option>
                                            </select>
                                        </form>
                                    </td>

                                    <td class="text-end pe-4">
                                        <a href="/adminOrder/detail/<?php echo e($order['id']); ?>"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> Chi tiết
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function updateSelectColor(selectElement, statusValue) {
            selectElement.classList.remove('status-1', 'status-2', 'status-3', 'status-4');
            selectElement.classList.add('status-' + statusValue);
        }

        function confirmStatusChange(selectElement) {
            const originalStatus = parseInt(selectElement.getAttribute('data-original-status'));
            const newStatus = parseInt(selectElement.value);

            updateSelectColor(selectElement, newStatus);

            if (originalStatus === 4) {
                Swal.fire({
                    icon: 'error',
                    title: 'Thao tác không hợp lệ',
                    text: 'Đơn hàng này đã bị hủy, bạn không thể thay đổi trạng thái được nữa!',
                    confirmButtonColor: '#d33'
                });
                selectElement.value = originalStatus;
                updateSelectColor(selectElement, originalStatus);
                return;
            }

            if (newStatus === 4 && (originalStatus === 2 || originalStatus === 3)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Không thể hủy đơn',
                    text: 'Chỉ được hủy khi đơn hàng đang "Chờ duyệt". Đơn đang giao hoặc đã giao thì không thể hủy!',
                    confirmButtonColor: '#f8bb86'
                });
                selectElement.value = originalStatus;
                updateSelectColor(selectElement, originalStatus);
                return;
            }

            Swal.fire({
                title: 'Xác nhận cập nhật?',
                text: "Bạn có chắc chắn muốn thay đổi trạng thái đơn hàng này?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý cập nhật',
                cancelButtonText: 'Hủy bỏ'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Đang xử lý...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });
                    selectElement.form.submit();
                } else {
                    selectElement.value = originalStatus;
                    updateSelectColor(selectElement, originalStatus);
                }
            });
        }
    </script>

    <?php if (isset($_SESSION['success'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: '<?= $_SESSION['success'] ?>',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi rùi!',
                text: '<?= $_SESSION['error'] ?>',
                confirmButtonColor: '#d33'
            });
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/orders/index.blade.php ENDPATH**/ ?>