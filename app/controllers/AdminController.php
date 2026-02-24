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
        $dashboardModel = $this->model('DashboardModel');

        $totalProducts    = $dashboardModel->getTotalProducts();
        $newOrders        = $dashboardModel->getNewOrders();
        $monthlyRevenue   = $dashboardModel->getMonthlyRevenue();
        $totalCustomers   = $dashboardModel->getTotalCustomers();
        
        $recentOrders     = $dashboardModel->getRecentOrders();
        $lowStockProducts = $dashboardModel->getLowStockProducts();
        $chartData        = $dashboardModel->getRevenueLast7Days();

        $this->view('admin/dashboard', [
            'pageTitle'        => 'Bảng điều khiển Admin',
            'totalProducts'    => $totalProducts,
            'newOrders'        => $newOrders,
            'monthlyRevenue'   => $monthlyRevenue,
            'totalCustomers'   => $totalCustomers,
            'recentOrders'     => $recentOrders,
            'lowStockProducts' => $lowStockProducts,
            'chartData'        => $chartData
        ]); 
    }
}