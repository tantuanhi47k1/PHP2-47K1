

<?php $__env->startSection('content'); ?>
<style>
    .text-brand { color: #009981 !important; }
    .btn-brand { background-color: #009981; color: white; }
    .btn-brand:hover { background-color: #007a67; color: white; }
    .user-avatar { width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 2px solid #eee; }
    .table thead th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
</style>

<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold text-brand"><i class="bi bi-people-fill me-2"></i>Quản lý người dùng</h4>
            <a href="/user/create" class="btn btn-brand btn-sm shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Thêm người dùng
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4">Thành viên</th>
                        <th>Liên hệ</th>
                        <th>Địa chỉ</th>
                        <th>Phương thức</th>
                        <th>Ngày tham gia</th>
                        <th class="text-center pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($users)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Hệ thống chưa có người dùng nào.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($users as $u): ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="/<?= $u['avatar'] ?: 'image/avatar/default.png' ?>" 
                                     class="user-avatar me-3" 
                                     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($u['full_name']) ?>&background=009981&color=fff'">
                                <div>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($u['full_name']) ?></div>
                                    <small class="text-muted">ID: #<?= $u['id'] ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="small"><i class="bi bi-envelope me-1"></i><?= htmlspecialchars($u['email']) ?></span>
                                <span class="small text-muted"><i class="bi bi-telephone me-1"></i><?= htmlspecialchars($u['phone'] ?: 'Chưa cập nhật') ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;" title="<?= htmlspecialchars($u['address']) ?>">
                                <small class="text-muted"><?= htmlspecialchars($u['address'] ?: '---') ?></small>
                            </div>
                        </td>
                        <td>
                            <?php if($u['auth_provider'] === 'google'): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger small">
                                    <i class="bi bi-google me-1"></i> Google
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary small">
                                    <i class="bi bi-shield-lock me-1"></i> Hệ thống
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <small class="text-muted"><?= date('d/m/Y', strtotime($u['created_at'])) ?></small>
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="/user/edit/<?= $u['id'] ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/user/delete/<?= $u['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');" title="Xóa">
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
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/user/index.blade.php ENDPATH**/ ?>