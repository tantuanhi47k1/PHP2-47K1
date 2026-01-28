

<?php $__env->startSection('content'); ?>
<style>
    :root { --primary-color: #009981; }
    .text-brand { color: var(--primary-color) !important; }
    .btn-brand { background-color: var(--primary-color); color: white; }
    .btn-brand:hover { background-color: #007a67; color: white; }
    .admin-avatar { width: 45px; height: 45px; object-fit: cover; border-radius: 10px; border: 2px solid #eee; }
    .role-badge { font-size: 0.75rem; padding: 0.4em 0.8em; }
</style>

<div class="container-fluid py-5 px-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <div>
                <h4 class="fw-bold text-brand mb-0"><i class="bi bi-shield-lock-fill me-2"></i>Quản lý Ban quản trị</h4>
                <small class="text-muted">Danh sách tài khoản có quyền truy cập hệ thống ThinkHub</small>
            </div>
            <a href="/adminmanage/create" class="btn btn-brand btn-sm shadow-sm px-3">
                <i class="bi bi-person-plus-fill me-1"></i> Thêm Admin mới
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th>Thông tin Admin</th>
                        <th>Tên đăng nhập</th>
                        <th>Cấp độ quyền</th>
                        <th class="text-center pe-4">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($admins)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Chưa có tài khoản quản trị nào được tạo.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($admins as $ad): ?>
                    <tr>
                        <td class="ps-4"><span class="text-muted">#<?= $ad['id'] ?></span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="/<?= $ad['avatar'] ?: 'image/avatar/admin-default.png' ?>" 
                                     class="admin-avatar me-3 shadow-sm"
                                     onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($ad['username']) ?>&background=009981&color=fff'">
                                <div>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($ad['email']) ?></div>
                                    <small class="text-muted">Email liên hệ</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border px-2 py-1 font-monospace">
                                <?= htmlspecialchars($ad['username']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if($ad['role'] == 1): ?>
                                <span class="badge bg-info bg-opacity-10 text-info border border-info role-badge">
                                    <i class="bi bi-pencil-square me-1"></i> Chờ cấp quyền
                                </span>
                            <?php elseif($ad['role'] == 2): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger role-badge">
                                    <i class="bi bi-star-fill me-1"></i> Super Admin
                                </span>
                            <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary role-badge">
                                    Cấp độ: <?= $ad['role'] ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center pe-4">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="/adminmanage/edit/<?= $ad['id'] ?>" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="/adminmanage/delete/<?= $ad['id'] ?>" class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Xóa tài khoản admin [<?= htmlspecialchars($ad['username']) ?>]? Thao tác này không thể hoàn tác.');" title="Xóa">
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
        <div class="card-footer bg-white py-3">
            <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Lưu ý: Chỉ Super Admin (Role 1) mới nên có quyền quản lý trang này.</small>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.adminLayout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\php2_tantuan47k1\app\views/admin/adminmanage/index.blade.php ENDPATH**/ ?>