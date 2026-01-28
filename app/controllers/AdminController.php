<?php
class AdminController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] != 2) {
            $_SESSION['error'] = "Vui lòng đăng nhập tài khoản Quản trị để tiếp tục.";
            header("Location: /auth/adminLogin");
            exit;
        }
    }

    public function index() {
        $this->view('admin/dashboard', [
            'pageTitle' => 'Bảng điều khiển Admin'
        ]); 
    }
}