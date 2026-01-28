<?php
class ProductModel extends Model
{
    private $table = 'products';

    public function all()
    {
        $sql = "SELECT p.*, 
                c.name as category_name, 
                b.name as brand_name,
                (SELECT image_path FROM product_images WHERE product_id = p.id AND is_thumbnail = 1 LIMIT 1) as thumbnail_path,
                (SELECT COUNT(*) FROM variants WHERE product_id = p.id) as variant_count
                FROM $this->table p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                ORDER BY p.created_at DESC";

        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO $this->table 
                (name, short_description, description, base_price, category_id, brand_id, status) 
                VALUES 
                (:name, :short_description, :description, :base_price, :category_id, :brand_id, :status)";

        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);

        return $conn->lastInsertId();
    }

    public function update($id, $data)
    {
        $data['id'] = $id;

        $sql = "UPDATE $this->table SET 
                name = :name, 
                short_description = :short_description, 
                description = :description, 
                base_price = :base_price, 
                category_id = :category_id, 
                brand_id = :brand_id,
                status = :status
                WHERE id = :id";

        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);

        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}