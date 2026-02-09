<?php
class ProfileController extends Controller {

    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /auth/login");
            exit;
        }
    }

    public function index() {
        $this->requireLogin();
        $userId = $_SESSION['user_id'];
        
        $userModel = $this->model('UserModel');
        $user = $userModel->find($userId);

        $tab = $_GET['tab'] ?? 'info';
        $orders = [];

        if ($tab == 'orders') {
            $orderModel = $this->model('OrderModel');
            if (method_exists($orderModel, 'getOrdersByUser')) {
                $orders = $orderModel->getOrdersByUser($userId);
            }
        }

        $this->view('client/profile/index', [
            'user'   => $user,
            'tab'    => $tab,
            'orders' => $orders
        ]);
    }

    public function updateInfo() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            $data = [
                'full_name' => trim($_POST['fullname']),
                'phone'     => trim($_POST['phone']),
                'address'   => trim($_POST['address'])
            ];
            if ($userModel->update($_SESSION['user_id'], $data)) {
                $_SESSION['user_name'] = $data['full_name']; 
                $_SESSION['success'] = "Cập nhật thông tin thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại.";
            }
        }
        header("Location: /profile");
        exit;
    }

    public function changePassword() {
        $this->requireLogin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            $user = $userModel->find($_SESSION['user_id']);
            
            $currentPass = $_POST['current_password'];
            $newPass     = $_POST['new_password'];
            $confirmPass = $_POST['confirm_password'];

            if (!password_verify($currentPass, $user['password'])) {
                $_SESSION['error'] = "Mật khẩu hiện tại không đúng!";
                header("Location: /profile?tab=password");
                exit;
            }
            if ($newPass !== $confirmPass) {
                $_SESSION['error'] = "Mật khẩu xác nhận không khớp!";
                header("Location: /profile?tab=password");
                exit;
            }
            
            $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
            if ($userModel->update($_SESSION['user_id'], ['password' => $hashedPass])) {
                $_SESSION['success'] = "Đổi mật khẩu thành công!";
            } else {
                $_SESSION['error'] = "Lỗi hệ thống.";
            }
        }
        header("Location: /profile?tab=password");
        exit;
    }

    public function order($id) {
        $this->requireLogin();
        $userId = $_SESSION['user_id'];

        $orderModel = $this->model('OrderModel');
        $userModel = $this->model('UserModel');

        $order = $orderModel->getOrderById($id, $userId);

        if (!$order) {
            $_SESSION['error'] = "Đơn hàng không tồn tại hoặc bạn không có quyền xem!";
            header("Location: /profile?tab=orders");
            exit;
        }

        $orderDetails = $orderModel->getOrderDetails($id);

        $user = $userModel->find($userId);

        $this->view('client/profile/order_detail', [
            'user'    => $user,
            'order'   => $order,
            'details' => $orderDetails
        ]);
    }
}