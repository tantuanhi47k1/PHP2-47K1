<?php
class DashboardModel extends Model
{
    public function getTotalProducts() {
        $sql = "SELECT COUNT(*) as count FROM products";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['count'] : 0;
    }

    public function getNewOrders() {
        $sql = "SELECT COUNT(*) as count FROM orders WHERE status = 1";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['count'] : 0;
    }

    public function getMonthlyRevenue() {
        $sql = "SELECT SUM(total_money) as total FROM orders 
                WHERE status = 3 
                AND MONTH(created_at) = MONTH(CURRENT_DATE()) 
                AND YEAR(created_at) = YEAR(CURRENT_DATE())";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalCustomers() {
        $sql = "SELECT COUNT(*) as count FROM users"; 
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['count'] : 0;
    }

    public function getRecentOrders() {
        $sql = "SELECT id, fullname, created_at, total_money, status FROM orders ORDER BY created_at DESC LIMIT 5";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLowStockProducts() {
        $sql = "SELECT p.id, p.name, 
                       SUM(IFNULL(v.stock_quantity, 0)) as stock, 
                       (SELECT image_path FROM product_images WHERE product_id = p.id AND is_thumbnail = 1 LIMIT 1) as image 
                FROM products p 
                LEFT JOIN variants v ON p.id = v.product_id 
                GROUP BY p.id, p.name 
                HAVING SUM(IFNULL(v.stock_quantity, 0)) <= 5 
                ORDER BY stock ASC 
                LIMIT 5";
                
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRevenueLast7Days() {
        $dates = [];
        $revenues = [];
        
        $conn = $this->connect();
        
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $dates[] = date('d/m', strtotime($date));

            $sql = "SELECT SUM(total_money) as total FROM orders WHERE DATE(created_at) = :date AND status = 3";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':date' => $date]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $revenues[] = $result['total'] ?? 0;
        }
        
        return ['dates' => $dates, 'revenues' => $revenues];
    }
}