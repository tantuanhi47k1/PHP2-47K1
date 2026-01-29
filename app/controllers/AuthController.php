<?php

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

require_once dirname(__DIR__) . '/core/MailService.php';

class AuthController extends Controller
{
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // login và register cho user
    
    public function login() {
        if (isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }
        $this->view('client/auth/login');
    }

    public function register() {
        if (isset($_SESSION['user_id'])) {
            header("Location: /");
            exit;
        }
        $this->view('client/auth/register');
    }

    public function storeRegister() {
        $userModel = $this->model('UserModel');
        $email = trim($_POST['email'] ?? '');

        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email này đã được sử dụng!';
            header("Location: /auth/register");
            exit;
        }

        $password = $_POST['password'];
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp!';
            header("Location: /auth/register");
            exit;
        }

        $data = [
            'full_name'     => trim($_POST['full_name'] ?? ''),
            'email'         => $email,
            'password'      => $password,
            'phone'         => $_POST['phone'] ?? null,
            'address'       => $_POST['address'] ?? null,
            'avatar'        => 'image/avatar/default.png',
            'google_id'     => null,
            'auth_provider' => 'local',
            'status'        => 1
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
        
        $userModel = $this->model('UserModel');
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            if (isset($user['status']) && $user['status'] == 0) {
                $_SESSION['error'] = 'Tài khoản của bạn đã bị khóa!';
                header("Location: /auth/login");
                exit;
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: /");
            exit;
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu không đúng!';
            header("Location: /auth/login");
        }
    }

    // quên mk
    public function forgotPassword() {
        $this->view('client/auth/forgot_password');
    }

    // xử lý send link đặt lại mk
    public function sendResetLink() {
        $email = trim($_POST['email'] ?? '');
        $userModel = $this->model('UserModel');
        $user = $userModel->findByEmail($email);

        if (!$user) {
            $_SESSION['error'] = 'Email này không tồn tại trong hệ thống!';
            header("Location: /auth/forgotPassword");
            exit;
        }

        // tạo token ngẫu nhiên
        $token = bin2hex(random_bytes(32));
        
        $userModel->updateResetToken($email, $token);

        $link = "http://localhost:8000/auth/resetPassword/$token";
        
        $subject = "Yêu cầu đặt lại mật khẩu - My Shop";
        $body = "
            <h3>Xin chào " . htmlspecialchars($user['full_name']) . ",</h3>
            <p>Bạn vừa yêu cầu đặt lại mật khẩu tại My Shop.</p>
            <p>Vui lòng bấm vào đường dẫn bên dưới để tạo mật khẩu mới (Link có hiệu lực trong 15 phút):</p>
            <p><a href='$link' style='background:#0d6efd; color:white; padding:10px 20px; text-decoration:none; border-radius:5px;'>Đặt lại mật khẩu</a></p>
            <p>Hoặc truy cập link: $link</p>
            <p>Nếu bạn không yêu cầu, vui lòng bỏ qua email này.</p>
        ";

        if (class_exists('MailService') && MailService::send($email, $subject, $body)) {
            $_SESSION['success'] = 'Vui lòng kiểm tra email để lấy link khôi phục mật khẩu!';
            header("Location: /auth/login");
        } else {
            $_SESSION['error'] = 'Gửi email thất bại. Vui lòng kiểm tra file .env hoặc MailService!';
            header("Location: /auth/forgotPassword");
        }
    }

    // form đặt lại mk mới
    public function resetPassword($token = null) {
        if (!$token) {
            $_SESSION['error'] = 'Token không hợp lệ!';
            header("Location: /auth/login");
            exit;
        }

        $userModel = $this->model('UserModel');
        $user = $userModel->findByResetToken($token);

        if (!$user) {
            $_SESSION['error'] = 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn!';
            header("Location: /auth/login");
            exit;
        }

        $this->view('client/auth/reset_password', ['token' => $token]);
    }

    // xử lý đổi mk mới
    public function handleResetPassword() {
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'];
        $confirm = $_POST['confirm_password'];

        if ($password !== $confirm) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp!';
            header("Location: /auth/resetPassword/$token");
            exit;
        }

        $userModel = $this->model('UserModel');
        $user = $userModel->findByResetToken($token);

        if ($user) {
            $userModel->updatePasswordAndClearToken($user['id'], $password);
            
            $_SESSION['success'] = 'Đổi mật khẩu thành công! Hãy đăng nhập bằng mật khẩu mới.';
            header("Location: /auth/login");
        } else {
            $_SESSION['error'] = 'Yêu cầu không hợp lệ hoặc đã hết hạn!';
            header("Location: /auth/login");
        }
    }

    // login với gg

    private function getGoogleClient() {
        if (!class_exists('Google_Client')) {
            die("LỖI: Chưa nạp thư viện Google Client. Hãy kiểm tra file bootstrap.php hoặc chạy 'composer install'.");
        }

        $client = new Google_Client();

        $clientId = $_ENV['SETCLIENT_ID'] ?? getenv('SETCLIENT_ID');
        $clientSecret = $_ENV['SETCLIENT_SECRET'] ?? getenv('SETCLIENT_SECRET');
        $redirectUri = $_ENV['GOOGLE_REDIRECT_URI'] ?? getenv('GOOGLE_REDIRECT_URI');

        if (empty($clientId) || empty($clientSecret)) {
            echo "<div style='color:red; font-weight:bold; padding:20px; border:1px solid red;'>";
            echo "LỖI: Không đọc được cấu hình Google từ file .env!<br>";
            echo "Hãy chắc chắn bạn đã tạo file <b>.env</b> và restart server.";
            echo "</div>";
            die();
        }

        $client->setClientId($clientId); 
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        
        $client->addScope("email");
        $client->addScope("profile");

        return $client;
    }

    public function googleLogin() {
        $client = $this->getGoogleClient();
        $loginUrl = $client->createAuthUrl();
        header("Location: " . $loginUrl);
        exit;
    }

    public function googleCallback() {
        if (isset($_GET['code'])) {
            try {
                $client = $this->getGoogleClient();
                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                
                if (isset($token['error'])) {
                    throw new Exception("Lỗi Token Google: " . $token['error']);
                }

                $client->setAccessToken($token);
                $google_oauth = new Google_Service_Oauth2($client);
                $google_info = $google_oauth->userinfo->get();

                $email = $google_info->email;
                $name = $google_info->name;
                $google_id = $google_info->id;
                $avatar = $google_info->picture;

                $userModel = $this->model('UserModel');
                
                $user = $userModel->findByGoogleId($google_id);
                if ($user) {
                    if ($user['status'] == 0) { $_SESSION['error'] = 'Tài khoản khóa!'; header("Location: /auth/login"); exit; }
                    $this->setClientSession($user);
                    header("Location: /"); exit;
                } 
                
                $existingUser = $userModel->findByEmail($email);
                if ($existingUser) {
                    if ($existingUser['status'] == 0) { $_SESSION['error'] = 'Tài khoản khóa!'; header("Location: /auth/login"); exit; }
                    $userModel->updateGoogleId($existingUser['id'], $google_id);
                    $this->setClientSession($existingUser);
                    header("Location: /"); exit;
                }

                $newUser = [
                    'full_name' => $name, 'email' => $email, 'password' => null, 
                    'phone' => null, 'address' => null, 'avatar' => $avatar, 
                    'status' => 1, 'google_id' => $google_id, 'auth_provider' => 'google'
                ];

                $newUserId = $userModel->create($newUser);
                if ($newUserId) {
                    $user = $userModel->find($newUserId);
                    $this->setClientSession($user);
                    header("Location: /"); exit;
                } else {
                    $_SESSION['error'] = "Lỗi tạo tài khoản!"; header("Location: /auth/login"); exit;
                }

            } catch (Exception $e) {
                $_SESSION['error'] = "Đăng nhập thất bại: " . $e->getMessage();
                header("Location: /auth/login"); exit;
            }
        } else {
            header("Location: /auth/login"); exit;
        }
    }

    private function setClientSession($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['success'] = "Chào mừng " . $user['full_name'] . "!";
    }

    // login cho admin

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
                header("Location: /admin/index"); exit;
            } else {
                $_SESSION['error'] = 'Không có quyền truy cập!'; header("Location: /auth/adminLogin"); exit;
            }
        } else {
            $_SESSION['error'] = 'Sai thông tin đăng nhập!'; header("Location: /auth/adminLogin");
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
            $_SESSION['error'] = 'Email đã tồn tại!'; header("Location: /auth/adminRegister"); exit;
        }

        $data = [
            'username' => $username, 'email' => $email, 'password' => $_POST['password'], 
            'role' => 1, 'avatar' => 'image/avatar/admin-default.png'
        ];

        if ($adminModel->create($data)) {
            $_SESSION['success'] = 'Đăng ký thành công! Chờ duyệt.'; header("Location: /auth/adminLogin");
        } else {
            $_SESSION['error'] = 'Lỗi đăng ký!'; header("Location: /auth/adminRegister");
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: /auth/login");
        exit;
    }
}