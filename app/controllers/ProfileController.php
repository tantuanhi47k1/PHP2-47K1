<?php
class ProfileController extends Controller {

    // Hàm bắt buộc đăng nhập mới được vào
    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /auth/login");
            exit;
        }
    }

    // Trang hồ sơ (Tab Thông tin chung)
    public function index() {
        $this->requireLogin();
        $userModel = $this->model('UserModel');
        
        // Lấy thông tin mới nhất từ DB (để tránh session bị cũ)
        $user = $userModel->find($_SESSION['user_id']);

        $this->view('client/profile/index', [
            'user' => $user,
            'tab' => 'info' // Mặc định là tab thông tin
        ]);
    }

    // Xử lý cập nhật thông tin (Tên, SĐT, Địa chỉ)
    public function updateInfo() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            
            // Dữ liệu gửi lên
            $data = [
                'fullname' => trim($_POST['fullname']),
                'phone'    => trim($_POST['phone']),
                'address'  => trim($_POST['address'])
            ];

            // Gọi hàm update linh hoạt mà ta vừa sửa trong UserModel
            if ($userModel->update($_SESSION['user_id'], $data)) {
                // Cập nhật lại tên trong session để Header hiển thị đúng
                $_SESSION['user_name'] = $data['fullname'];
                $_SESSION['success'] = "Cập nhật thông tin thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại.";
            }
        }
        
        // Quay lại trang profile
        header("Location: /profile");
        exit;
    }

    // Xử lý đổi mật khẩu
    public function changePassword() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = $this->model('UserModel');
            $user = $userModel->find($_SESSION['user_id']);

            $currentPass = $_POST['current_password'];
            $newPass     = $_POST['new_password'];
            $confirmPass = $_POST['confirm_password'];

            // 1. Kiểm tra mật khẩu cũ
            if (!password_verify($currentPass, $user['password'])) {
                $_SESSION['error'] = "Mật khẩu hiện tại không đúng!";
                header("Location: /profile?tab=password");
                exit;
            }

            // 2. Kiểm tra xác nhận mật khẩu mới
            if ($newPass !== $confirmPass) {
                $_SESSION['error'] = "Mật khẩu xác nhận không khớp!";
                header("Location: /profile?tab=password");
                exit;
            }

            // 3. Cập nhật
            if ($userModel->updatePassword($_SESSION['user_id'], $newPass)) {
                $_SESSION['success'] = "Đổi mật khẩu thành công!";
            } else {
                $_SESSION['error'] = "Lỗi hệ thống, thử lại sau.";
            }
        }
        
        header("Location: /profile?tab=password");
        exit;
    }

    // Tab Lịch sử đơn hàng
    public function orders() {
        $this->requireLogin();
        
        $userModel = $this->model('UserModel');
        $orderModel = $this->model('OrderModel'); // Sử dụng OrderModel bạn đã tạo hôm trước

        $user = $userModel->find($_SESSION['user_id']);
        $orders = $orderModel->getOrdersByUserId($_SESSION['user_id']);

        $this->view('client/profile/index', [
            'user'   => $user,
            'orders' => $orders,
            'tab'    => 'orders' // Đánh dấu đang ở tab đơn hàng
        ]);
    }
}