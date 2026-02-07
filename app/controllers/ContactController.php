<?php
class ContactController extends Controller {

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        $user = [];
        if (isset($_SESSION['user_id'])) {
            $userModel = $this->model('UserModel');
            $user = $userModel->find($_SESSION['user_id']);
        }

        $this->view('client/contact/index', [
            'user' => $user
        ]);
    }

    public function send() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start();

            $contactModel = $this->model('ContactModel');

            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $message = trim($_POST['message']);
            $phone = $_POST['phone'] ?? '';
            $subject = $_POST['subject'] ?? '';

            if (empty($name) || empty($email) || empty($message)) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ các trường bắt buộc (*)";
                header("Location: /contact");
                exit;
            }

            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $message
            ];

            if ($contactModel->create($data)) {
                $_SESSION['success'] = "Cảm ơn bạn! Chúng tôi đã nhận được tin nhắn và sẽ phản hồi sớm nhất.";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra, vui lòng thử lại sau.";
            }
        }
        
        header("Location: /contact");
    }
}