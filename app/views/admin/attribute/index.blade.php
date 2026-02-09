@extends('layout.adminLayout')

@section('content')
    <style>
        .content-wrapper {
            background-color: #f4f7f6;
            min-height: 100vh;
        }

        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .card-header {
            border-bottom: 1px solid #edf2f7 !important;
            padding: 1.25rem !important;
        }

        .card-title {
            font-size: 1.1rem;
            color: #2d3748;
            margin-bottom: 0;
        }

        .table thead th {
            background-color: #f8fafc;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            font-size: 0.75rem;
            border-top: none;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
        }

        .attr-row:hover {
            background-color: #fcfdfe;
        }

        .attr-value-badge {
            display: inline-flex;
            align-items: center;
            background: #ffffff;
            color: #4a5568;
            border: 1px solid #e2e8f0;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .attr-value-badge:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .delete-val-btn {
            color: #a0aec0;
            margin-left: 8px;
            font-size: 1rem;
            transition: color 0.2s;
            text-decoration: none;
        }

        .delete-val-btn:hover {
            color: #e53e3e;
        }

        .quick-add-group {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            max-width: 250px;
        }

        .quick-add-input {
            border: none !important;
            box-shadow: none !important;
            font-size: 0.85rem;
        }

        .quick-add-btn {
            border-radius: 0 !important;
            padding-left: 15px;
            padding-right: 15px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.6rem 1rem;
        }

        .form-control:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        .btn-primary {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            background-color: #3182ce;
            border: none;
        }

        .btn-primary:hover {
            background-color: #2b6cb0;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 px-2">
            <h4 class="mb-0 fw-bold text-brand" style="color: #009981;">
                <i class="bi bi-grid-3x3-gap me-2"></i>QUẢN LÝ THUỘC TÍNH
            </h4>
        </div>

        @if (isset($_SESSION['success']))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4 py-3" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div><?= $_SESSION['success'] ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title fw-bold">
                            <i class="bi bi-plus-circle me-2 text-primary"></i>Thêm thuộc tính
                        </h5>
                    </div>
                    <div class="card-body py-4">
                        <form action="/attribute/storeAttribute" method="POST">
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary text-uppercase">Tên thuộc tính</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="VD: Màu sắc, Dung lượng..." required>
                                <div class="form-text mt-2" style="font-size: 0.8rem;">
                                    Thuộc tính này sẽ dùng để tạo các biến thể sản phẩm.
                                </div>
                            </div>
                            <button class="btn btn-primary w-100 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i>Lưu thuộc tính
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold">
                            <i class="bi bi-stack me-2 text-primary"></i>Danh sách thuộc tính hiện có
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4" style="width: 20%;">Tên Thuộc Tính</th>
                                        <th style="width: 45%;">Giá Trị</th>
                                        <th style="width: 25%;">Thêm Nhanh</th>
                                        <th class="text-center" style="width: 10%;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (empty($attributes))
                                        <tr>
                                            <td colspan="4" class="text-center py-5 text-muted">
                                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                                Chưa có dữ liệu nào được tạo.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($attributes as $attr)
                                            <tr class="attr-row">
                                                <td class="ps-4">
                                                    <div class="fw-bold text-dark fs-6">{{ $attr['name'] }}</div>
                                                    <small class="text-muted">ID: #{{ $attr['id'] }}</small>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach ($attr['values'] as $val)
                                                            <div class="attr-value-badge shadow-sm">
                                                                {{ $val['value'] }}
                                                                @if(strtolower($val['value']) !== 'none')
                                                                    <a href="/attribute/deleteValue/{{ $val['id'] }}"
                                                                        class="delete-val-btn"
                                                                        onclick="return confirm('Xóa giá trị [{{ $val['value'] }}]?');">
                                                                        <i class="bi bi-x-circle-fill"></i>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td>
                                                    <form action="/attribute/storeValue" method="POST"
                                                        class="input-group quick-add-group">
                                                        <input type="hidden" name="attribute_id"
                                                            value="{{ $attr['id'] }}">
                                                        <input type="text" name="value"
                                                            class="form-control quick-add-input" placeholder="VD: Đỏ, 256GB..."
                                                            required>
                                                        <button class="btn btn-success quick-add-btn">
                                                            <i class="bi bi-plus-lg"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="text-center">
                                                    <a href="/attribute/deleteAttribute/{{ $attr['id'] }}"
                                                        class="btn btn-sm btn-outline-danger border-0 rounded-circle"
                                                        style="width: 35px; height: 35px; line-height: 23px;"
                                                        onclick="return confirm('LƯU Ý: Xóa toàn bộ thuộc tính [{{ $attr['name'] }}] sẽ ảnh hưởng đến các sản phẩm liên quan. Bạn có chắc chắn?');"
                                                        title="Xóa thuộc tính">
                                                        <i class="bi bi-trash3"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection