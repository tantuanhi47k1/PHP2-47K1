<?php 
class HomeController extends Controller {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['admin_id']) && $_SESSION['admin_role'] == 2) {
            header("Location: /admin/index");
            exit;
        }

        header("Location: /auth/adminLogin");
        exit;
    }
}