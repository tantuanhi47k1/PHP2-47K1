@extends('layout.adminLayout')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-rulers me-2"></i>Quản lý Kích thước (Size)</h5>
            <a href="/size/create" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Thêm mới
            </a>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tên Size</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-end">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($sizes))
                        @foreach($sizes as $s)
                        <tr>
                            <td>#{{ $s['id'] }}</td>
                            <td class="fw-bold">{{ $s['name'] }}</td>
                            <td class="text-center">
                                @if($s['status'] == 1)
                                    <span class="badge bg-success bg-opacity-10 text-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary">Ẩn</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="/size/edit/{{ $s['id'] }}" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="/size/delete/{{ $s['id'] }}" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr><td colspan="5" class="text-center">Chưa có dữ liệu</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection