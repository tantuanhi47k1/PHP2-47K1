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
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            $data['password'] = null;
        }

        $sql = "INSERT INTO `$this->table` 
                (`full_name`, `email`, `password`, `phone`, `address`, `avatar`, `status`, `google_id`, `auth_provider`) 
                VALUES 
                (:full_name, :email, :password, :phone, :address, :avatar, :status, :google_id, :auth_provider)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $result = $stmt->execute([
            ':full_name'    => $data['full_name'], 
            ':email'        => $data['email'],
            ':password'     => $data['password'],
            ':phone'        => $data['phone'] ?? null,
            ':address'      => $data['address'] ?? null,
            ':avatar'       => $data['avatar'] ?? 'image/avatar/default.png',
            ':status'       => $data['status'] ?? 1,
            ':google_id'    => $data['google_id'] ?? null,
            ':auth_provider'=> $data['auth_provider'] ?? 'local'
        ]);

        if ($result) {
            return $conn->lastInsertId();
        }
        return false;
    }

    public function update($id, $data)
    {
        $params = [
            ':full_name' => $data['full_name'],
            ':email'     => $data['email'],
            ':phone'     => $data['phone'] ?? null,
            ':address'   => $data['address'] ?? null,
            ':avatar'    => $data['avatar'] ?? 'image/avatar/default.png',
            ':status'    => $data['status'] ?? 1,
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
                `avatar` = :avatar,
                `status` = :status
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

    // tìm email

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM `$this->table` WHERE email = :email";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkEmailExist($email)
    {
        $sql = "SELECT COUNT(*) as count FROM `$this->table` WHERE email = :email";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // tìm gg id
    public function findByGoogleId($google_id)
    {
        $sql = "SELECT * FROM `$this->table` WHERE google_id = :google_id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':google_id' => $google_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // update gg id
    public function updateGoogleId($id, $google_id)
    {
        $sql = "UPDATE `$this->table` SET google_id = :google_id, auth_provider = 'google' WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':google_id' => $google_id, ':id' => $id]);
    }

    // quên mk

    public function updateResetToken($email, $token) {
        $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        
        $sql = "UPDATE `$this->table` SET reset_token = :token, reset_token_expiry = :expiry WHERE email = :email";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':token' => $token,
            ':expiry' => $expiry,
            ':email' => $email
        ]);
    }

    public function findByResetToken($token) {
        $now = date('Y-m-d H:i:s');
        
        $sql = "SELECT * FROM `$this->table` WHERE reset_token = :token AND reset_token_expiry > :now";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':token' => $token,
            ':now' => $now
        ]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePasswordAndClearToken($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $sql = "UPDATE `$this->table` SET password = :password, reset_token = NULL, reset_token_expiry = NULL WHERE id = :id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => $id
        ]);
    }
}