@extends('layout.adminLayout')

@section('content')
    <style>
        :root {
            --primary-color: #009981;
        }

        .text-brand {
            color: var(--primary-color) !important;
        }

        .btn-brand {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-brand:hover {
            background-color: #007a67;
            color: white;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.5rem;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-brand m-0">Cập nhật Mã giảm giá</h4>
                    <a href="/coupon" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>

                <form action="/coupon/update/<?= $coupon['id'] ?>" method="POST">
                    <div class="card p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Mã Coupon <span class="text-danger">*</span></label>
                                <input type="text" name="code" 
                                       class="form-control <?= isset($errors['code']) ? 'is-invalid' : '' ?>" 
                                       value="<?= htmlspecialchars($coupon['code']) ?>">
                                <?php if(isset($errors['code'])): ?>
                                    <div class="invalid-feedback"><?= $errors['code'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Trạng thái</label>
                                <select name="status" class="form-select">
                                    <option value="1" <?= $coupon['status'] == 1 ? 'selected' : '' ?>>Hoạt động</option>
                                    <option value="0" <?= $coupon['status'] == 0 ? 'selected' : '' ?>>Tạm khóa</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Loại giảm <span class="text-danger">*</span></label>
                                <select name="discount_type" class="form-select <?= isset($errors['discount_type']) ? 'is-invalid' : '' ?>">
                                    <option value="fixed" <?= $coupon['discount_type'] == 'fixed' ? 'selected' : '' ?>>Tiền mặt (VNĐ)</option>
                                    <option value="percentage" <?= $coupon['discount_type'] == 'percentage' ? 'selected' : '' ?>>Phần trăm (%)</option>
                                </select>
                                <?php if(isset($errors['discount_type'])): ?>
                                    <div class="invalid-feedback"><?= $errors['discount_type'] ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá trị giảm <span class="text-danger">*</span></label>
                                <input type="number" name="discount_value" 
                                       class="form-control <?= isset($errors['discount_value']) ? 'is-invalid' : '' ?>"
                                       value="<?= (float)$coupon['discount_value'] ?>" min="0" step="0.01">
                                <?php if(isset($errors['discount_value'])): ?>
                                    <div class="invalid-feedback"><?= $errors['discount_value'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Đơn tối thiểu</label>
                                <input type="number" name="min_order_value" 
                                       class="form-control"
                                       value="<?= (float)$coupon['min_order_value'] ?>" min="0" step="0.01">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giảm tối đa (VNĐ)</label>
                                <input type="number" name="max_discount_amount" 
                                       class="form-control"
                                       value="<?= $coupon['max_discount_amount'] ? (float)$coupon['max_discount_amount'] : '' ?>" 
                                       placeholder="Không giới hạn">
                                <small class="text-muted">Quan trọng khi giảm theo %.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Tổng lượt dùng tối đa</label>
                                <input type="number" name="usage_limit" 
                                       class="form-control"
                                       value="<?= $coupon['usage_limit'] ?>" placeholder="Để trống = Không giới hạn">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ngày bắt đầu</label>
                                <input type="datetime-local" name="start_date" 
                                       class="form-control"
                                       value="<?= $coupon['start_date'] ? date('Y-m-d\TH:i', strtotime($coupon['start_date'])) : '' ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ngày kết thúc</label>
                                <input type="datetime-local" name="end_date" 
                                       class="form-control <?= isset($errors['end_date']) ? 'is-invalid' : '' ?>"
                                       value="<?= $coupon['end_date'] ? date('Y-m-d\TH:i', strtotime($coupon['end_date'])) : '' ?>">
                                <?php if(isset($errors['end_date'])): ?>
                                    <div class="invalid-feedback"><?= $errors['end_date'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-brand w-100 fw-bold py-2 mt-2">
                            <i class="bi bi-save me-1"></i> Cập nhật thay đổi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection