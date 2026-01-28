<?php
class CouponModel extends Model
{
    private $table = 'coupons';

    public function all()
    {
        $sql = "SELECT * FROM $this->table WHERE deleted_at IS NULL ORDER BY id DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id AND deleted_at IS NULL";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByCode($code)
    {
        $sql = "SELECT * FROM $this->table WHERE code = :code AND deleted_at IS NULL";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':code' => $code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO $this->table (code, discount_type, discount_value, min_order_value, max_discount_amount, start_date, end_date, usage_limit) 
                VALUES (:code, :discount_type, :discount_value, :min_order_value, :max_discount_amount, :start_date, :end_date, :usage_limit)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $data['id'] = $id;
        $sql = "UPDATE $this->table SET 
                code = :code, 
                discount_type = :discount_type, 
                discount_value = :discount_value, 
                min_order_value = :min_order_value, 
                max_discount_amount = :max_discount_amount, 
                start_date = :start_date, 
                end_date = :end_date, 
                usage_limit = :usage_limit 
                WHERE id = :id";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $sql = "UPDATE $this->table SET deleted_at = NOW() WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}