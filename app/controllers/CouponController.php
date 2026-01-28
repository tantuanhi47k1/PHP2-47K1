<?php
class CouponController extends Controller
{
    public function index()
    {
        $couponModel = $this->model('CouponModel');
        $coupons = $couponModel->all();
        $this->view('admin/coupon/index', ['coupons' => $coupons]);
    }

    public function create()
    {
        $this->view('admin/coupon/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /coupon/create");
            exit;
        }

        $couponModel = $this->model('CouponModel');

        $code = strtoupper(trim($_POST['code'] ?? ''));
        $discount_type = $_POST['discount_type'] ?? 'fixed';
        $discount_value = $_POST['discount_value'] ?? 0;
        $min_order_value = $_POST['min_order_value'] ?? 0;
        $max_discount_amount = $_POST['max_discount_amount'] ?? null;
        $usage_limit = $_POST['usage_limit'] ?? '';
        $start_date = $_POST['start_date'] ?? date('Y-m-d H:i:s');
        $end_date = $_POST['end_date'] ?? null;

        $errors = [];

        if (empty($code)) {
            $errors['code'] = 'Mã giảm giá không được để trống.';
        } elseif ($couponModel->findByCode($code)) {
            $errors['code'] = 'Mã giảm giá này đã tồn tại.';
        }

        if (!in_array($discount_type, ['fixed', 'percentage'])) {
            $errors['discount_type'] = 'Loại giảm giá không hợp lệ.';
        }

        if ($discount_value <= 0) {
            $errors['discount_value'] = 'Giá trị giảm phải lớn hơn 0.';
        } elseif ($discount_type == 'percentage' && $discount_value > 100) {
            $errors['discount_value'] = 'Giảm theo phần trăm không được vượt quá 100%.';
        }

        if ($end_date && strtotime($end_date) <= strtotime($start_date)) {
            $errors['end_date'] = 'Ngày kết thúc phải lớn hơn ngày bắt đầu.';
        }

        if (!empty($errors)) {
            $this->view('admin/coupon/create', [
                'errors' => $errors,
                'old' => $_POST
            ]);
            return;
        }

        $data = [
            'code'                => $code,
            'discount_type'       => $discount_type,
            'discount_value'      => (float)$discount_value,
            'min_order_value'     => (float)$min_order_value,
            'max_discount_amount' => $max_discount_amount ? (float)$max_discount_amount : null,
            'start_date'          => $start_date,
            'end_date'            => $end_date ?: null,
            'usage_limit'         => $usage_limit !== '' ? (int)$usage_limit : null
        ];

        $couponModel->create($data);
        header("Location: /coupon");
        exit;
    }

    public function edit($id)
    {
        $couponModel = $this->model('CouponModel');
        $coupon = $couponModel->find($id);

        if (!$coupon) {
            header("Location: /coupon");
            exit;
        }

        $this->view('admin/coupon/edit', ['coupon' => $coupon]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /coupon/edit/$id");
            exit;
        }

        $couponModel = $this->model('CouponModel');
        $currentCoupon = $couponModel->find($id);
        
        if (!$currentCoupon) {
            header("Location: /coupon");
            exit;
        }

        $code = strtoupper(trim($_POST['code'] ?? ''));
        $discount_type = $_POST['discount_type'] ?? 'fixed';
        $discount_value = $_POST['discount_value'] ?? 0;
        $min_order_value = $_POST['min_order_value'] ?? 0;
        $max_discount_amount = $_POST['max_discount_amount'] ?? null;
        $usage_limit = $_POST['usage_limit'] ?? '';
        $start_date = $_POST['start_date'] ?? $currentCoupon['start_date'];
        $end_date = $_POST['end_date'] ?? null;

        $errors = [];

        if (empty($code)) {
            $errors['code'] = 'Mã không được để trống.';
        } else {
            $existing = $couponModel->findByCode($code);
            if ($existing && $existing['id'] != $id) {
                $errors['code'] = 'Mã giảm giá này đã tồn tại.';
            }
        }

        if (!empty($errors)) {
            $this->view('admin/coupon/edit', [
                'coupon' => array_merge($currentCoupon, $_POST, ['id' => $id]),
                'errors' => $errors
            ]);
            return;
        }

        $data = [
            'code'                => $code,
            'discount_type'       => $discount_type,
            'discount_value'      => (float)$discount_value,
            'min_order_value'     => (float)$min_order_value,
            'max_discount_amount' => $max_discount_amount ? (float)$max_discount_amount : null,
            'start_date'          => $start_date,
            'end_date'            => $end_date ?: null,
            'usage_limit'         => $usage_limit !== '' ? (int)$usage_limit : null
        ];

        $couponModel->update($id, $data);
        header("Location: /coupon");
        exit;
    }

    public function delete($id)
    {
        $this->model('CouponModel')->delete($id);
        header("Location: /coupon");
        exit;
    }
}