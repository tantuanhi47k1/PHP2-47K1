<?php
class ProductController extends Controller {

    public function index() {
        $productModel = $this->model('ProductModel');
        $products = $productModel->all(); 

        $this->view('admin/product/index', ['products' => $products]);
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
        $productModel = $this->model('ProductModel');
        $imageModel = $this->model('ProductImageModel');

        if (empty($_POST['name']) || !isset($_POST['base_price']) || $_POST['base_price'] < 0) {
            $this->view('admin/product/create', [
                'mess' => "Dữ liệu không hợp lệ!",
                'categories' => $this->model('CategoryModel')->all(),
                'brands' => $this->model('BrandModel')->all()
            ]);
            return;
        }

        $productData = [
            'name'              => $_POST['name'],
            'short_description' => $_POST['short_description'] ?? '',
            'description'       => $_POST['description'] ?? '',
            'base_price'        => $_POST['base_price'],
            'category_id'       => $_POST['category_id'],
            'brand_id'          => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
            'status'            => $_POST['status'] ?? 1,
        ];

        $productId = $productModel->create($productData);

        if ($productId && isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $files = $_FILES['images'];

            $targetDir = 'public/image/product/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            foreach ($files['name'] as $key => $name) {
                if ($files['error'][$key] == 0) {
                    $fileName = time() . '_' . basename($name);

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
        
        header("Location: /product");
        exit;
    }

    public function edit($id) {
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
        $productModel = $this->model('ProductModel');
        $imageModel = $this->model('ProductImageModel');

        $productData = [
            'name'              => $_POST['name'],
            'short_description' => $_POST['short_description'] ?? '', 
            'description'       => $_POST['description'] ?? '',
            'base_price'        => $_POST['base_price'],
            'category_id'       => $_POST['category_id'],
            'brand_id'          => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
            'status'            => $_POST['status']
        ];

        $productModel->update($id, $productData);

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $files = $_FILES['images'];

            $targetDir = 'public/image/product/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            foreach ($files['name'] as $key => $name) {
                if ($files['error'][$key] == 0) {
                    $fileName = time() . '_' . basename($name);

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

        header("Location: /product");
        exit;
    }

    public function delete($id) {
        $productModel = $this->model('ProductModel');
        $imageModel = $this->model('ProductImageModel');

        $images = $imageModel->getImagesByProductId($id);
        if (!empty($images)) {
            foreach ($images as $img) {
                $realPath = 'public/' . $img['image_path'];
                
                if (file_exists($realPath)) {
                    unlink($realPath);
                }
            }
        }

        $productModel->delete($id);

        header("Location: /product");
        exit;
    }
}