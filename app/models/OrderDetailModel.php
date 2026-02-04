<?php
class OrderDetailModel extends Model
{
    private $table = 'order_details';

    public function create($data)
    {
        $sql = "INSERT INTO $this->table 
                (order_id, product_id, product_name, price, quantity, total_price) 
                VALUES 
                (:order_id, :product_id, :product_name, :price, :quantity, :total_price)";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            ':order_id'     => $data['order_id'],
            ':product_id'   => $data['product_id'],
            ':product_name' => $data['product_name'],
            ':price'        => $data['price'],
            ':quantity'     => $data['quantity'],
            ':total_price'  => $data['total_price']
        ]);
    }

    public function getDetailsByOrderId($orderId)
    {
        $sql = "SELECT od.*, 
                       (SELECT image_path FROM product_images WHERE product_id = od.product_id AND is_thumbnail = 1 LIMIT 1) as image
                FROM $this->table od
                WHERE od.order_id = :order_id";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}