<?php
class MemberModel extends Model
{
    private $table = 'members';

    public function all()
    {
        $sql = "SELECT * FROM `$this->table` ORDER BY id DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // tìm tv theo id
    public function find($id)
    {
        $sql = "SELECT * FROM `$this->table` WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // add tv
    public function create($data)
    {
        $sql = "INSERT INTO `$this->table` 
                (`gen`, `name`, `branch`, `birth`, `death`, `spouse`, `avatar`, `father_id`, `note`) 
                VALUES 
                (:gen, :name, :branch, :birth, :death, :spouse, :avatar, :father_id, :note)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $result = $stmt->execute([
            ':gen'       => $data['gen'],
            ':name'      => $data['name'],
            ':branch'    => $data['branch'] ?? null,
            ':birth'     => !empty($data['birth']) ? $data['birth'] : null,
            ':death'     => !empty($data['death']) ? $data['death'] : null,
            ':spouse'    => $data['spouse'] ?? null,
            ':avatar'    => $data['avatar'] ?? null,
            ':father_id' => $data['father_id'] ?? null,
            ':note'      => $data['note'] ?? null
        ]);

        if ($result) {
            return $conn->lastInsertId();
        }
        return false;
    }

    // update tv
    public function updateMember($id, $data)
    {
        $allowedFields = ['gen', 'name', 'branch', 'birth', 'death', 'spouse', 'avatar', 'father_id', 'note'];
        
        $sets = [];
        $params = [':id' => $id];

        foreach ($allowedFields as $field) {
            if (array_key_exists($field, $data)) {
                $sets[] = "`$field` = :$field";
                if (in_array($field, ['birth', 'death'])) {
                     $params[":$field"] = !empty($data[$field]) ? $data[$field] : null;
                } else {
                     $params[":$field"] = $data[$field];
                }
            }
        }

        if (empty($sets)) {
            return true;
        }

        $sql = "UPDATE `$this->table` SET " . implode(', ', $sets) . " WHERE id = :id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }

    // delete tv
    public function delete($id)
    {
        $sql = "DELETE FROM `$this->table` WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // tìm kiếm
    public function search($q)
    {
        $sql = "SELECT * FROM `$this->table` 
                WHERE `name` LIKE :q 
                   OR `branch` LIKE :q 
                   OR `gen` LIKE :q 
                   OR `note` LIKE :q 
                ORDER BY id DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':q' => "%{$q}%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>