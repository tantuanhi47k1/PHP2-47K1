<?php
class VariantController extends Controller {

    private function requireAdmin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['admin_id'])) {
            header("Location: /auth/adminLogin");
            exit;
        }
    }

    public function index($productId = null) {
        $this->requireAdmin();

        if (!$productId) {
            header("Location: /product/manage");
            exit;
        }

        $productModel = $this->model('ProductModel');
        $variantModel = $this->model('VariantModel');
        $attributeModel = $this->model('AttributeModel');

        $product = $productModel->find($productId);
        
        if (!$product) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm!";
            header("Location: /product/manage");
            exit;
        }

        $variants = $variantModel->getByProductId($productId);

        $attributes = $attributeModel->getAttributesByCategoryId($product['category_id']);

        $this->view('admin/variant/index', [
            'product'    => $product,
            'variants'   => $variants,
            'attributes' => $attributes
        ]);
    }

    public function store() {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variantModel = $this->model('VariantModel');
            $productId = $_POST['product_id'];

            $imagePath = null;
            if (!empty($_FILES['image']['name'])) {
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetDir = dirname(__DIR__, 2) . '/public/image/variant/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $fileName)) {
                    $imagePath = 'image/variant/' . $fileName;
                }
            }

            $variantData = [
                'product_id'     => $productId,
                'variant_name'   => $_POST['variant_name'] ?? null,
                'price'          => $_POST['price'] ?? 0,
                'sku'            => 'SKU-' . strtoupper(uniqid()),
                'stock_quantity' => $_POST['stock'] ?? 0,
                'image'          => $imagePath,
                'is_default'     => 0
            ];

            $variantId = $variantModel->createVariant($variantData);

            if ($variantId && !empty($_POST['attribute_values'])) {
                foreach ($_POST['attribute_values'] as $valueId) {
                    if(!empty($valueId)) {
                        $variantModel->addAttributeValue($variantId, $valueId);
                    }
                }
            }

            $_SESSION['success'] = "Đã thêm biến thể mới thành công!";
            header("Location: /variant/index/" . $productId);
            exit;
        }
    }

    public function edit($id) {
        $this->requireAdmin();

        $variantModel = $this->model('VariantModel');
        $productModel = $this->model('ProductModel');
        $attributeModel = $this->model('AttributeModel');

        $variant = $variantModel->find($id);
        if (!$variant) {
            $_SESSION['error'] = "Biến thể không tồn tại!";
            header("Location: /product/manage");
            exit;
        }

        $product = $productModel->find($variant['product_id']);

        $attributes = $attributeModel->getAttributesByCategoryId($product['category_id']);
        
        $selectedIds = $variantModel->getSelectedValueIds($id);

        $this->view('admin/variant/edit', [
            'variant'     => $variant,
            'product'     => $product,
            'attributes'  => $attributes,
            'selectedIds' => $selectedIds
        ]);
    }

    public function update($id) {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variantModel = $this->model('VariantModel');
            $oldVariant = $variantModel->find($id);

            if (!$oldVariant) {
                header("Location: /product/manage");
                exit;
            }

            $imagePath = $oldVariant['image'];
            if (!empty($_FILES['image']['name'])) {
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetDir = dirname(__DIR__, 2) . '/public/image/variant/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $fileName)) {
                    $imagePath = 'image/variant/' . $fileName;
                }
            }

            $updateData = [
                'variant_name'     => $_POST['variant_name'] ?? $oldVariant['variant_name'],
                'price'            => $_POST['price'],
                'stock_quantity'   => $_POST['stock'],
                'image'            => $imagePath,
                'attribute_values' => $_POST['attribute_values'] ?? []
            ];

            $variantModel->updateVariant($id, $updateData);

            $_SESSION['success'] = "Cập nhật biến thể thành công!";
            header("Location: /variant/index/" . $oldVariant['product_id']);
            exit;
        }
    }

    public function updateAll() {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $variantModel = $this->model('VariantModel');
            $prices = $_POST['prices'] ?? [];
            $stocks = $_POST['stocks'] ?? [];

            foreach ($prices as $id => $price) {
                $stock = $stocks[$id] ?? 0;
                $variantModel->updateFast($id, $price, $stock);
            }

            $_SESSION['success'] = "Đã cập nhật nhanh danh sách biến thể!";
            header("Location: /variant/index/" . $_POST['product_id']);
            exit;
        }
    }

    public function delete($id, $productId) {
        $this->requireAdmin();
        
        $variantModel = $this->model('VariantModel');
        $variantModel->deleteVariant($id);
        
        $_SESSION['success'] = "Đã xóa biến thể khỏi hệ thống!";
        header("Location: /variant/index/" . $productId);
        exit;
    }
}