<?php 
class HomeController extends Controller {
    
    public function index() {
        // Kiểm tra session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // --- SỬA LẠI ĐOẠN NÀY ---
        
        // 1. Gọi Model để lấy dữ liệu sản phẩm hiển thị ra trang chủ
        // (Giả sử bạn muốn hiện danh sách sản phẩm mới nhất)
        $productModel = $this->model('ProductModel');
        $products = $productModel->all(); 

        // 2. Gọi View của KHÁCH HÀNG (Client)
        // File này nằm ở: app/views/client/home/index.blade.php
        $this->view('client/home/index', [
            'products' => $products
        ]);
    }
}