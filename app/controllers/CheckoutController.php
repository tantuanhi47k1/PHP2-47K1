<?php

class CheckoutController extends Controller {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header("Location: /auth/login");
            exit;
        }

        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        $this->view('client/checkout/index', [
            'cart' => $cart,
            'totalPrice' => $totalPrice
        ]);
    }

    public function process() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /checkout");
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header("Location: /product");
            exit;
        }

        $errors = [];
        $fullname = trim($_POST['fullname'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $payment_method = $_POST['payment_method'] ?? 'cod';

        if (empty($fullname)) $errors[] = "Vui lòng nhập họ tên người nhận.";
        if (empty($phone)) $errors[] = "Vui lòng nhập số điện thoại.";
        if (empty($address)) $errors[] = "Vui lòng nhập địa chỉ giao hàng.";

        if (!empty($errors)) {
            $totalPrice = 0;
            foreach ($cart as $item) {
                $totalPrice += $item['price'] * $item['quantity'];
            }
            $this->view('client/checkout/index', [
                'errors' => $errors,
                'old' => $_POST,
                'cart' => $cart,
                'totalPrice' => $totalPrice
            ]);
            return;
        }

        $orderModel = $this->model('OrderModel');
        $orderDetailModel = $this->model('OrderDetailModel');

        $finalTotal = 0;
        foreach ($cart as $item) {
            $finalTotal += $item['price'] * $item['quantity'];
        }

        $orderData = [
            'user_id' => $_SESSION['user_id'] ?? null,
            'fullname' => $fullname,
            'phone' => $phone,
            'address' => $address,
            'note' => $_POST['note'] ?? '',
            'total_money' => $finalTotal,
            'payment_method' => $payment_method,
            'created_at' => date('Y-m-d H:i:s'),
            'status' => 1
        ];

        $orderId = $orderModel->create($orderData);

        if ($orderId) {
            foreach ($cart as $productId => $item) {
                $detailData = [
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity']
                ];
                $orderDetailModel->create($detailData);
            }

            unset($_SESSION['cart']);
            
            header("Location: /?msg=order_success");
            exit;
        } else {
            echo "Lỗi hệ thống, không thể tạo đơn hàng!";
        }
    }
}