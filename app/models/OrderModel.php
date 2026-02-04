<?php
class OrderModel extends Model
{
    private $table = 'orders';

    public function create($data)
    {
        $sql = "INSERT INTO $this->table 
                (user_id, fullname, phone, address, note, total_money, payment_method, status, created_at) 
                VALUES 
                (:user_id, :fullname, :phone, :address, :note, :total_money, :payment_method, :status, NOW())";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        
        $stmt->execute([
            ':user_id'       => $data['user_id'] ?? null,
            ':fullname'      => $data['fullname'],
            ':phone'         => $data['phone'],
            ':address'       => $data['address'],
            ':note'          => $data['note'] ?? '',
            ':total_money'   => $data['total_money'],
            ':payment_method'=> $data['payment_method'],
            ':status'        => $data['status'] ?? 1
        ]);

        return $conn->lastInsertId();
    }

    public function find($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id LIMIT 1";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function all()
    {
        $sql = "SELECT * FROM $this->table ORDER BY created_at DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrdersByUserId($userId)
    {
        $sql = "SELECT * FROM $this->table WHERE user_id = :user_id ORDER BY created_at DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateStatus($id, $status)
    {
        $sql = "UPDATE $this->table SET status = :status WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    }
}