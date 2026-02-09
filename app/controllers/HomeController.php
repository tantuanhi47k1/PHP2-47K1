<?php
class HomeController extends Controller
{
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $productModel = $this->model('ProductModel');
        $categoryModel = $this->model('CategoryModel');

        $likedProductIds = [];
        if (isset($_SESSION['user_id'])) {
            $favModel = $this->model('FavoriteModel');
            $likedProductIds = $favModel->getLikedProductIds($_SESSION['user_id']);
        }
        $products = $productModel->all();
        $categories = $categoryModel->all();

        $this->view('client/home/index', [
            'products' => $products,
            'categories' => $categories,
            'likedProductIds' => $likedProductIds
        ]);
    }
}