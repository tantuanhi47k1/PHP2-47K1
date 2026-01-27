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
            $mess = "Dữ liệu không hợp lệ!";
            $this->view('admin/product/create', [
                'mess' => $mess,
                'categories' => $this->model('CategoryModel')->all(),
                'brands' => $this->model('BrandModel')->all()
            ]);
            return;
        }

        $productData = [
            'name'        => $_POST['name'],
            'base_price'  => $_POST['base_price'],
            'description' => $_POST['description'] ?? '',
            'category_id' => $_POST['category_id'],
            'brand_id'    => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
        ];
        
        $productId = $productModel->create($productData);

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $files = $_FILES['images'];
            $targetDir = 'image/product/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            foreach ($files['name'] as $key => $name) {
                if ($files['error'][$key] == 0) {
                    $fileName = time() . '_' . basename($name);
                    $targetPath = $targetDir . $fileName;
                    
                    if (move_uploaded_file($files['tmp_name'][$key], $targetPath)) {
                        $imageModel->create([
                            'product_id'   => $productId,
                            'variant_id'   => null,
                            'image_path'   => $targetPath,
                            'is_thumbnail' => ($key == 0) ? 1 : 0 
                        ]);
                    }
                }
            }
        }
        
        header("Location: /product");
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
            'name'        => $_POST['name'],
            'base_price'  => $_POST['base_price'],
            'description' => $_POST['description'],
            'category_id' => $_POST['category_id'],
            'brand_id'    => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null
        ];
        $productModel->update($id, $productData);

        if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
            $files = $_FILES['images'];
            $targetDir = 'image/product/';

            foreach ($files['name'] as $key => $name) {
                if ($files['error'][$key] == 0) {
                    $fileName = time() . '_' . $name;
                    $targetPath = $targetDir . $fileName;
                    
                    if (move_uploaded_file($files['tmp_name'][$key], $targetPath)) {
                        $imageModel->create([
                            'product_id'   => $id,
                            'variant_id'   => null,
                            'image_path'   => $targetPath,
                            'is_thumbnail' => 0 
                        ]);
                    }
                }
            }
        }

        header("Location: /product");
    }

    public function delete($id) {
        $this->model('ProductModel')->delete($id);
        header("Location: /product");
    }
}