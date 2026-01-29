<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Xác thực') | My Shop</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            overflow-x: hidden;
        }

        .auth-container {
            min-height: 100vh;
        }
        .auth-image-side {
            background: url('https://happyphone.vn/wp-content/uploads/2025/09/iPhone-17-Pro-va-iPhone-17-Pro-Max-chinh-thuc-ra-mat-co-gi-moi.jpg') no-repeat center center/cover;
            position: relative;
            min-height: 300px;
        }
        .auth-image-side::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(2, 5, 24, 0.6), rgba(26, 26, 26, 0.8));
            opacity: 0.9;
        }
        .auth-image-content {
            position: relative;
            z-index: 2;
            color: white;
        }
        .auth-form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background: #fff;
        }
        .auth-form-wrapper {
            width: 100%;
            max-width: 480px;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 0.5rem;
        }
        .form-control {
            padding: 0.8rem 1rem;
            border-radius: 12px;
            border: 2px solid #eee;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.15);
            border-color: var(--primary-color);
            background-color: #fff;
        }
        .btn-primary-modern {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 0.9rem;
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
        }
        .btn-primary-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
        }
        .btn-google-modern {
            border: 2px solid #eee;
            padding: 0.8rem;
            border-radius: 12px;
            font-weight: 600;
            color: #555;
            background: #fff;
            transition: all 0.3s;
        }
        .btn-google-modern:hover {
            background-color: #f8f9fa;
            border-color: #ddd;
            transform: translateY(-2px);
        }

        @media (max-width: 991.98px) {
            .auth-image-side {
                min-height: 250px;
                border-bottom-right-radius: 30px;
                border-bottom-left-radius: 30px;
            }
            .auth-form-side {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="container-fluid p-0 overflow-hidden">
        <div class="row g-0 auth-container">
            <div class="col-lg-6 auth-image-side d-flex align-items-center justify-content-center p-5 text-center">
                <div class="auth-image-content">
                    <h1 class="display-4 fw-bold mb-3">TechHub Shop</h1>
                    <p class="lead fs-5 opacity-75">Khám phá phong cách mới mỗi ngày cùng chúng tôi.</p>
                </div>
            </div>

            <div class="col-lg-6 auth-form-side">
                <div class="auth-form-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>