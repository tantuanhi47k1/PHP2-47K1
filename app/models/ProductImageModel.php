<?php
class ProductImageModel extends Model
{
    private $table = 'product_images';

    public function getImagesByProductId($productId)
    {
        $sql = "SELECT * FROM $this->table WHERE product_id = :product_id ORDER BY is_thumbnail DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImagesByVariantId($variantId)
    {
        $sql = "SELECT * FROM $this->table WHERE variant_id = :variant_id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':variant_id' => $variantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO $this->table 
                (product_id, variant_id, image_path, is_thumbnail) 
                VALUES 
                (:product_id, :variant_id, :image_path, :is_thumbnail)";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':product_id'   => $data['product_id'],
            ':variant_id'   => $data['variant_id'] ?? null,
            ':image_path'   => $data['image_path'],
            ':is_thumbnail' => $data['is_thumbnail'] ?? 0
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function setThumbnail($productId, $imageId)
    {
        $conn = $this->connect();

        try {
            $sqlReset = "UPDATE $this->table SET is_thumbnail = 0 WHERE product_id = :product_id";
            $stmtReset = $conn->prepare($sqlReset);
            $stmtReset->execute([':product_id' => $productId]);

            $sqlSet = "UPDATE $this->table SET is_thumbnail = 1 WHERE id = :image_id";
            $stmtSet = $conn->prepare($sqlSet);
            return $stmtSet->execute([':image_id' => $imageId]);
            
        } catch (Exception $e) {
            return false;
        }
    }
}