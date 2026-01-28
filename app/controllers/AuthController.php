<?php
class AuthController extends Controller
{
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // --- LOGIC CHO KHÁCH HÀNG (Bảng users) ---
    
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }
        $this->view('client/auth/login');
    }

    public function register() {
        $this->view('client/auth/register');
    }

    public function storeRegister() {
        $userModel = $this->model('UserModel');
        $email = trim($_POST['email'] ?? '');

        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email này đã được khách hàng khác sử dụng!';
            header("Location: /auth/register");
            exit;
        }

        $data = [
            'full_name'     => trim($_POST['name']),
            'email'         => $email,
            'password'      => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'phone'         => $_POST['phone'] ?? null,
            'address'       => $_POST['address'] ?? null,
            'avatar'        => 'image/avatar/default.png',
            'google_id'     => null,
            'auth_provider' => 'local'
        ];

        if ($userModel->create($data)) {
            unset($_SESSION['error']);
            $_SESSION['success'] = 'Đăng ký thành công! Mời bạn đăng nhập.';
            header("Location: /auth/login");
        } else {
            $_SESSION['error'] = 'Lỗi hệ thống khi đăng ký khách hàng!';
            header("Location: /auth/register");
        }
    }

    public function handleUserLogin() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = $this->model('UserModel')->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: /");
            exit;
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu không đúng!';
            header("Location: /auth/login");
        }
    }

    // --- LOGIC CHO BAN QUẢN TRỊ (Bảng admins) ---

    public function adminLogin() {
        if (isset($_SESSION['admin_id']) && $_SESSION['admin_role'] == 2) {
            header("Location: /admin/index");
            exit;
        }
        $this->view('admin/auth/login');
    }

    public function handleAdminLogin() {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $adminModel = $this->model('AdminModel');
        $admin = $adminModel->findByEmail($email);

        if ($admin && password_verify($password, $admin['password'])) {
            if ($admin['role'] == 2) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['username'];
                $_SESSION['admin_role'] = $admin['role'];
                $_SESSION['admin_avatar'] = $admin['avatar'];

                header("Location: /admin/index"); 
                exit;
            } else {
                $_SESSION['error'] = 'Tài khoản (Role 1) chưa được cấp quyền quản trị!';
                header("Location: /auth/adminLogin");
                exit;
            }
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu Admin không chính xác!';
            header("Location: /auth/adminLogin");
        }
    }

    public function adminRegister() {
        $this->view('admin/auth/register');
    }

    public function storeAdmin() {
        $email = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? $_POST['name']);
        $adminModel = $this->model('AdminModel');

        if ($adminModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email quản trị này đã tồn tại!';
            header("Location: /auth/adminRegister");
            exit;
        }

        $data = [
            'username' => $username,
            'email'    => $email,
            'password' => $_POST['password'],
            'role'     => 1,
            'avatar'   => 'image/avatar/admin-default.png'
        ];

        if ($adminModel->create($data)) {
            unset($_SESSION['error']);
            $_SESSION['success'] = 'Đăng ký Admin thành công! Hãy đợi cấp quyền Role 2.';
            header("Location: /auth/adminLogin");
        } else {
            $_SESSION['error'] = 'Không thể đăng ký Admin lúc này!';
            header("Location: /auth/adminRegister");
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: /auth/adminLogin");
        exit;
    }
}