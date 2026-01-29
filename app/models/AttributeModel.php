<?php
class AttributeModel extends Model {

    public function allWithValues() {
        $conn = $this->connect();
        
        $sqlAttr = "SELECT * FROM attributes ORDER BY id DESC";
        $stmtAttr = $conn->prepare($sqlAttr);
        $stmtAttr->execute(); 
        $attributes = $stmtAttr->fetchAll(PDO::FETCH_ASSOC);

        foreach ($attributes as &$attr) {
            $sqlVal = "SELECT * FROM attribute_values WHERE attribute_id = ? ORDER BY id ASC";
            $stmtVal = $conn->prepare($sqlVal);
            $stmtVal->execute([$attr['id']]);
            $attr['values'] = $stmtVal->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $attributes;
    }

    public function findAttribute($id) {
        $conn = $this->connect();
        $stmt = $conn->prepare("SELECT * FROM attributes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createAttribute($name) {
        $conn = $this->connect();
        $sql = "INSERT INTO attributes (name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$name]);
    }

    public function createValue($attributeId, $value) {
        $conn = $this->connect();
        $sql = "INSERT INTO attribute_values (attribute_id, value) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$attributeId, $value]);
    }

    public function updateAttribute($id, $name) {
        $conn = $this->connect();
        $stmt = $conn->prepare("UPDATE attributes SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

    public function updateValue($id, $value) {
        $conn = $this->connect();
        $stmt = $conn->prepare("UPDATE attribute_values SET value = ? WHERE id = ?");
        return $stmt->execute([$value, $id]);
    }

    public function deleteAttribute($id) {
        $conn = $this->connect();
        $stmt = $conn->prepare("DELETE FROM attributes WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function deleteValue($id) {
        $conn = $this->connect();
        $stmt = $conn->prepare("DELETE FROM attribute_values WHERE id = ?");
        return $stmt->execute([$id]);
    }
}