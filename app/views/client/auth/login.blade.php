@extends('layout.clientLayout')

@section('title', 'Đăng nhập')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <div class="row justify-content-center align-items-center h-100">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary text-uppercase">Đăng Nhập</h3>
                        <p class="text-muted">Chào mừng bạn quay trở lại!</p>
                    </div>

                    {{-- Hiển thị thông báo LỖI --}}
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <div><?= $_SESSION['error'] ?></div>
                        </div>
                        <?php unset($_SESSION['error']); ?>
                    <?php endif; ?>

                    {{-- Hiển thị thông báo THÀNH CÔNG (khi đăng ký xong) --}}
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div><?= $_SESSION['success'] ?></div>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>

                    <form action="/auth/handleUserLogin" method="POST">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                            <label for="floatingInput">Địa chỉ Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                            <label for="floatingPassword">Mật khẩu</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label text-muted" for="rememberMe">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none small">Quên mật khẩu?</a>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg fw-bold" type="submit">ĐĂNG NHẬP</button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Chưa có tài khoản? <a href="/auth/register" class="fw-bold text-primary text-decoration-none">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection