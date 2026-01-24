@extends('layout.adminLayout')

@section('content')

    <style>
        .text-brand { color: #009981 !important; }
        .btn-brand { background-color: #009981; color: white; }
        .btn-brand:hover { background-color: #007a67; color: white; }
        .table-v-middle td, .table-v-middle th { vertical-align: middle; }
    </style>

    <div class="container-fluid px-4 py-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold text-brand">
                    <i class="bi bi-palette me-2"></i>Quản lý Màu sắc
                </h4>
                <a href="/color/create" class="btn btn-brand btn-sm shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Thêm màu mới
                </a>
            </div>

            @if(isset($mess))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ $mess }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-v-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4" style="width: 100px;">ID</th>
                                <th>Tên màu sắc</th>
                                <th>Ngày tạo</th>
                                <th class="text-center pe-4" style="width: 150px;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(empty($colors) || count($colors) == 0)
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Chưa có dữ liệu màu sắc nào.
                                </td>
                            </tr>
                            @else
                                @foreach($colors as $color)
                                <tr>
                                    <td class="ps-4 text-muted">#{{ $color['id'] }}</td>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $color['name'] }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ date('d/m/Y H:i', strtotime($color['created_at'])) }}
                                        </small>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="btn-group">
                                            <a href="/color/edit/{{ $color['id'] }}" 
                                               class="btn btn-sm btn-outline-primary" title="Sửa">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="/color/delete/{{ $color['id'] }}" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa màu [{{ $color['name'] }}] này?');" 
                                               title="Xóa">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
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

@endsection