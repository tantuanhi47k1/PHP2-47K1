<?php
class CategoryModel extends Model {
    private $table = 'categories';

    public function all() {
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO $this->table (name, slug, parent_id) VALUES (:name, :slug, :parent_id)";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name'      => $data['name'],
            ':slug'      => $data['slug'],
            ':parent_id' => $data['parent_id'],
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE $this->table SET name = :name, slug = :slug, parent_id = :parent_id WHERE id = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name'      => $data['name'],
            ':slug'      => $data['slug'],
            ':parent_id' => $data['parent_id'],
            ':id'        => $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}