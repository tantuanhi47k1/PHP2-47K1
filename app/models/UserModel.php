<?php
class UserModel extends Model
{
    private $table = 'users';

    public function all()
    {
        $sql = "SELECT * FROM `$this->table` ORDER BY id DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM `$this->table` WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql = "INSERT INTO `users` (`full_name`, `email`, `password`, `phone`, `address`, `avatar`, `google_id`, `auth_provider`) 
                VALUES (:full_name, :email, :password, :phone, :address, :avatar, :google_id, :auth_provider)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        return $stmt->execute([
            ':full_name'     => $data['full_name'], 
            ':email'         => $data['email'],
            ':password'      => $data['password'],
            ':phone'         => $data['phone'] ?? null,
            ':address'       => $data['address'] ?? null,
            ':avatar'        => $data['avatar'] ?? 'image/avatar/default.png',
            ':google_id'     => $data['google_id'] ?? null,
            ':auth_provider' => $data['auth_provider'] ?? 'local'
        ]);
    }

    public function update($id, $data)
    {
        $params = [
            ':full_name' => $data['full_name'],
            ':email'     => $data['email'],
            ':phone'     => $data['phone'] ?? null,
            ':address'   => $data['address'] ?? null,
            ':avatar'    => $data['avatar'] ?? 'image/avatar/default.png',
            ':id'        => $id
        ];

        $passwordSql = "";
        if (!empty($data['password'])) {
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $passwordSql = ", `password` = :password";
        }

        $sql = "UPDATE `$this->table` SET 
                `full_name` = :full_name, 
                `email` = :email, 
                `phone` = :phone, 
                `address` = :address, 
                `avatar` = :avatar 
                $passwordSql
                WHERE id = :id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM `$this->table` WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}