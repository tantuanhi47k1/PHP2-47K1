<?php

class CartController extends Controller {
    protected $productModel;
    protected $couponModel;

    public function __construct() {
        // Khởi tạo model bằng hàm model() của class cha
        $this->productModel = $this->model('ProductModel');
        $this->couponModel = $this->model('CouponModel');
        
        // Đảm bảo session đã được start
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Hiển thị giỏ hàng
    public function index() {
        $cart = $_SESSION['cart'];
        $total = $this->calculateTotal($cart);
        
        // Lấy giảm giá từ session nếu đã áp dụng mã
        $discount = $_SESSION['coupon']['discount'] ?? 0;
        $finalTotal = $total - $discount;

        // Sử dụng hàm view() mới (hỗ trợ dấu chấm client.cart.index)
        $this->view('client.cart.index', [
            'cart' => $cart,
            'total' => $total,
            'discount' => $discount,
            'finalTotal' => max(0, $finalTotal)
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function add($id) {
        $product = $this->productModel->find($id);
        if (!$product) {
            return $this->redirect('/');
        }

        $qty = (isset($_POST['quantity']) && (int)$_POST['quantity'] > 0) ? (int)$_POST['quantity'] : 1;
        $size = $_POST['size'] ?? 'M'; 
        $color = $_POST['color'] ?? 'Default';

        // Key để phân biệt sản phẩm cùng ID nhưng khác size/màu
        $cartKey = $id . '_' . $size . '_' . $color;

        if (isset($_SESSION['cart'][$cartKey])) {
            $_SESSION['cart'][$cartKey]['quantity'] += $qty;
        } else {
            $_SESSION['cart'][$cartKey] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'size' => $size,
                'color' => $color,
                'quantity' => $qty
            ];
        }
        
        // Sử dụng hàm redirect() của Controller cha
        $this->redirect('/cart');
    }

    // Xóa sản phẩm khỏi giỏ
    public function remove($key) {
        if (isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }
        
        // Nếu giỏ trống thì xóa luôn coupon
        if (empty($_SESSION['cart'])) {
            unset($_SESSION['coupon']);
        }
        
        $this->redirect('/cart');
    }

    // Áp dụng mã giảm giá
    public function applyCoupon() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/cart');
        }

        $code = $_POST['coupon_code'] ?? '';
        $coupon = $this->couponModel->findByCode($code);

        if ($coupon) {
            $cartTotal = $this->calculateTotal($_SESSION['cart']);
            $discountAmount = 0;

            if ($coupon['type'] == 'percent') {
                $discountAmount = ($cartTotal * $coupon['value']) / 100;
            } else {
                $discountAmount = $coupon['value'];
            }

            $_SESSION['coupon'] = [
                'code' => $coupon['code'],
                'discount' => $discountAmount
            ];
        } else {
            // Bạn có thể thiết lập flash message lỗi ở đây nếu muốn
        }
        
        $this->redirect('/cart');
    }

    // Hàm tính tổng tiền giỏ hàng
    private function calculateTotal($cart) {
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}