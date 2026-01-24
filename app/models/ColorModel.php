<?php
class ColorModel extends Model {
    private $table = 'colors';
    public function all() {
        $sql = "SELECT * FROM $this->table";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt ->execute();
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
        $sql = "INSERT INTO $this->table (name) VALUES (:name)";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE $this->table SET name = :name WHERE id = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':id' => $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}