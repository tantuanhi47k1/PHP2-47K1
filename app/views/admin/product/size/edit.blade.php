@extends('layout.adminLayout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">Cập Nhật Size</h5>
                </div>
                <div class="card-body p-4">
                    <form action="/size/update/{{ $size['id'] }}" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Tên Size <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ $size['name'] }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ $size['status'] == 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $size['status'] == 0 ? 'selected' : '' }}>Tạm ẩn</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="/size" class="btn btn-secondary">Quay lại</a>
                            <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection