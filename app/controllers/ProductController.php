<?php

class ProductController extends Controller {

    public function index() {
        $productModel = $this->model('ProductModel');
        $products = $productModel->all(); 

        $this->view('client/product/index', ['products' => $products]);
    }

    public function detail($id) {
        $productModel = $this->model('ProductModel');
        $product = $productModel->find($id);

        if (!$product) {
            header("Location: /product");
            exit;
        }

        $variants = $productModel->getVariants($id);
        $images = $productModel->getImages($id);

        $this->view('client/product/detail', [
            'product'  => $product,
            'variants' => $variants,
            'images'   => $images
        ]);
    }

    private function requireAdmin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['admin_id'])) {
            header("Location: /auth/adminLogin");
            exit;
        }
    }

    public function manage() {
        $this->requireAdmin();

        $productModel = $this->model('ProductModel');
        $products = $productModel->all(); 

        $this->view('admin/product/index', ['products' => $products]);
    }

    public function create() {
        $this->requireAdmin();

        $categories = $this->model('CategoryModel')->all();
        $brands = $this->model('BrandModel')->all();

        $this->view('admin/product/create', [
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function store() {
        $this->requireAdmin();

        $productModel = $this->model('ProductModel');
        $imageModel = $this->model('ProductImageModel');

        $errors = [];
        $name = trim($_POST['name'] ?? '');
        $base_price = $_POST['base_price'] ?? '';
        $category_id = $_POST['category_id'] ?? '';
        $brand_id = $_POST['brand_id'] ?? '';

        if (empty($name)) {
            $errors[] = "Tên sản phẩm không được để trống.";
        }
        if ($base_price === '' || !is_numeric($base_price) || $base_price < 0) {
            $errors[] = "Giá sản phẩm phải là số và không được nhỏ hơn 0.";
        }
        if (empty($category_id)) {
            $errors[] = "Vui lòng chọn danh mục cho sản phẩm.";
        }
        if (empty($brand_id)) {
            $errors[] = "Vui lòng chọn thương hiệu cho sản phẩm.";
        }

        if (!empty($errors)) {
            $this->view('admin/product/create', [
                'errors'     => $errors,
                'old'        => $_POST,
                'categories' => $this->model('CategoryModel')->all(),
                'brands'     => $this->model('BrandModel')->all()
            ]);
            return;
        }

        $productData = [
            'name'              => $name,
            'short_description' => $_POST['short_description'] ?? '',
            'description'       => $_POST['description'] ?? '',
            'base_price'        => $base_price,
            'category_id'       => $category_id,
            'brand_id'          => $brand_id,
            'status'            => $_POST['status'] ?? 1,
        ];

        $productId = $productModel->create($productData);

        if ($productId && isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $files = $_FILES['images'];
            $targetDir = dirname(__DIR__, 2) . '/public/image/product/';
            
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            foreach ($files['name'] as $key => $nameFile) {
                if ($files['error'][$key] == 0) {
                    $fileName = time() . '_' . basename($nameFile);
                    $targetPath = $targetDir . $fileName; 
                    $dbPath = 'image/product/' . $fileName;

                    if (move_uploaded_file($files['tmp_name'][$key], $targetPath)) {
                        $imageModel->create([
                            'product_id'   => $productId,
                            'variant_id'   => null,
                            'image_path'   => $dbPath,
                            'is_thumbnail' => ($key == 0) ? 1 : 0 
                        ]);
                    }
                }
            }
        }
        
        header("Location: /product/manage");
        exit;
    }

    public function edit($id) {
        $this->requireAdmin();

        $product = $this->model('ProductModel')->find($id);
        $categories = $this->model('CategoryModel')->all();
        $brands = $this->model('BrandModel')->all();
        $images = $this->model('ProductImageModel')->getImagesByProductId($id);

        $this->view('admin/product/edit', [
            'product'    => $product,
            'categories' => $categories,
            'brands'     => $brands,
            'images'     => $images
        ]);
    }

    public function update($id) {
        $this->requireAdmin();

        $productModel = $this->model('ProductModel');
        $imageModel = $this->model('ProductImageModel');

        $errors = [];
        $name = trim($_POST['name'] ?? '');
        $base_price = $_POST['base_price'] ?? '';

        if (empty($name)) {
            $errors[] = "Tên sản phẩm không được để trống.";
        }
        if ($base_price === '' || !is_numeric($base_price) || $base_price < 0) {
            $errors[] = "Giá sản phẩm không hợp lệ.";
        }

        if (!empty($errors)) {
            $this->view('admin/product/edit', [
                'errors'     => $errors,
                'product'    => $productModel->find($id),
                'categories' => $this->model('CategoryModel')->all(),
                'brands'     => $this->model('BrandModel')->all(),
                'images'     => $imageModel->getImagesByProductId($id)
            ]);
            return;
        }

        $productData = [
            'name'              => $name,
            'short_description' => $_POST['short_description'] ?? '', 
            'description'       => $_POST['description'] ?? '',
            'base_price'        => $base_price,
            'category_id'       => $_POST['category_id'],
            'brand_id'          => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
            'status'            => $_POST['status']
        ];

        $productModel->update($id, $productData);

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $files = $_FILES['images'];
            $targetDir = dirname(__DIR__, 2) . '/public/image/product/';
            
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            foreach ($files['name'] as $key => $nameFile) {
                if ($files['error'][$key] == 0) {
                    $fileName = time() . '_' . basename($nameFile);
                    $targetPath = $targetDir . $fileName;
                    $dbPath = 'image/product/' . $fileName;

                    if (move_uploaded_file($files['tmp_name'][$key], $targetPath)) {
                        $imageModel->create([
                            'product_id'   => $id,
                            'variant_id'   => null,
                            'image_path'   => $dbPath,
                            'is_thumbnail' => 0 
                        ]);
                    }
                }
            }
        }

        header("Location: /product/manage");
        exit;
    }

    public function delete($id) {
        $this->requireAdmin();

        $productModel = $this->model('ProductModel');
        $imageModel = $this->model('ProductImageModel');

        $images = $imageModel->getImagesByProductId($id);
        if (!empty($images)) {
            $baseDir = dirname(__DIR__, 2) . '/public/';
            foreach ($images as $img) {
                $realPath = $baseDir . $img['image_path'];
                if (file_exists($realPath)) {
                    unlink($realPath);
                }
            }
        }

        $productModel->delete($id);

        header("Location: /product/manage");
        exit;
    }
}