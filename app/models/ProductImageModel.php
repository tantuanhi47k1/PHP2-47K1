<?php
class ProductImageModel extends Model
{
    private $table = 'product_images';

    public function getImagesByProductId($productId)
    {
        $sql = "SELECT * FROM $this->table WHERE product_id = :product_id ORDER BY is_thumbnail DESC";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO $this->table 
                (product_id, variant_id, image_path, is_thumbnail) 
                VALUES 
                (:product_id, :variant_id, :image_path, :is_thumbnail)";

        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}