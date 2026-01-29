<footer class="bg-dark text-white pt-5 pb-2 mt-auto border-top border-secondary border-opacity-25">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="text-uppercase fw-bold text-primary mb-3">
                    <i class="bi bi-bag-heart-fill me-2"></i>TechHub Shop
                </h5>
                <p class="small text-secondary">
                    Hệ thống bán lẻ thiết bị công nghệ chính hãng hàng đầu Việt Nam. Cam kết chất lượng, bảo hành uy tín, giá cả cạnh tranh.
                </p>
                <div class="mt-4">
                    <h6 class="fw-bold text-uppercase mb-2 small">Kết nối với chúng tôi</h6>
                    <div class="d-flex gap-2">
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle social-btn"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle social-btn"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle social-btn"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="btn btn-outline-light btn-sm rounded-circle social-btn"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="fw-bold text-uppercase mb-3 small text-white-50">Hỗ trợ khách hàng</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="footer-link">Trung tâm trợ giúp</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Hướng dẫn mua hàng</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Tra cứu đơn hàng</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Chính sách đổi trả</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Chính sách bảo hành</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="fw-bold text-uppercase mb-3 small text-white-50">Về TechHub</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="#" class="footer-link">Giới thiệu</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Tuyển dụng</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Điều khoản sử dụng</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Chính sách bảo mật</a></li>
                    <li class="mb-2"><a href="#" class="footer-link">Liên hệ hợp tác</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-6 mb-4">
                <h6 class="fw-bold text-uppercase mb-3 small text-white-50">Đăng ký nhận tin</h6>
                <p class="small text-secondary mb-3">Nhận thông tin về khuyến mãi và sản phẩm mới sớm nhất.</p>
                <form action="#" class="mb-4">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="Nhập email của bạn...">
                        <button class="btn btn-primary btn-sm fw-bold" type="button">Đăng ký</button>
                    </div>
                </form>

                <h6 class="fw-bold text-uppercase mb-2 small text-white-50">Thông tin liên hệ</h6>
                <ul class="list-unstyled small text-secondary">
                    <li class="mb-1"><i class="bi bi-geo-alt-fill me-2 text-primary"></i> 123 Đường ABC, Quận 1, TP.HCM</li>
                    <li class="mb-1"><i class="bi bi-envelope-fill me-2 text-primary"></i> support@techhub.com</li>
                    <li class="mb-1"><i class="bi bi-telephone-fill me-2 text-primary"></i> 1900 1234 (8:00 - 22:00)</li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary opacity-25 my-3">

        <div class="row align-items-center py-2">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                <p class="small text-secondary mb-0">
                    &copy; {{ date('Y') }} <strong>TechHub Shop</strong>. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <span class="small text-secondary me-2">Chấp nhận thanh toán:</span>
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" height="20" class="bg-white rounded px-1 mx-1">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b7/MasterCard_Logo.svg/2560px-MasterCard_Logo.svg.png" alt="MasterCard" height="20" class="bg-white rounded px-1 mx-1">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e1/Momo_Logo.png" alt="Momo" height="20" class="bg-white rounded px-1 mx-1">
            </div>
        </div>
    </div>
</footer>

<style>
    .footer-link {
        color: #adb5bd;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }
    .footer-link:hover {
        color: #0d6efd;
        transform: translateX(5px);
    }

    .social-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }
    .social-btn:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
        transform: translateY(-3px);
    }
</style>