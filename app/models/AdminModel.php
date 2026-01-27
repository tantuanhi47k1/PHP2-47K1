<?php
class AdminModel extends Model
{
    private $table = 'admins';

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM `$this->table` WHERE `email` = :email LIMIT 1";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => trim($email)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all()
    {
        $sql = "SELECT `id`, `username`, `email`, `role`, `avatar` FROM `$this->table` ORDER BY `id` DESC";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM `$this->table` WHERE `id` = :id";
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO `$this->table` (`username`, `email`, `password`, `role`, `avatar`) 
                VALUES (:username, :email, :password, :role, :avatar)";
        
        $conn = $this->connect($sql);
        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':username' => $data['username'],
            ':email'    => $data['email'],
            ':password' => $data['password'],
            ':role'     => 1,
            ':avatar'   => $data['avatar'] ?? 'image/avatar/admin_default.png'
        ]);
    }
}