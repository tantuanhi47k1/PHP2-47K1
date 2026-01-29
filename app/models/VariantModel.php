<?php
class VariantModel extends Model {

    public function getByProductId($productId) {
        $conn = $this->connect();
        $sql = "SELECT v.*, 
                GROUP_CONCAT(a.name, ': ', av.value SEPARATOR ' - ') as sku_info
                FROM variants v
                LEFT JOIN variant_attribute_values vav ON v.id = vav.variant_id
                LEFT JOIN attribute_values av ON vav.attribute_value_id = av.id
                LEFT JOIN attributes a ON av.attribute_id = a.id
                WHERE v.product_id = :pid
                GROUP BY v.id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':pid' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM variants WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSelectedValueIds($variantId) {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT attribute_value_id FROM variant_attribute_values WHERE variant_id = ?");
        $stmt->execute([$variantId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function createVariant($data) {
        $conn = $this->connect();
        $sql = "INSERT INTO variants (product_id, price, sku, stock_quantity, image, is_default) 
                VALUES (:pid, :price, :sku, :stock, :img, :is_default)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':pid'        => $data['product_id'],
            ':price'      => $data['price'],
            ':sku'        => $data['sku'],
            ':stock'      => $data['stock_quantity'],
            ':img'        => $data['image'],
            ':is_default' => $data['is_default'] ?? 0
        ]);
        return $conn->lastInsertId();
    }

    public function updateVariant($id, $data) {
        $conn = $this->connect();

        $sql = "UPDATE variants SET price = :price, stock_quantity = :stock, image = :img WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':price' => $data['price'],
            ':stock' => $data['stock_quantity'],
            ':img'   => $data['image'],
            ':id'    => $id
        ]);

        $stmtDel = $conn->prepare("DELETE FROM variant_attribute_values WHERE variant_id = ?");
        $stmtDel->execute([$id]);

        if (!empty($data['attribute_values'])) {
            foreach ($data['attribute_values'] as $valId) {
                $this->addAttributeValue($id, $valId);
            }
        }
        return true;
    }

    public function addAttributeValue($variantId, $attributeValueId) {
        $conn = $this->connect();
        $stmt = $conn->prepare("INSERT INTO variant_attribute_values (variant_id, attribute_value_id) VALUES (?, ?)");
        $stmt->execute([$variantId, $attributeValueId]);
    }

    public function updateFast($id, $price, $stock) {
        $conn = $this->connect();
        $stmt = $conn->prepare("UPDATE variants SET price = ?, stock_quantity = ? WHERE id = ?");
        return $stmt->execute([$price, $stock, $id]);
    }

    public function deleteVariant($id) {
        $conn = $this->connect();
        $stmtDel = $conn->prepare("DELETE FROM variant_attribute_values WHERE variant_id = ?");
        $stmtDel->execute([$id]);
        
        $stmt = $conn->prepare("DELETE FROM variants WHERE id = ?");
        return $stmt->execute([$id]);
    }
}