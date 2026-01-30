@extends('layout.adminLayout')

@section('content')
<div class="container-fluid py-4 px-4">
    @if (isset($_SESSION['success']))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    @endif

    @if (isset($_SESSION['error']))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Quản lý biến thể</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/product/manage">Sản phẩm</a></li>
                    <li class="breadcrumb-item active text-primary fw-bold">{{ $product['name'] }}</li>
                </ol>
            </nav>
        </div>
        <a href="/product/manage" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Quay lại
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4">
                <h6 class="fw-bold mb-3 border-bottom pb-2"><i class="bi bi-plus-circle me-2"></i>Thêm phiên bản mới</h6>
                <form action="/variant/store" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-primary">TÊN PHIÊN BẢN (HIỂN THỊ)</label>
                        <input type="text" name="variant_name" class="form-control shadow-sm border-primary border-opacity-25" 
                               placeholder="VD: Màu Đen, Bản 128GB..." required>
                        <div class="form-text small">Tên này sẽ hiện thị trên trang chi tiết để khách hàng chọn.</div>
                    </div>

                    @foreach($attributes as $attr)
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">CHỌN {{ strtoupper($attr['name']) }}</label>
                        <select name="attribute_values[]" class="form-select shadow-sm" required>
                            <option value="">-- Chọn {{ $attr['name'] }} --</option>
                            @foreach($attr['values'] as $val)
                                <option value="{{ $val['id'] }}">{{ $val['value'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endforeach

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">GIÁ BÁN (Đ)</label>
                        <input type="number" name="price" class="form-control shadow-sm" placeholder="Nhập giá..." required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">SỐ LƯỢNG KHO</label>
                        <input type="number" name="stock" class="form-control shadow-sm" placeholder="Nhập số lượng..." required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">ẢNH BIẾN THỂ (NẾU CÓ)</label>
                        <input type="file" name="image" class="form-control shadow-sm">
                        <div class="form-text small">Để trống nếu dùng chung ảnh sản phẩm.</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm py-2">
                        <i class="bi bi-save me-2"></i>LƯU BIẾN THỂ
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm overflow-hidden">
                <form action="/variant/updateAll" method="POST">
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0 table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-3" width="80">Ảnh</th>
                                    <th>Phiên bản</th>
                                    <th width="180">Giá bán (đ)</th>
                                    <th width="120">Tồn kho</th>
                                    <th class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(empty($variants))
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 opacity-25"></i>
                                        Sản phẩm này chưa có biến thể nào.
                                    </td>
                                </tr>
                                @else
                                    @foreach($variants as $v)
                                    <tr>
                                        <td class="ps-3">
                                            <img src="/{{ $v['image'] ?? $product['image'] }}" 
                                                 class="rounded border shadow-sm object-fit-cover" 
                                                 style="width: 50px; height: 50px;"
                                                 onerror="this.src='https://placehold.co/50x50?text=No+Img'">
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">
                                                {{ $v['variant_name'] ?? $v['sku_info'] }}
                                            </div>
                                            <code class="small text-muted" style="font-size: 0.7rem;">{{ $v['sku'] }}</code>
                                        </td>
                                        <td>
                                            <input type="number" name="prices[{{ $v['id'] }}]" 
                                                   value="{{ (int)$v['price'] }}" 
                                                   class="form-control form-control-sm fw-bold text-primary border-primary border-opacity-25 shadow-sm">
                                        </td>
                                        <td>
                                            <input type="number" name="stocks[{{ $v['id'] }}]" 
                                                   value="{{ $v['stock_quantity'] }}" 
                                                   class="form-control form-control-sm shadow-sm border-opacity-25">
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="/variant/edit/{{ $v['id'] }}" class="btn btn-sm btn-outline-primary" title="Sửa chi tiết">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/variant/delete/{{ $v['id'] }}/{{ $product['id'] }}" 
                                                   class="btn btn-sm btn-outline-danger" 
                                                   onclick="return confirm('Bạn chắc chắn muốn xóa phiên bản này?');" title="Xóa">
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
                    @if(!empty($variants))
                    <div class="card-footer bg-white py-3">
                        <button type="submit" class="btn btn-success btn-sm fw-bold px-4 shadow-sm">
                            <i class="bi bi-check-all me-1"></i> CẬP NHẬT NHANH GIÁ & KHO
                        </button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .object-fit-cover { object-fit: cover; }
    .breadcrumb-item + .breadcrumb-item::before { content: ">"; }
    .form-control:focus, .form-select:focus { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1); }
</style>
@endsection