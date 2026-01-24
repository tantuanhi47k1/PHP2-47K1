<?php 
class HomeController extends Controller {
    
    public function index() {
        $productModel = $this->model('ProductModel');
        $products = $productModel->all();
        
        $dataView = [
            'title' => 'Trang Chủ - MY SHOP',
            'products' => $products
        ];

        $this->view('admin/home/index', $dataView);
    }
}