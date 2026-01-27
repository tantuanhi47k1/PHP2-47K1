<?php
class BrandModel extends Model {
    private $table = 'brands';

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
        $sql = "INSERT INTO $this->table (name, logo, description) VALUES (:name, :logo, :description)";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $sql = "UPDATE $this->table SET name = :name, logo = :logo, description = :description WHERE id = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute($data);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}