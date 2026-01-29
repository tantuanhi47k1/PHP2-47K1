@extends('layout.authLayout')

@section('title', 'Đặt lại mật khẩu')

@section('content')
    <div class="mb-5 text-start">
        <h2 class="fw-bold text-dark mb-2">Tạo mật khẩu mới 🔒</h2>
        <p class="text-muted">Mật khẩu mới của bạn phải khác với mật khẩu sử dụng trước đó.</p>
    </div>

    @if(isset($_SESSION['error']))
        <div class="alert alert-danger rounded-3 mb-4">{{ $_SESSION['error'] }}</div>
        @php unset($_SESSION['error']); @endphp
    @endif

    <form action="/auth/handleResetPassword" method="POST">
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-4 text-start">
            <label class="form-label">Mật khẩu mới</label>
            <input type="password" name="password" class="form-control py-3 ps-4" placeholder="******" required>
        </div>

        <div class="mb-4 text-start">
            <label class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" name="confirm_password" class="form-control py-3 ps-4" placeholder="******" required>
        </div>
        
        <div class="d-grid mb-4">
            <button type="submit" class="btn btn-primary btn-primary-modern text-white">ĐẶT LẠI MẬT KHẨU</button>
        </div>
    </form>
@endsection