<?php
class ProductController extends Controller {

    // user xem sản phẩm
    public function index() {
        $productModel = $this->model('ProductModel');
        $products = $productModel->all(); 

        $this->view('client/product/index', ['products' => $products]);
    }

    public function detail($id) {
        $productModel = $this->model('ProductModel');
        $product = $productModel->find($id);

        if (!$product) {
            echo "Sản phẩm không tồn tại";
            return;
        }

        $this->view('client/product/detail', ['product' => $product]);
    }

    // admin quản lý sản phẩm
    public function manage() {
        $productModel = $this->model('ProductModel');
        $data = $productModel->all();
        $this->view('admin/product/index', ['products' => $data]);
    }

    public function create() {
        $categories = $this->model('CategoryModel')->all();
        $brands = $this->model('BrandModel')->all();

        $this->view('admin/product/create', [
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function store() {
        $imagePath = '';
        
        $categories = $this->model('CategoryModel')->all();
        $brands = $this->model('BrandModel')->all();

        if (empty($_POST['name']) || strlen($_POST['name']) < 3 || strlen($_POST['name']) > 255) {
            $mess = "Tên sản phẩm không được để trống, không ít hơn 3 hoặc nhiều hơn 255 ký tự";
            $this->view('admin/product/create', [
                'mess' => $mess,
                'categories' => $categories,
                'brands' => $brands
            ]);
            return;
        }
        
        // Validate giá bán
        if (!is_numeric($_POST['price']) || $_POST['price'] < 0) {
            $mess = "Giá bán không hợp lệ!";
            $this->view('admin/product/create', [
                'mess' => $mess,
                'categories' => $categories,
                'brands' => $brands
            ]);
            return;
        }

        if ($_POST['price'] > 999999999) {
            $mess = "Giá bán quá lớn!";
            $this->view('admin/product/create', [
                'mess' => $mess,
                'categories' => $categories,
                'brands' => $brands
            ]);
            return;
        }

        if (!empty($_POST['sale_price']) && $_POST['sale_price'] > $_POST['price']) {
            $mess = "Giá khuyến mãi không được lớn hơn giá gốc!";
            $this->view('admin/product/create', [
                'mess' => $mess,
                'categories' => $categories,
                'brands' => $brands
            ]);
            return;
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = 'public/image/product/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imagePath = $targetFilePath; 
            }
        }

        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'sale_price' => $_POST['sale_price'] ?? 0,
            'quantity' => $_POST['quantity'] ?? 0,
            'image' => $imagePath,
            'description' => $_POST['description'],
            'short_description' => $_POST['short_description'],
            'category_id' => $_POST['category_id'],
            'brand_id' => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
            'status' => $_POST['status']
        ];

        $this->model('ProductModel')->create($data);
        header("Location: /product/manage");
    }

    public function edit($id) {
        $product = $this->model('ProductModel')->find($id);
        $categories = $this->model('CategoryModel')->all();
        $brands = $this->model('BrandModel')->all();

        $this->view('admin/product/edit', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function update($id) {
        $productModel = $this->model('ProductModel');
        
        $currentProduct = $productModel->find($id);
        $imagePath = $currentProduct['image']; 

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = 'public/image/product/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $fileName;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                if (!empty($imagePath) && file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $imagePath = $targetFilePath;
            }
        }

        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'sale_price' => $_POST['sale_price'] ?? 0,
            'quantity' => $_POST['quantity'] ?? 0,
            'image' => $imagePath,
            'description' => $_POST['description'],
            'short_description' => $_POST['short_description'],
            'category_id' => $_POST['category_id'],
            'brand_id' => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
            'status' => $_POST['status']
        ];

        $productModel->update($id, $data);
        header("Location: /product/manage");
    }

    public function delete($id) {
        $this->model('ProductModel')->delete($id);
        header("Location: /product/manage");
    }
}