<?php
class AdminModel extends Model {
    private $table = 'admins';

    public function all() {
        $sql = "SELECT * FROM `$this->table` ORDER BY id DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM `$this->table` WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM `$this->table` WHERE email = :email";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByUsername($username) {
        $sql = "SELECT * FROM `$this->table` WHERE username = :username";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO `$this->table` (avatar, email, password, role, username) 
                VALUES (:avatar, :email, :password, :role, :username)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':avatar'   => $data['avatar'] ?? 'image/avatar/admin-default.png',
            ':email'    => $data['email'],
            ':password' => $data['password'],
            ':role'     => $data['role'] ?? 1, 
            ':username' => $data['username']
        ]);
    }

    public function update($id, $data) {
        $params = [
            ':avatar'   => $data['avatar'],
            ':email'    => $data['email'],
            ':role'     => $data['role'],
            ':username' => $data['username'],
            ':id'       => $id
        ];

        $passwordSql = "";
        if (!empty($data['password'])) {
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $passwordSql = ", password = :password";
        }

        $sql = "UPDATE `$this->table` SET 
                avatar = :avatar, 
                email = :email, 
                role = :role, 
                username = :username 
                $passwordSql 
                WHERE id = :id";
        
        $conn = $this->connect();
        return $conn->prepare($sql)->execute($params);
    }

    public function delete($id) {
        $sql = "DELETE FROM `$this->table` WHERE id = :id";
        $conn = $this->connect();
        return $conn->prepare($sql)->execute([':id' => $id]);
    }
}