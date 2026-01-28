@extends('layout.adminLayout')
@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-header bg-white py-3"><h5 class="fw-bold mb-0">Sửa thông tin Admin: <?= $admin['username'] ?></h5></div>
        <div class="card-body">
            <form action="/adminmanage/update/<?= $admin['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="text-center mb-3">
                    <img src="/<?= $admin['avatar'] ?>" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" value="<?= $admin['username'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $admin['email'] ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Đổi mật khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="Để trống nếu giữ cũ">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Cấp độ (Role)</label>
                        <select name="role" class="form-select">
                            <option value="1" <?= $admin['role'] == 1 ? 'selected' : '' ?>>1 - Đang chờ cấp quyền</option>
                            <option value="2" <?= $admin['role'] == 2 ? 'selected' : '' ?>>2 - Super Admin</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Thay ảnh mới</label>
                    <input type="file" name="avatar" class="form-control">
                </div>
                <button type="submit" class="btn btn-success w-100 fw-bold">Cập nhật ngay</button>
            </form>
        </div>
    </div>
</div>
@endsection