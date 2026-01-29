<?php 
class HomeController extends Controller {
    
    public function index() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $productModel = $this->model('ProductModel');
        $products = $productModel->all(); 

        $this->view('client/home/index', [
            'products' => $products
        ]);
    }
}