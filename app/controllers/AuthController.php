<?php
class AuthController extends Controller
{
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // --- LOGIC CHO CLIENT (USERS) ---
    public function login() {
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
            'name'          => trim($_POST['name']),
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
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $user = $this->model('UserModel')->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            
            header("Location: /");
            exit;
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu khách hàng không đúng!';
            header("Location: /auth/login");
        }
    }

    // --- LOGIC CHO ADMINS ---
    public function adminLogin() {
        $this->view('admin/auth/login');
    }

    public function handleAdminLogin() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $admin = $this->model('AdminModel')->findByEmail($email);

        if ($admin && password_verify($password, $admin['password'])) {
            if ($admin['role'] == 2) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['username'];
                $_SESSION['admin_role'] = $admin['role'];

                header("Location: /admin/index"); 
                exit;
            } else {
                $_SESSION['error'] = 'Tài khoản chưa được kích hoạt quyền Quản trị (Role 1).';
                header("Location: /auth/adminLogin");
                exit;
            }
        } else {
            $_SESSION['error'] = 'Thông tin đăng nhập Admin không chính xác!';
            header("Location: /auth/adminLogin");
        }
    }

    public function adminRegister() {
        $this->view('admin/auth/register');
    }

    public function storeAdmin() {
        $email = trim($_POST['email'] ?? '');
        $adminModel = $this->model('AdminModel');

        if ($adminModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email quản trị này đã tồn tại trên hệ thống!';
            header("Location: /auth/adminRegister");
            exit;
        }

        $data = [
            'username' => trim($_POST['name']),
            'email'    => $email,
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
        ];

        if ($adminModel->create($data)) {
            unset($_SESSION['error']);
            $_SESSION['success'] = 'Tạo tài khoản Admin thành công (Mặc định Role 1).';
            header("Location: /auth/adminLogin");
        } else {
            $_SESSION['error'] = 'Không thể tạo Admin vào lúc này!';
            header("Location: /auth/adminRegister");
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /");
        exit;
    }
}