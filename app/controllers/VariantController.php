<?php
class VariantController extends Controller {

    public function index($productId = null) {
        if (!$productId) {
            header("Location: /product");
            exit;
        }

        $product = $this->model('ProductModel')->find($productId);

        if (!$product) {
            header("Location: /product");
            exit;
        }

        $variants = $this->model('VariantModel')->getByProductId($productId);

        $this->view('admin/variant/index', [
            'product'  => $product,
            'variants' => $variants
        ]);
    }

    public function create($productId = null) {
        if (!$productId) {
            header("Location: /product");
            exit;
        }

        $product = $this->model('ProductModel')->find($productId);
        $conn = $this->model('Model')->connect();

        $stmtAttr = $conn->prepare("SELECT * FROM attributes");
        $stmtAttr->execute();
        $attributes = $stmtAttr->fetchAll(PDO::FETCH_ASSOC);

        foreach ($attributes as &$attr) {
            $stmtVal = $conn->prepare("SELECT * FROM attribute_values WHERE attribute_id = :aid");
            $stmtVal->execute([':aid' => $attr['id']]);
            $attr['values'] = $stmtVal->fetchAll(PDO::FETCH_ASSOC);
        }

        $this->view('admin/variant/create', [
            'product'    => $product,
            'attributes' => $attributes
        ]);
    }

    public function store($productId) {
        $variantModel = $this->model('VariantModel');
        $imageModel = $this->model('ProductImageModel');
        $conn = $this->model('Model')->connect();

        $variantId = $variantModel->create([
            'product_id'     => $productId,
            'variant_name'   => $_POST['variant_name'],
            'price'          => $_POST['price'],
            'sku'            => $_POST['sku'],
            'stock_quantity' => $_POST['stock_quantity']
        ]);

        if ($variantId && isset($_FILES['variant_image']) && $_FILES['variant_image']['error'] == 0) {
            $targetDir = 'public/image/product/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $fileName = time() . '_v_' . basename($_FILES['variant_image']['name']);

            $targetPath = $targetDir . $fileName;

            $dbPath = 'image/product/' . $fileName;

            if (move_uploaded_file($_FILES['variant_image']['tmp_name'], $targetPath)) {
                $imageModel->create([
                    'product_id'   => $productId,
                    'variant_id'   => $variantId,
                    'image_path'   => $dbPath,
                    'is_thumbnail' => 0 
                ]);
            }
        }

        if ($variantId && !empty($_POST['attributes'])) {
            $sqlAttr = "INSERT INTO variant_attribute_values (variant_id, attribute_value_id) VALUES (:vid, :avid)";
            $stmtAttr = $conn->prepare($sqlAttr);
            foreach ($_POST['attributes'] as $valueId) {
                $stmtAttr->execute([':vid' => $variantId, ':avid' => $valueId]);
            }
        }

        header("Location: /variant/index/$productId");
        exit;
    }

    public function edit($variantId) {
        $variantModel = $this->model('VariantModel');
        $conn = $this->model('Model')->connect();

        $variant = $variantModel->find($variantId);

        if (!$variant) {
            header("Location: /product");
            exit;
        }

        $product = $this->model('ProductModel')->find($variant['product_id']);

        $stmtSelected = $conn->prepare("SELECT attribute_value_id FROM variant_attribute_values WHERE variant_id = :vid");
        $stmtSelected->execute([':vid' => $variantId]);
        $selectedAttributes = $stmtSelected->fetchAll(PDO::FETCH_COLUMN);

        $stmtAttr = $conn->prepare("SELECT * FROM attributes");
        $stmtAttr->execute();
        $attributes = $stmtAttr->fetchAll(PDO::FETCH_ASSOC);

        foreach ($attributes as &$attr) {
            $stmtVal = $conn->prepare("SELECT * FROM attribute_values WHERE attribute_id = :aid");
            $stmtVal->execute([':aid' => $attr['id']]);
            $attr['values'] = $stmtVal->fetchAll(PDO::FETCH_ASSOC);
        }

        $this->view('admin/variant/edit', [
            'product'            => $product,
            'variant'            => $variant,
            'attributes'         => $attributes,
            'selectedAttributes' => $selectedAttributes
        ]);
    }

    public function update($variantId) {
        $variantModel = $this->model('VariantModel');
        $imageModel = $this->model('ProductImageModel');
        $conn = $this->model('Model')->connect();
        
        $variant = $variantModel->find($variantId);
        if (!$variant) {
            header("Location: /product/index");
            exit;
        }
        $productId = $variant['product_id'];

        $variantModel->update($variantId, [
            'variant_name'   => $_POST['variant_name'],
            'price'          => $_POST['price'],
            'sku'            => $_POST['sku'],
            'stock_quantity' => $_POST['stock_quantity']
        ]);

        if (isset($_FILES['variant_image']) && $_FILES['variant_image']['error'] == 0) {
            $targetDir = 'public/image/product/';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $fileName = time() . '_v_up_' . basename($_FILES['variant_image']['name']);
            $targetPath = $targetDir . $fileName;
            $dbPath = 'image/product/' . $fileName;

            if (move_uploaded_file($_FILES['variant_image']['tmp_name'], $targetPath)) {
                $oldImages = $imageModel->getImagesByVariantId($variantId);
                if (!empty($oldImages)) {
                    foreach ($oldImages as $old) {
                        $oldPath = 'public/' . $old['image_path'];
                        if (file_exists($oldPath)) unlink($oldPath);
                        
                        $imageModel->delete($old['id']);
                    }
                }

                $imageModel->create([
                    'product_id'   => $productId,
                    'variant_id'   => $variantId,
                    'image_path'   => $dbPath,
                    'is_thumbnail' => 0
                ]);
            }
        }

        $conn->prepare("DELETE FROM variant_attribute_values WHERE variant_id = :vid")
             ->execute([':vid' => $variantId]);

        if (!empty($_POST['attributes'])) {
            $sqlAttr = "INSERT INTO variant_attribute_values (variant_id, attribute_value_id) VALUES (:vid, :avid)";
            $stmtAttr = $conn->prepare($sqlAttr);
            foreach ($_POST['attributes'] as $valueId) {
                $stmtAttr->execute([':vid' => $variantId, ':avid' => $valueId]);
            }
        }
        
        header("Location: /variant/index/$productId");
        exit;
    }

    public function delete($variantId) {
        $variantModel = $this->model('VariantModel');
        $imageModel = $this->model('ProductImageModel');
        $variant = $variantModel->find($variantId);
        
        if ($variant) {
            $productId = $variant['product_id'];

            $images = $imageModel->getImagesByVariantId($variantId);
            foreach ($images as $img) {
                $realPath = 'public/' . $img['image_path'];
                if (file_exists($realPath)) unlink($realPath);
            }

            $variantModel->delete($variantId);
            header("Location: /variant/index/$productId");
        } else {
            header("Location: /product/index");
        }
        exit;
    }
}