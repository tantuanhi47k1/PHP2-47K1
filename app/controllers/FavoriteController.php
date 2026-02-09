<?php
class FavoriteController extends Controller {

    public function toggle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start();

            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['status' => 'login_required']);
                exit;
            }

            $productId = $_POST['product_id'] ?? 0;
            $userId = $_SESSION['user_id'];

            if ($productId) {
                $favModel = $this->model('FavoriteModel');
                $action = $favModel->toggle($userId, $productId);
                
                echo json_encode([
                    'status' => 'success', 
                    'action' => $action
                ]);
            } else {
                echo json_encode(['status' => 'error']);
            }
        }
    }

    public function index() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user_id'])) {
            header("Location: /auth/login");
            exit;
        }

        $favModel = $this->model('FavoriteModel');
        $products = $favModel->getFavoritesByUser($_SESSION['user_id']);

        $this->view('client/favorite/index', [
            'products' => $products
        ]);
    }
}