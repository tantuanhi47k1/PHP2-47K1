

<?php $__env->startSection('content'); ?>
<style>
    .text-brand { color: #009981 !important; }
    .btn-brand { background-color: #009981; color: white; }
    .btn-brand:hover { background-color: #007a67; color: white; }
    .current-avatar { width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #eee; }
    #preview-avatar { width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #009981; display: none; }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-brand"><i class="bi bi-person-gear me-2"></i>Cập nhật thông tin thành viên</h5>
                    <a href="/user/index" class="btn btn-outline-secondary btn-sm">Quay lại</a>
                </div>
                <div class="card-body p-4">
                    <form action="/user/update/<?= $user['id'] ?>" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <div class="d-flex justify-content-center align-items-center gap-4">
                                    <div>
                                        <small class="d-block text-muted mb-1">Ảnh hiện tại</small>
                                        <img src="/<?= $user['avatar'] ?: 'image/avatar/default.png' ?>" class="current-avatar">
                                    </div>
                                    <div id="avatar-preview-container">
                                        <small class="d-block text-brand mb-1" id="preview-label" style="display:none;">Ảnh mới</small>
                                        <img id="preview-avatar" src="#">
                                    </div>
                                </div>
                                <div class="mt-3 mx-auto" style="max-width: 300px;">
                                    <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*" onchange="previewFile(this)">
                                    <small class="text-muted">Định dạng: JPG, PNG. Để trống nếu giữ ảnh cũ.</small>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Địa chỉ Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small">Mật khẩu mới</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••">
                                <small class="text-muted">Chỉ nhập nếu bạn muốn thay đổi mật khẩu.</small>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label fw-bold small">Địa chỉ thường trú</label>
                                <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($user['address']) ?></textarea>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-brand w-100 fw-bold py-2">
                                    Lưu thay đổi thông tin
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewFile(input) {
        const preview = document.getElementById('preview-avatar');
        const label = document.getElementById('preview-label');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                label.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH G:\laragon\www\PHP2-47K1\app\views/admin/user/edit.blade.php ENDPATH**/ ?>