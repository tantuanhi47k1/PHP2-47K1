<?php
class CategoryModel extends Model {
    private $table = 'categories';
    
    public function getAllWithProductCount() {
        $sql = "SELECT c.*, COUNT(p.id) as product_count 
                FROM {$this->table} c 
                LEFT JOIN products p ON c.id = p.category_id 
                GROUP BY c.id
                ORDER BY c.name ASC";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function all() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (name, slug, parent_id) VALUES (:name, :slug, :parent_id)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':slug', $data['slug']);

        if (isset($data['parent_id']) && $data['parent_id'] !== null) {
            $stmt->bindValue(':parent_id', $data['parent_id'], PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':parent_id', null, PDO::PARAM_NULL);
        }

        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET name = :name, slug = :slug, parent_id = :parent_id WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bindValue(':name', $data['name']);
        $stmt->bindValue(':slug', $data['slug']);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        if (isset($data['parent_id']) && $data['parent_id'] !== null) {
            $stmt->bindValue(':parent_id', $data['parent_id'], PDO::PARAM_INT);
        } else {
            $stmt->bindValue(':parent_id', null, PDO::PARAM_NULL);
        }

        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}