@extends('layout.adminLayout')
@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px;">
        <div class="card-header bg-white py-3"><h5 class="fw-bold mb-0">Thêm Quản trị viên</h5></div>
        <div class="card-body">
            <form action="/adminmanage/store" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Tên đăng nhập (Username) *</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold">Email quản trị *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Mật khẩu *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label small fw-bold">Cấp độ (Role) *</label>
                        <select name="role" class="form-select">
                            <option value="1">1 - Đang chờ cấp quyền</option>
                            <option value="2">2 - Toàn quyền (Super Admin)</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Ảnh đại diện</label>
                    <input type="file" name="avatar" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Tạo tài khoản</button>
            </form>
        </div>
    </div>
</div>
@endsection