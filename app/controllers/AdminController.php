<?php
class AdminController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['admin_id']) || $_SESSION['admin_role'] != 2) {
            header("Location: /auth/adminLogin");
            exit;
        }
    }

    public function index() {
        $this->view('admin/dashboard'); 
    }
}