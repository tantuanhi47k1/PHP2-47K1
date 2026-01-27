@extends('layout.adminLayout')

@section('content')
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

        .img-edit-avatar {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #eee;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-brand m-0"><i class="bi bi-person-gear me-2"></i>Cập nhật Người dùng</h4>
                    <a href="/user" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Quay lại</a>
                </div>

                <div class="card p-4 border-0 shadow-sm">
                    <form action="/user/update/<?= $user['id'] ?>" method="POST" enctype="multipart/form-data">
                        
                        <div class="text-center mb-4">
                            <img src="/<?= $user['avatar'] ?? 'image/avatar/default.png' ?>" class="img-edit-avatar mb-2" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=random'">
                            <div class="small text-muted">Ảnh đại diện hiện tại</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required
                                    value="<?= htmlspecialchars($user['name']) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" required
                                    value="<?= htmlspecialchars($user['email']) ?>">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thay đổi Mật khẩu</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Để trống nếu không muốn đổi">
                                <small class="text-muted fst-italic">Giữ nguyên mật khẩu cũ nếu không nhập.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thay ảnh đại diện mới</label>
                                <input type="file" name="avatar" class="form-control" accept="image/*">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số điện thoại</label>
                                <input type="text" name="phone" class="form-control"
                                    value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Vai trò</label>
                                <select name="role" class="form-select">
                                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Khách hàng (User)</option>
                                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Quản trị viên (Admin)</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Địa chỉ</label>
                            <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-brand fw-bold py-2">
                                <i class="bi bi-check-lg me-1"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection