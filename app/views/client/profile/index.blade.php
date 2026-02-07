@extends('layout.clientLayout')

@section('title', 'Tài khoản của tôi')

@section('content')
<style>
    /* CSS Riêng cho trang Profile */
    .profile-sidebar .nav-link { 
        color: #495057; 
        font-weight: 500; 
        padding: 12px 20px; 
        border-radius: 8px; 
        transition: 0.2s; 
        display: flex;
        align-items: center;
    }
    .profile-sidebar .nav-link:hover, .profile-sidebar .nav-link.active { 
        background-color: #eff6ff; 
        color: #0d6efd; 
    }
    .profile-sidebar .nav-link i { 
        font-size: 1.2rem; 
        margin-right: 12px; 
        width: 24px;
        text-align: center;
    }
    .avatar-placeholder { 
        width: 80px; 
        height: 80px; 
        background: #e9ecef; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 2.5rem; 
        color: #adb5bd; 
        margin: 0 auto;
    }
</style>

<div class="container py-5">
    <div class="row g-4">
        
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 text-center border-bottom">
                    <div class="avatar-placeholder mb-3">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h6 class="fw-bold mb-1">{{ $user['full_name'] }}</h6>
                    <small class="text-muted">{{ $user['email'] }}</small>
                </div>
                <div class="card-body p-3 profile-sidebar">
                    <nav class="nav flex-column gap-1">
                        <a href="/profile" class="nav-link {{ (!isset($_GET['tab']) && !isset($orders)) ? 'active' : '' }}">
                            <i class="bi bi-person-vcard"></i> Thông tin tài khoản
                        </a>
                        <a href="/profile/orders" class="nav-link {{ (isset($tab) && $tab == 'orders') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i> Lịch sử đơn hàng
                        </a>
                        <a href="/profile?tab=password" class="nav-link {{ (isset($_GET['tab']) && $_GET['tab'] == 'password') ? 'active' : '' }}">
                            <i class="bi bi-shield-lock"></i> Đổi mật khẩu
                        </a>
                        <hr class="my-2 text-muted opacity-25">
                        <a href="/auth/logout" class="nav-link text-danger">
                            <i class="bi bi-box-arrow-right"></i> Đăng xuất
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            
            @if(isset($_SESSION['success']))
                <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ $_SESSION['success'] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @php unset($_SESSION['success']); @endphp
            @endif

            @if(isset($_SESSION['error']))
                <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $_SESSION['error'] }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @php unset($_SESSION['error']); @endphp
            @endif

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    
                    @if(!isset($_GET['tab']) && !isset($orders))
                        <h4 class="fw-bold mb-4">Hồ sơ của tôi</h4>
                        <form action="/profile/updateInfo" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Họ và tên</label>
                                    <input type="text" name="fullname" class="form-control py-2" value="{{ $user['full_name'] }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Email</label>
                                    <input type="email" class="form-control py-2 bg-light" value="{{ $user['email'] }}" readonly disabled>
                                    <small class="text-muted fst-italic" style="font-size: 0.75rem;">Email không thể thay đổi</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small text-muted">Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control py-2" value="{{ $user['phone'] ?? '' }}" placeholder="Thêm số điện thoại...">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-muted">Địa chỉ giao hàng mặc định</label>
                                    <input type="text" name="address" class="form-control py-2" value="{{ $user['address'] ?? '' }}" placeholder="Nhập địa chỉ của bạn...">
                                </div>
                                <div class="col-12 mt-4 pt-2 border-top text-end">
                                    <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
                                        <i class="bi bi-save me-1"></i> Lưu thay đổi
                                    </button>
                                </div>
                            </div>
                        </form>

                    @elseif(isset($_GET['tab']) && $_GET['tab'] == 'password')
                        <h4 class="fw-bold mb-4">Đổi mật khẩu</h4>
                        <form action="/profile/changePassword" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Mật khẩu hiện tại</label>
                                <input type="password" name="current_password" class="form-control py-2" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Mật khẩu mới</label>
                                <input type="password" name="new_password" class="form-control py-2" required minlength="6">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small text-muted">Xác nhận mật khẩu mới</label>
                                <input type="password" name="confirm_password" class="form-control py-2" required minlength="6">
                            </div>
                            <div class="mt-4 pt-2 border-top text-end">
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
                                    <i class="bi bi-key me-1"></i> Cập nhật mật khẩu
                                </button>
                            </div>
                        </form>

                    @elseif(isset($tab) && $tab == 'orders')
                        <h4 class="fw-bold mb-4">Lịch sử đơn hàng</h4>
                        @if(empty($orders))
                            <div class="text-center py-5">
                                <i class="bi bi-box-seam text-muted opacity-25" style="font-size: 4rem;"></i>
                                <p class="text-muted mt-3">Bạn chưa có đơn hàng nào.</p>
                                <a href="/product" class="btn btn-outline-primary rounded-pill px-4 mt-2">Mua sắm ngay</a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="bg-light small text-muted text-uppercase">
                                        <tr>
                                            <th>Mã đơn</th>
                                            <th>Ngày đặt</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                            <th class="text-end">Chi tiết</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($orders as $order)
                                            <tr>
                                                <td><span class="fw-bold text-primary">#{{ $order['id'] }}</span></td>
                                                <td>{{ date('d/m/Y', strtotime($order['created_at'])) }}</td>
                                                <td class="fw-bold">{{ number_format($order['total_money'], 0, ',', '.') }}đ</td>
                                                <td>
                                                    @if($order['status'] == 1) <span class="badge bg-warning text-dark bg-opacity-25 border border-warning">Chờ xử lý</span>
                                                    @elseif($order['status'] == 2) <span class="badge bg-info bg-opacity-25 text-info border border-info">Đang giao</span>
                                                    @elseif($order['status'] == 3) <span class="badge bg-success bg-opacity-25 text-success border border-success">Hoàn thành</span>
                                                    @else <span class="badge bg-danger bg-opacity-25 text-danger border border-danger">Đã hủy</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    {{-- Link này sẽ dẫn tới trang chi tiết đơn hàng (Nếu sau này bạn làm) --}}
                                                    <a href="#" class="btn btn-sm btn-light rounded-pill border">Xem</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection