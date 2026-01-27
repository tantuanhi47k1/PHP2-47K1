

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
        
        .card {
            border-radius: 12px;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-brand m-0"><i class="bi bi-person-plus me-2"></i>Thêm Người dùng mới</h4>
                    <a href="/user" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Quay lại</a>
                </div>

                <div class="card p-4 border-0 shadow-sm">
                    <form action="/user/store" method="POST" enctype="multipart/form-data">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required placeholder="Nguyễn Văn A">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email (Tài khoản) <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required placeholder="example@mail.com">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required placeholder="******">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ảnh đại diện</label>
                                <input type="file" name="avatar" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" placeholder="09xxxxxxxx">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Vai trò</label>
                                <select name="role" class="form-select">
                                    <option value="user">Khách hàng (User)</option>
                                    <option value="admin">Quản trị viên (Admin)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Địa chỉ</label>
                            <textarea name="address" class="form-control" rows="2" placeholder="Số nhà, tên đường, tỉnh/thành..."></textarea>
                        </div>

                        <div class="alert alert-info py-2 small">
                            <i class="bi bi-info-circle me-1"></i> Mặc định người dùng mới sẽ thuộc loại tài khoản "Local".
                        </div>

                        <button type="submit" class="btn btn-brand w-100 fw-bold py-2 mt-2">
                            <i class="bi bi-save me-1"></i> Lưu người dùng
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/user/create.blade.php ENDPATH**/ ?>