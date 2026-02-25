<?php

class CartController extends Controller
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index()
    {
        $cart = $_SESSION['cart'];
        $totalPrice = 0;

        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        $discountAmount = 0;
        $coupon = $_SESSION['coupon'] ?? null;

        if ($coupon) {
            if ($totalPrice < $coupon['min_order_value']) {
                unset($_SESSION['coupon']);
                $coupon = null;
                $_SESSION['error'] = "Mã giảm giá đã bị gỡ do tổng đơn không đủ điều kiện tối thiểu!";
            } else {
                if ($coupon['discount_type'] == 'percent') {
                    $discountAmount = ($totalPrice * $coupon['discount_value']) / 100;
                    if ($coupon['max_discount_amount'] > 0 && $discountAmount > $coupon['max_discount_amount']) {
                        $discountAmount = $coupon['max_discount_amount'];
                    }
                } else {
                    $discountAmount = $coupon['discount_value'];
                }
            }
        }

        $finalPrice = $totalPrice - $discountAmount;
        if ($finalPrice < 0) $finalPrice = 0;

        $couponModel = $this->model('CouponModel');
        $availableCoupons = $couponModel->all();

        $this->view('client/cart/index', [
            'cart'           => $cart,
            'totalPrice'     => $totalPrice,
            'discountAmount' => $discountAmount,
            'finalPrice'     => $finalPrice,
            'coupon'         => $coupon,
            'availableCoupons' => $availableCoupons
        ]);
    }

    public function applyCoupon()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $code = $_POST['coupon_code'] ?? '';

            if (empty($code)) {
                $_SESSION['error'] = "Vui lòng nhập mã giảm giá!";
                header("Location: /cart");
                exit;
            }

            $couponModel = $this->model('CouponModel');
            $coupon = $couponModel->findByCode($code);

            if (!$coupon) {
                $_SESSION['error'] = "Mã giảm giá không tồn tại!";
                header("Location: /cart");
                exit;
            }

            $totalPrice = 0;
            foreach ($_SESSION['cart'] as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }

            $currentDate = date('Y-m-d H:i:s');
            
            if (!empty($coupon['start_date']) && $coupon['start_date'] > $currentDate) {
                $_SESSION['error'] = "Mã giảm giá chưa đến thời gian sử dụng!";
            } elseif (!empty($coupon['end_date']) && $coupon['end_date'] < $currentDate) {
                $_SESSION['error'] = "Mã giảm giá đã hết hạn!";
            } elseif ($coupon['usage_limit'] !== null && $coupon['usage_limit'] <= 0) {
                $_SESSION['error'] = "Mã giảm giá đã hết lượt sử dụng!";
            } elseif ($totalPrice < $coupon['min_order_value']) {
                $_SESSION['error'] = "Đơn hàng phải từ " . number_format($coupon['min_order_value'], 0, ',', '.') . "đ để áp dụng mã này!";
            } else {
                $_SESSION['coupon'] = [
                    'code'                => $coupon['code'],
                    'discount_type'       => $coupon['discount_type'],
                    'discount_value'      => $coupon['discount_value'],
                    'max_discount_amount' => $coupon['max_discount_amount'],
                    'min_order_value'     => $coupon['min_order_value']
                ];
                $_SESSION['success'] = "Áp dụng mã giảm giá thành công!";
            }
        }
        
        header("Location: /cart");
        exit;
    }

    public function removeCoupon()
    {
        if (isset($_SESSION['coupon'])) {
            unset($_SESSION['coupon']);
            $_SESSION['success'] = "Đã gỡ mã giảm giá!";
        }
        header("Location: /cart");
        exit;
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $productId = $_POST['id'] ?? null;
            $quantity = (int)($_POST['quantity'] ?? 1);

            if ($productId) {
                $productModel = $this->model('ProductModel');
                $product = $productModel->find($productId);

                if ($product) {
                    if (isset($_SESSION['cart'][$productId])) {
                        $_SESSION['cart'][$productId]['quantity'] += $quantity;
                    } else {
                        $_SESSION['cart'][$productId] = [
                            'id'       => $product['id'],
                            'name'     => $product['name'],
                            'price'    => $product['base_price'], 
                            'image'    => $product['image'],
                            'quantity' => $quantity
                        ];
                    }

                    $_SESSION['success'] = "Đã thêm <b>" . $product['name'] . "</b> vào giỏ hàng!";
                } else {
                    $_SESSION['error'] = "Sản phẩm không tồn tại!";
                }
            }
        }

        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        } else {
            header("Location: /");
        }
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quantities = $_POST['quantity'] ?? [];

            foreach ($quantities as $id => $qty) {
                $qty = (int)$qty;

                if ($qty > 0 && isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] = $qty;
                } 
                elseif ($qty <= 0) {
                    unset($_SESSION['cart'][$id]);
                }
            }
            $_SESSION['success'] = "Cập nhật giỏ hàng thành công!";
        }

        header("Location: /cart");
        exit;
    }

    public function remove($id)
    {
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $_SESSION['success'] = "Đã xóa sản phẩm khỏi giỏ hàng!";
        }
        header("Location: /cart");
        exit;
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
        unset($_SESSION['coupon']);
        $_SESSION['success'] = "Đã xóa toàn bộ giỏ hàng!";
        header("Location: /cart");
        exit;
    }
}