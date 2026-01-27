@extends('layout.adminLayout')

@section('content')
    <style>
        :root {
            --primary-color: #009981;
            --primary-hover: #007a67;
        }

        body {
            background-color: #f4f6f9;
        }

        .text-brand { color: var(--primary-color) !important; }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }

        .table thead th {
            background-color: #f8f9fa;
            color: #6c757d;
            font-size: 0.85rem;
            border-bottom: 2px solid #e9ecef;
        }

        .table-hover tbody tr:hover { background-color: #f1fcf9; }
        
        .badge-parent {
            background-color: rgba(0, 153, 129, 0.1);
            color: #009981;
            border: 1px solid rgba(0, 153, 129, 0.2);
        }
    </style>

    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body border-bottom bg-light py-3">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <h4 class="fw-bold text-brand mb-0"><i class="bi bi-tags me-2"></i>Quản lý danh mục</h4>
                    </div>
                    <div class="col-md-8 text-md-end">
                        <a href="/category/create" class="btn btn-primary px-4 shadow-sm">
                            <i class="bi bi-plus-lg me-1"></i> Tạo danh mục
                        </a>
                    </div>
                </div>
            </div>

            @if (isset($mess))
                <div class="alert alert-success d-flex align-items-center m-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <div><?= $mess ?></div>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">ID</th>
                            <th class="text-center" style="width: 800px">Tên danh mục</th>
                            <th>Slug (URL)</th>
                            <th class="text-center" style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($categories))
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted fst-italic">Chưa có dữ liệu danh mục.</td>
                            </tr>
                        @else
                            @foreach ($categories as $cate)
                                <tr>
                                    <td class="text-center text-muted fw-bold">#<?= $cate['id'] ?></td>
                                    <td class="text-center">
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($cate['name']) ?></div>
                                    </td>
                                    <td>
                                        <code class="small text-muted"><?= htmlspecialchars($cate['slug']) ?></code>
                                    </td>
                                    <td class="text-center">
                                        <a href="/category/edit/<?= $cate['id'] ?>"
                                           class="btn btn-sm btn-light border text-primary me-1" title="Sửa">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="/category/delete/<?= $cate['id'] ?>"
                                           class="btn btn-sm btn-light border text-danger"
                                           onclick="return confirm('Xóa danh mục này có thể ảnh hưởng đến các sản phẩm liên quan. Bạn chắc chắn chứ?');"
                                           title="Xóa">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            
            <div class="card-footer bg-white py-3">
                <small class="text-muted">Tổng số: <?= count($categories ?? []) ?> danh mục</small>
            </div>
        </div>
    </div>
@endsection