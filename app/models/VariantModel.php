<?php
class VariantModel extends Model {
    private $table = 'variants';

    public function getByProductId($productId) {
        $sql = "SELECT v.*, 
                (SELECT image_path FROM product_images WHERE variant_id = v.id LIMIT 1) as variant_image,
                GROUP_CONCAT(CONCAT(a.name, ': ', av.value) SEPARATOR ', ') as attributes_info
                FROM $this->table v
                LEFT JOIN variant_attribute_values vav ON v.id = vav.variant_id
                LEFT JOIN attribute_values av ON vav.attribute_value_id = av.id
                LEFT JOIN attributes a ON av.attribute_id = a.id
                WHERE v.product_id = :product_id
                GROUP BY v.id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO $this->table (product_id, variant_name, price, sku, stock_quantity) 
                VALUES (:product_id, :variant_name, :price, :sku, :stock_quantity)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
        return $conn->lastInsertId();
    }

    public function update($id, $data) {
        $data['id'] = $id; 
        $sql = "UPDATE $this->table SET 
                variant_name = :variant_name,
                price = :price, 
                sku = :sku, 
                stock_quantity = :stock_quantity 
                WHERE id = :id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}