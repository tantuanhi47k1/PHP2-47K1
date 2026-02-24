@extends('layout.adminLayout')
@section('title', 'Chi tiết Đơn hàng')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Chi tiết Đơn hàng #{{ $order['id'] }}</h3>
        <a href="/adminOrder/index" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0"><i class="bi bi-person-lines-fill text-primary me-2"></i> Thông tin giao hàng</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted" style="width: 130px;">Khách hàng:</th>
                                <td class="fw-bold">{{ $order['fullname'] }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Điện thoại:</th>
                                <td>{{ $order['phone'] }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Email:</th>
                                <td>{{ !empty($order['email']) ? $order['email'] : 'Không có' }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Địa chỉ:</th>
                                <td>{{ $order['address'] }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Ghi chú:</th>
                                <td class="text-danger">{{ !empty($order['note']) ? $order['note'] : 'Không có ghi chú' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold mb-0"><i class="bi bi-info-circle-fill text-info me-2"></i> Trạng thái & Thanh toán</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="text-muted" style="width: 150px;">Ngày đặt:</th>
                                <td>{{ date('d/m/Y H:i:s', strtotime($order['created_at'])) }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Thanh toán:</th>
                                <td><span class="badge bg-secondary text-uppercase">{{ $order['payment_method'] }}</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted align-middle">Trạng thái:</th>
                                <td>
                                    <form action="/adminOrder/updateStatus" method="POST" class="d-flex align-items-center gap-2 m-0">
                                        <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                        <select name="status" class="form-select form-select-sm" style="width: 150px;">
                                            <option value="1" {{ $order['status'] == 1 ? 'selected' : '' }}>Chờ duyệt</option>
                                            <option value="2" {{ $order['status'] == 2 ? 'selected' : '' }}>Đang giao</option>
                                            <option value="3" {{ $order['status'] == 3 ? 'selected' : '' }}>Đã giao</option>
                                            <option value="4" {{ $order['status'] == 4 ? 'selected' : '' }}>Đã hủy</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="fw-bold mb-0"><i class="bi bi-box-seam text-success me-2"></i> Sản phẩm đã đặt</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive mt-3">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Sản phẩm</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-end">Đơn giá</th>
                            <th class="text-end pe-4">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderDetails as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    @if(!empty($item['image']))
                                        <img src="/{{ $item['image'] }}" alt="Ảnh" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" class="me-3 border">
                                    @else
                                        <div class="bg-light border rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                    <span class="fw-bold">{{ $item['product_name'] }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ $item['quantity'] }}</td>
                            <td class="text-end text-muted">{{ number_format($item['price'], 0, ',', '.') }}đ</td>
                            <td class="text-end pe-4 fw-bold text-danger">{{ number_format($item['total_price'], 0, ',', '.') }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold pt-3 pb-3">TỔNG CỘNG:</td>
                            <td class="text-end pe-4 fw-bold text-danger fs-5 pt-3 pb-3">{{ number_format($order['total_money'], 0, ',', '.') }}đ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection