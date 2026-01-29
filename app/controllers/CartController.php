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

        $this->view('client/cart/index', [
            'cart' => $cart,
            'totalPrice' => $totalPrice
        ]);
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
        $_SESSION['success'] = "Đã xóa toàn bộ giỏ hàng!";
        header("Location: /cart");
        exit;
    }
}