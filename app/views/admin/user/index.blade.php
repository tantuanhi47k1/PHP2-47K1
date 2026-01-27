@extends('layout.adminLayout')

@section('content')
    <style>
        :root { --primary-color: #009981; }
        .text-brand { color: var(--primary-color) !important; }
        .btn-brand { background-color: var(--primary-color); color: white; }
        .btn-brand:hover { background-color: #007a67; color: white; }
        .img-avatar { width: 40px; height: 40px; object-fit: cover; border-radius: 50%; border: 1px solid #eee; }
    </style>

    <div class="container py-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-brand"><i class="bi bi-people me-2"></i>Người dùng</h4>
                <a href="/user/create" class="btn btn-brand btn-sm shadow-sm"><i class="bi bi-person-plus me-1"></i> Thêm mới</a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Họ tên / Email</th>
                            <th>Liên hệ</th>
                            <th class="text-center">Vai trò</th>
                            <th class="text-center pe-4">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($users as $u): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="/<?= $u['avatar'] ?? 'image/avatar/default.png' ?>" class="img-avatar me-3" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($u['full_name']) ?>'">
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($u['full_name']) ?></div>
                                        <small class="text-muted"><?= htmlspecialchars($u['email']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="bi bi-telephone me-1"></i> <?= htmlspecialchars($u['phone'] ?? '---') ?></div>
                                <small class="text-muted"><?= htmlspecialchars($u['address'] ?? '') ?></small>
                            </td>
                            <td class="text-center">
                                <?php if($u['role'] === 'admin'): ?>
                                    <span class="badge bg-danger rounded-pill px-3">Quản trị</span>
                                <?php else: ?>
                                    <span class="badge bg-info text-dark rounded-pill px-3">Khách hàng</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <a href="/user/edit/<?= $u['id'] ?>" class="btn btn-sm btn-light border text-primary" title="Sửa"><i class="bi bi-pencil"></i></a>
                                <a href="/user/delete/<?= $u['id'] ?>" class="btn btn-sm btn-light border text-danger ms-1" onclick="return confirm('Xóa người dùng này?');"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection