

<?php $__env->startSection('title', 'Tài khoản của tôi'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .profile-sidebar .nav-link {
            color: #495057;
            font-weight: 500;
            padding: 12px 20px;
            border-radius: 8px;
            transition: 0.2s;
            display: flex;
            align-items: center;
        }

        .profile-sidebar .nav-link:hover,
        .profile-sidebar .nav-link.active {
            background-color: #eff6ff;
            color: #0d6efd;
        }

        .profile-sidebar .nav-link i {
            font-size: 1.2rem;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        .avatar-wrapper {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            position: relative;
        }

        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            background: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #adb5bd;
        }
    </style>

    <div class="container py-5">
        <div class="row g-4">

            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 text-center border-bottom">

                        <div class="avatar-wrapper mb-3">
                            <?php if(!empty($user['avatar'])): ?>
                                <?php
                                    $src =
                                        strpos($user['avatar'], 'http') === 0 ? $user['avatar'] : '/' . $user['avatar'];
                                ?>
                                <img src="<?php echo e($src); ?>" class="avatar-img"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="avatar-placeholder" style="display: none;"><i class="bi bi-person-fill"></i>
                                </div>
                            <?php else: ?>
                                <div class="avatar-placeholder"><i class="bi bi-person-fill"></i></div>
                            <?php endif; ?>
                        </div>

                        <h6 class="fw-bold mb-1"><?php echo e($user['full_name']); ?></h6>
                        <small class="text-muted"><?php echo e($user['email']); ?></small>
                    </div>
                    <div class="card-body p-3 profile-sidebar">
                        <nav class="nav flex-column gap-1">
                            <a href="/profile" class="nav-link <?php echo e(!isset($tab) || $tab == 'info' ? 'active' : ''); ?>">
                                <i class="bi bi-person-vcard"></i> Thông tin tài khoản
                            </a>
                            <a href="/profile?tab=orders"
                                class="nav-link <?php echo e(isset($tab) && $tab == 'orders' ? 'active' : ''); ?>">
                                <i class="bi bi-box-seam"></i> Lịch sử đơn hàng
                            </a>
                            <a href="/profile?tab=password"
                                class="nav-link <?php echo e(isset($tab) && $tab == 'password' ? 'active' : ''); ?>">
                                <i class="bi bi-shield-lock"></i> Đổi mật khẩu
                            </a>
                            <hr class="my-2 text-muted opacity-25">
                            <a href="/auth/logout" class="nav-link text-danger">
                                <i class="bi bi-box-arrow-right"></i> Đăng xuất
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm">
                        <i class="bi bi-check-circle-fill me-2"></i> <?php echo e($_SESSION['success']); ?> <button type="button"
                            class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?php echo e($_SESSION['error']); ?> <button type="button"
                            class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">

                        <?php if(!isset($tab) || $tab == 'info'): ?>
                            <h4 class="fw-bold mb-4">Hồ sơ của tôi</h4>
                            <form action="/profile/updateInfo" method="POST" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted">Họ và
                                            tên</label><input type="text" name="fullname" class="form-control"
                                            value="<?php echo e($user['full_name']); ?>" required></div>
                                    <div class="col-md-6"><label
                                            class="form-label fw-bold small text-muted">Email</label><input type="email"
                                            class="form-control bg-light" value="<?php echo e($user['email']); ?>" readonly disabled>
                                    </div>
                                    <div class="col-md-6"><label class="form-label fw-bold small text-muted">Số điện
                                            thoại</label><input type="text" name="phone" class="form-control"
                                            value="<?php echo e($user['phone'] ?? ''); ?>"></div>
                                    <div class="col-md-12"><label class="form-label fw-bold small text-muted">Địa
                                            chỉ</label><input type="text" name="address" class="form-control"
                                            value="<?php echo e($user['address'] ?? ''); ?>"></div>
                                    <div class="col-12 mt-4 text-end"><button type="submit"
                                            class="btn btn-primary rounded-pill px-4"><i class="bi bi-save me-1"></i> Lưu
                                            thay đổi</button></div>
                                </div>
                            </form>
                        <?php elseif(isset($tab) && $tab == 'password'): ?>
                            <h4 class="fw-bold mb-4">Đổi mật khẩu</h4>
                            <form action="/profile/changePassword" method="POST">
                                <div class="mb-3"><label class="form-label fw-bold small text-muted">Mật khẩu hiện
                                        tại</label><input type="password" name="current_password" class="form-control"
                                        required></div>
                                <div class="mb-3"><label class="form-label fw-bold small text-muted">Mật khẩu
                                        mới</label><input type="password" name="new_password" class="form-control" required>
                                </div>
                                <div class="mb-3"><label class="form-label fw-bold small text-muted">Xác nhận mật
                                        khẩu</label><input type="password" name="confirm_password" class="form-control"
                                        required></div>
                                <div class="mt-4 text-end"><button type="submit"
                                        class="btn btn-primary rounded-pill px-4"><i class="bi bi-key me-1"></i> Cập
                                        nhật</button></div>
                            </form>
                        <?php elseif(isset($tab) && $tab == 'orders'): ?>
                            <h4 class="fw-bold mb-4">Lịch sử đơn hàng</h4>
                            <?php if(empty($orders)): ?>
                                <div class="text-center py-5"><i class="bi bi-box-seam text-muted opacity-25"
                                        style="font-size: 4rem;"></i>
                                    <p class="text-muted mt-3">Chưa có đơn hàng nào.</p><a href="/shop"
                                        class="btn btn-outline-primary rounded-pill px-4">Mua sắm ngay</a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="bg-light small text-muted text-uppercase">
                                            <tr>
                                                <th>Mã đơn</th>
                                                <th>Ngày đặt</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th class="text-end">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><span class="fw-bold text-primary">#<?php echo e($order['id']); ?></span>
                                                    </td>
                                                    <td><?php echo e(date('d/m/Y', strtotime($order['created_at']))); ?></td>
                                                    <td class="fw-bold">
                                                        <?php echo e(number_format($order['total_money'], 0, ',', '.')); ?>đ</td>
                                                    <td>
                                                        <?php if($order['status'] == 1): ?>
                                                            <span
                                                                class="badge bg-warning text-dark bg-opacity-25 border border-warning">Chờ
                                                                xử lý</span>
                                                        <?php elseif($order['status'] == 2): ?>
                                                            <span
                                                                class="badge bg-info bg-opacity-25 text-info border border-info">Đang
                                                                giao</span>
                                                        <?php elseif($order['status'] == 3): ?>
                                                            <span
                                                                class="badge bg-success bg-opacity-25 text-success border border-success">Hoàn
                                                                thành</span>
                                                        <?php else: ?>
                                                            <span
                                                                class="badge bg-danger bg-opacity-25 text-danger border border-danger">Đã
                                                                hủy</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <a href="/profile/order/<?php echo e($order['id']); ?>"
                                                                class="btn btn-sm btn-outline-primary rounded-pill">Xem chi
                                                                tiết</a>

                                                            <?php if($order['status'] == 1): ?>
                                                                <a href="javascript:void(0)"
                                                                    data-url="/profile/cancelOrder/<?php echo e($order['id']); ?>"
                                                                    class="btn btn-sm btn-outline-danger rounded-pill btn-cancel-order">
                                                                    Hủy đơn
                                                                </a>
                                                            <?php endif; ?>

                                                            <?php if($order['status'] == 3): ?>
                                                                <a href="/profile/reorder/<?php echo e($order['id']); ?>"
                                                                    class="btn btn-sm btn-success text-white rounded-pill">
                                                                    Mua lại
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelButtons = document.querySelectorAll('.btn-cancel-order');
            
            cancelButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('data-url');

                    Swal.fire({
                        title: 'Hủy đơn hàng này?',
                        text: "Số lượng sản phẩm sẽ được tự động hoàn lại vào kho!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bi bi-trash"></i> Hủy ngay!',
                        cancelButtonText: 'Không, giữ lại'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = url;
                        }
                    })
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.clientLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/client/profile/index.blade.php ENDPATH**/ ?>