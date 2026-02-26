<?php
class ProductModel extends Model
{
    private $table = 'products';

    public function getProducts($keyword = '', $categoryId = null, $minPrice = null, $maxPrice = null, $page = 1, $limit = 9)
    {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT p.*, 
                       c.name as category_name, 
                       b.name as brand_name,
                       (SELECT image_path FROM product_images WHERE product_id = p.id AND is_thumbnail = 1 LIMIT 1) as image,
                       (SELECT MIN(price) FROM variants WHERE product_id = p.id) as variant_price
                FROM $this->table p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE 1=1 AND p.status = 1";

        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND p.name LIKE :keyword";
            $params[':keyword'] = "%$keyword%";
        }
        if (!empty($categoryId)) {
            $sql .= " AND p.category_id = :cat_id";
            $params[':cat_id'] = $categoryId;
        }

        if ($minPrice !== null) {
            $sql .= " AND p.base_price >= :min_price";
            $params[':min_price'] = $minPrice;
        }
        if ($maxPrice !== null) {
            $sql .= " AND p.base_price <= :max_price";
            $params[':max_price'] = $maxPrice;
        }

        $sql .= " ORDER BY p.created_at DESC LIMIT $limit OFFSET $offset";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countTotal($keyword = '', $categoryId = null, $minPrice = null, $maxPrice = null)
    {
        $sql = "SELECT COUNT(*) as total FROM $this->table p WHERE 1=1 AND p.status = 1";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND p.name LIKE :keyword";
            $params[':keyword'] = "%$keyword%";
        }
        if (!empty($categoryId)) {
            $sql .= " AND p.category_id = :cat_id";
            $params[':cat_id'] = $categoryId;
        }

        if ($minPrice !== null) {
            $sql .= " AND p.base_price >= :min_price";
            $params[':min_price'] = $minPrice;
        }
        if ($maxPrice !== null) {
            $sql .= " AND p.base_price <= :max_price";
            $params[':max_price'] = $maxPrice;
        }

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function find($id)
    {
        $sql = "SELECT p.*,
                       c.name as category_name,
                       b.name as brand_name,
                       (SELECT image_path FROM product_images WHERE product_id = p.id AND is_thumbnail = 1 LIMIT 1) as image,
                       (SELECT MIN(price) FROM variants WHERE product_id = p.id) as variant_price,
                       (SELECT MAX(price) FROM variants WHERE product_id = p.id) as max_price
                FROM $this->table p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.id = :id";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getVariants($productId)
    {
        $sql = "SELECT * FROM variants WHERE product_id = :id ORDER BY price ASC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getImages($productId)
    {
        $sql = "SELECT * FROM product_images WHERE product_id = :id ORDER BY is_thumbnail DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function all()
    {
        $sql = "SELECT p.*, 
                       c.name as category_name,
                       b.name as brand_name,
                       (SELECT image_path FROM product_images WHERE product_id = p.id AND is_thumbnail = 1 LIMIT 1) as image,
                       (SELECT MIN(price) FROM variants WHERE product_id = p.id) as variant_price,
                       (SELECT COUNT(*) FROM variants WHERE product_id = p.id) as variant_count
                FROM $this->table p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                ORDER BY p.created_at DESC";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO $this->table 
                (name, short_description, description, base_price, category_id, brand_id, status) 
                VALUES 
                (:name, :short_description, :description, :base_price, :category_id, :brand_id, :status)";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':short_description' => $data['short_description'],
            ':description' => $data['description'],
            ':base_price' => $data['base_price'],
            ':category_id' => $data['category_id'],
            ':brand_id' => $data['brand_id'],
            ':status' => $data['status']
        ]);

        return $conn->lastInsertId();
    }

    public function update($id, $data)
    {
        $sql = "UPDATE $this->table SET 
                name = :name, 
                short_description = :short_description, 
                description = :description, 
                base_price = :base_price, 
                category_id = :category_id, 
                brand_id = :brand_id,
                status = :status
                WHERE id = :id";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':name' => $data['name'],
            ':short_description' => $data['short_description'],
            ':description' => $data['description'],
            ':base_price' => $data['base_price'],
            ':category_id' => $data['category_id'],
            ':brand_id' => $data['brand_id'],
            ':status' => $data['status'],
            ':id' => $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function getRelatedProducts($categoryId, $currentProductId, $limit = 4)
    {
        $sql = "SELECT p.*, 
                       (SELECT image_path FROM product_images WHERE product_id = p.id AND is_thumbnail = 1 LIMIT 1) as image,
                       (SELECT MIN(price) FROM variants WHERE product_id = p.id) as variant_price
                FROM $this->table p
                WHERE p.category_id = :category_id 
                  AND p.id <> :current_id 
                  AND p.status = 1
                ORDER BY RAND() 
                LIMIT :limit";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        
        $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':current_id', $currentProductId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}