@extends('layout.clientLayout')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold text-uppercase text-primary"><i class="bi bi-credit-card-2-front me-2"></i>Thanh toán</h2>

        @if (isset($errors) && !empty($errors))
            <div class="alert alert-danger shadow-sm border-0 mb-4">
                <ul class="mb-0">
                    @foreach ($errors as $e)
                        <li><i class="bi bi-exclamation-circle me-2"></i>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/checkout/process" method="POST" id="checkoutForm">
            <input type="hidden" name="cart_data" id="cart_data_input">

            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-person-lines-fill me-2"></i>Thông tin giao hàng</h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Họ và tên <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="fullname" class="form-control bg-light"
                                        placeholder="Nguyễn Văn A"
                                        value="{{ $old['fullname'] ?? ($user['full_name'] ?? '') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="phone" class="form-control bg-light"
                                        placeholder="09xxxx..." value="{{ $old['phone'] ?? ($user['phone'] ?? '') }}"
                                        required>

                                    @if (isset($user) && empty($user['phone']))
                                        <div class="form-text text-danger small fst-italic">
                                            <i class="bi bi-info-circle"></i> Vui lòng cập nhật số điện thoại để nhận hàng.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email (Để nhận thông báo)</label>
                                <input type="email" name="email" class="form-control bg-light"
                                    placeholder="email@example.com" value="{{ $old['email'] ?? ($user['email'] ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Địa chỉ nhận hàng <span
                                        class="text-danger">*</span></label>

                                <div class="row g-2 mb-2">
                                    <div class="col-md-4"><select class="form-select" id="province" required>
                                            <option value="">Tỉnh/Thành</option>
                                        </select></div>
                                    <div class="col-md-4"><select class="form-select" id="district" disabled required>
                                            <option value="">Quận/Huyện</option>
                                        </select></div>
                                    <div class="col-md-4"><select class="form-select" id="ward" disabled required>
                                            <option value="">Phường/Xã</option>
                                        </select></div>
                                </div>

                                <input type="text" id="address_detail" class="form-control"
                                    placeholder="Số nhà, tên đường..."
                                    value="{{ $old['address'] ?? ($user['address'] ?? '') }}" required>

                                <input type="hidden" name="address" id="full_address"
                                    value="{{ $old['address'] ?? ($user['address'] ?? '') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Ghi chú</label>
                                <textarea name="note" class="form-control" rows="2" placeholder="Ghi chú về đơn hàng...">{{ $old['note'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-bag-check-fill me-2"></i>Đơn hàng của bạn</h5>
                        </div>
                        <div class="card-body p-4">

                            <ul class="list-group list-group-flush mb-4" id="cart-list">
                                <li class="list-group-item text-center py-4 text-muted">
                                    <div class="spinner-border text-primary spinner-border-sm" role="status"></div>
                                    <div class="mt-2 small">Đang tải giỏ hàng...</div>
                                </li>
                            </ul>

                            <div class="bg-light p-3 rounded-3 mb-4">
                                <h6 class="fw-bold mb-3 small text-uppercase text-muted">Phương thức thanh toán</h6>

                                <div class="form-check p-3 bg-white border rounded mb-2 payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="paymentCod"
                                        value="cod" checked>
                                    <label class="form-check-label w-100 d-flex justify-content-between align-items-center"
                                        for="paymentCod" style="cursor: pointer;">
                                        <span><i class="bi bi-truck me-2 text-success"></i>COD (Thanh toán khi nhận)</span>
                                    </label>
                                </div>
                                <div class="form-check p-3 bg-white border rounded mb-2 payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        id="paymentVnpay" value="vnpay">
                                    <label class="form-check-label w-100 d-flex justify-content-between align-items-center"
                                        for="paymentVnpay" style="cursor: pointer;">
                                        <span class="fw-semibold text-primary">VNPAY QR</span>
                                        <img src="https://vnpay.vn/assets/images/logo-icon/logo-primary.svg"
                                            height="20" alt="VNPAY">
                                    </label>
                                </div>
                                <div class="form-check p-3 bg-white border rounded mb-2 payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        id="paymentMomo" value="momo">
                                    <label class="form-check-label w-100 d-flex justify-content-between align-items-center"
                                        for="paymentMomo" style="cursor: pointer;">
                                        <span class="fw-semibold" style="color: #a50064;">Ví MoMo</span>

                                        <img src="https://avatars.githubusercontent.com/u/36770798?s=200&v=4"
                                            height="30" class="rounded" alt="MoMo">
                                    </label>
                                </div>
                                <div class="form-check p-3 bg-white border rounded payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        id="paymentBank" value="banking">
                                    <label class="form-check-label w-100 d-flex justify-content-between align-items-center"
                                        for="paymentBank" style="cursor: pointer;">
                                        <span><i class="bi bi-bank me-2 text-secondary"></i>Chuyển khoản ngân hàng</span>
                                    </label>
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-primary w-100 py-3 fw-bold text-uppercase shadow-lg rounded-pill btn-place-order">
                                Đặt hàng ngay <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            renderCheckoutCart();
        });

        function renderCheckoutCart() {
            const cartJson = localStorage.getItem('cart');
            const cart = JSON.parse(cartJson || '[]');
            const cartList = $('#cart-list');
            const cartInput = $('#cart_data_input');

            cartInput.val(JSON.stringify(cart));

            if (cart.length === 0) {
                cartList.html(
                    '<li class="list-group-item text-center py-5"><i class="bi bi-cart-x text-danger fs-1"></i><p class="mt-3 text-muted">Giỏ hàng trống!</p><a href="/shop" class="btn btn-sm btn-outline-primary mt-2">Quay lại mua sắm</a></li>'
                    );
                $('.btn-place-order').prop('disabled', true).text('Giỏ hàng trống');
                return;
            }

            let html = '';
            let total = 0;

            cart.forEach(item => {
                let price = parseFloat(item.price) || 0;
                let qty = parseInt(item.quantity) || 1;
                let itemTotal = price * qty;
                total += itemTotal;

                let img = 'https://placehold.co/60x60?text=No+Img';
                if (item.image && item.image !== '') {
                    img = item.image.startsWith('/') || item.image.startsWith('http') ? item.image : '/' + item
                        .image;
                }

                html += `
                <li class="list-group-item d-flex align-items-center py-3 px-0 border-bottom-dashed">
                    <div class="me-3 position-relative">
                        <img src="${img}" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;" onerror="this.src='https://placehold.co/60x60?text=Err'">
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary border border-light">${qty}</span>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="my-0 text-truncate" style="max-width: 180px;">${item.name}</h6>
                        <small class="text-muted d-block">${item.variant_name || ''}</small>
                    </div>
                    <span class="fw-bold text-dark">${new Intl.NumberFormat('vi-VN').format(itemTotal)}đ</span>
                </li>
            `;
            });

            html +=
                `<li class="list-group-item d-flex justify-content-between py-3 px-0 border-0"><span class="fw-bold fs-5">Tổng cộng</span><strong class="text-danger fs-4">${new Intl.NumberFormat('vi-VN').format(total)}đ</strong></li>`;
            cartList.html(html);
        }

        const host = "https://provinces.open-api.vn/api/";
        var callAPI = (api) => {
            return axios.get(api).then((response) => {
                renderData(response.data, "province");
            });
        }
        callAPI(host + "?depth=1");
        var callApiDistrict = (api) => {
            return axios.get(api).then((response) => {
                renderData(response.data.districts, "district");
            });
        }
        var callApiWard = (api) => {
            return axios.get(api).then((response) => {
                renderData(response.data.wards, "ward");
            });
        }

        var renderData = (array, select) => {
            let row = ' <option value="">Chọn ' + (select == "province" ? "Tỉnh/Thành" : (select == "district" ?
                "Quận/Huyện" : "Phường/Xã")) + '</option>';
            array.forEach(element => {
                row += `<option data-name="${element.name}" value="${element.code}">${element.name}</option>`
            });
            document.querySelector("#" + select).innerHTML = row;
        }

        $("#province").change(() => {
            let provinceCode = $("#province").val();
            if (provinceCode) {
                $("#district").prop("disabled", false);
                callApiDistrict(host + "p/" + provinceCode + "?depth=2");
                $("#ward").html('<option value="">Chọn Phường/Xã</option>').prop("disabled", true);
            } else {
                $("#district").prop("disabled", true);
                $("#ward").prop("disabled", true);
            }
            updateFullAddress();
        });

        $("#district").change(() => {
            let districtCode = $("#district").val();
            if (districtCode) {
                $("#ward").prop("disabled", false);
                callApiWard(host + "d/" + districtCode + "?depth=2");
            } else {
                $("#ward").prop("disabled", true);
            }
            updateFullAddress();
        });

        $("#ward, #address_detail").on('change input', () => {
            updateFullAddress();
        });

        function updateFullAddress() {
            let province = $("#province option:selected").data('name') || '';
            let district = $("#district option:selected").data('name') || '';
            let ward = $("#ward option:selected").data('name') || '';
            let detail = $("#address_detail").val() || '';
            let fullAddr = detail;
            if (ward) fullAddr += ", " + ward;
            if (district) fullAddr += ", " + district;
            if (province) fullAddr += ", " + province;

            $("#full_address").val(fullAddr);
        }
    </script>

    <style>
        .payment-option input:checked+label {
            color: #0d6efd;
        }

        .payment-option:hover {
            background-color: #f8f9fa !important;
            border-color: #0d6efd !important;
        }

        .payment-option input:checked {
            border-color: #0d6efd;
            background-color: #0d6efd;
        }

        .border-bottom-dashed {
            border-bottom: 1px dashed #dee2e6 !important;
        }

        .btn-place-order:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3) !important;
        }
    </style>
@endsection
