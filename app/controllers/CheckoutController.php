<?php

class CheckoutController extends Controller {
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để tiến hành thanh toán!";
            header("Location: /auth/login");
            exit;
        }
    }

    public function index() {
        $this->requireLogin();

        $currentUser = null;

        if (isset($_SESSION['user_id'])) {
            $userModel = $this->model('UserModel');
            $currentUser = $userModel->find($_SESSION['user_id']); 
        }

        $this->view('client/checkout/index', [
            'user' => $currentUser
        ]);
    }

    public function process() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /checkout");
            exit;
        }

        $cartJson = $_POST['cart_data'] ?? '[]';
        $cart = json_decode($cartJson, true);

        if (empty($cart) || !is_array($cart)) {
            header("Location: /product");
            exit;
        }

        $errors = [];
        $fullname = trim($_POST['fullname'] ?? '');
        $phone    = trim($_POST['phone'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $address  = trim($_POST['address'] ?? ''); 
        $note     = trim($_POST['note'] ?? '');
        $payment_method = $_POST['payment_method'] ?? 'cod';

        if (empty($fullname)) $errors[] = "Vui lòng nhập họ tên người nhận.";
        if (empty($phone)) $errors[] = "Vui lòng nhập số điện thoại.";
        if (empty($address)) $errors[] = "Vui lòng nhập địa chỉ giao hàng.";

        if (!empty($errors)) {
            $currentUser = null;
            if (isset($_SESSION['user_id'])) {
                $userModel = $this->model('UserModel');
                $currentUser = $userModel->find($_SESSION['user_id']); 
            }

            $this->view('client/checkout/index', [
                'errors' => $errors,
                'old'    => $_POST,
                'user'   => $currentUser
            ]);
            return;
        }

        $finalTotal = 0;
        foreach ($cart as $item) {
            $finalTotal += $item['price'] * $item['quantity'];
        }

        $orderModel = $this->model('OrderModel');
        $orderDetailModel = $this->model('OrderDetailModel');

        $orderData = [
            'user_id'        => $_SESSION['user_id'],
            'fullname'       => $fullname,
            'phone'          => $phone,
            'email'          => $email,
            'address'        => $address,
            'note'           => $note,
            'total_money'    => $finalTotal,
            'payment_method' => $payment_method,
            'created_at'     => date('Y-m-d H:i:s'),
            'status'         => 1
        ];

        $orderId = $orderModel->create($orderData); 

        if ($orderId) {
            foreach ($cart as $item) {
                $detailData = [
                    'order_id'     => $orderId,
                    'product_id'   => $item['id'],
                    'product_name' => $item['name'],
                    'price'        => $item['price'],
                    'quantity'     => $item['quantity'],
                    'total_price'  => $item['price'] * $item['quantity']
                ];
                $orderDetailModel->create($detailData);
            }

            header("Location: /checkout/success");
            exit;

        } else {
            $this->view('client/checkout/index', [
                'errors' => ['Lỗi hệ thống: Không thể tạo đơn hàng.'],
                'old'    => $_POST
            ]);
        }
    }

    public function success() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->view('client/checkout/success');
    }
}