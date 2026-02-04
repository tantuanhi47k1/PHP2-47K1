@extends('layout.clientLayout')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold text-uppercase">Thanh toán</h2>

    @if (!empty($errors))
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="/checkout/process" method="POST">
        <div class="row">
            <div class="col-md-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Thông tin giao hàng</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" name="fullname" class="form-control" placeholder="Nguyễn Văn A" 
                                value="<?= htmlspecialchars($old['fullname'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" placeholder="09xxxx..." 
                                value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" placeholder="Số nhà, phường, quận..." 
                                value="<?= htmlspecialchars($old['address'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ghi chú đơn hàng</label>
                            <textarea name="note" class="form-control" rows="3" placeholder="Ví dụ: Giao giờ hành chính..."><?= htmlspecialchars($old['note'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Đơn hàng của bạn</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            @foreach ($cart as $item)
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0"><?= htmlspecialchars($item['name']) ?></h6>
                                        <small class="text-muted">SL: <?= $item['quantity'] ?> x <?= number_format($item['price']) ?>đ</small>
                                    </div>
                                    <span class="text-muted"><?= number_format($item['price'] * $item['quantity']) ?>đ</span>
                                </li>
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between bg-light">
                                <span class="fw-bold">Tổng tiền</span>
                                <strong class="text-danger fs-5"><?= number_format($totalPrice) ?> VND</strong>
                            </li>
                        </ul>

                        <hr>

                        <h6 class="fw-bold mb-3">Phương thức thanh toán</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" id="paymentCod" value="cod" checked>
                            <label class="form-check-label" for="paymentCod">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="payment_method" id="paymentBank" value="banking">
                            <label class="form-check-label" for="paymentBank">
                                Chuyển khoản ngân hàng
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold text-uppercase">
                            Đặt hàng ngay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection