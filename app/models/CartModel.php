<?php
class CartModel extends Model {
    private $tableOrder = 'orders';
    private $tableDetail = 'order_details';

    // Lưu đơn hàng và chi tiết đơn hàng
    public function checkout($userId, $total, $couponCode, $cartItems) {
        $sql = "INSERT INTO $this->tableOrder (user_id, total_price, coupon_code, status, created_at) VALUES (?, ?, ?, 'pending', NOW())";
        $conn = $this->connect($sql); // Lấy connection theo cách của bạn
        
        try {
            $conn->beginTransaction();

            $stmt = $conn->prepare($sql);
            $stmt->execute([$userId, $total, $couponCode]);
            $orderId = $conn->lastInsertId();

            $sqlDetail = "INSERT INTO $this->tableDetail (order_id, product_id, quantity, unit_price, color, size) VALUES (?, ?, ?, ?, ?, ?)";
            $stmtDetail = $conn->prepare($sqlDetail);

            foreach ($cartItems as $item) {
                $stmtDetail->execute([
                    $orderId,
                    $item['id'],
                    $item['quantity'],
                    $item['price'],
                    $item['color'] ?? '',
                    $item['size'] ?? ''
                ]);
            }

            $conn->commit();
            return $orderId;
        } catch (Exception $e) {
            $conn->rollBack();
            return false;
        }
    }
}