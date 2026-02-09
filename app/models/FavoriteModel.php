<?php
class FavoriteModel extends Model {
    private $table = 'favorites';

    public function getLikedProductIds($userId) {
        $sql = "SELECT product_id FROM $this->table WHERE user_id = :user_id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function toggle($userId, $productId) {
        $conn = $this->connect();
        $checkSql = "SELECT id FROM $this->table WHERE user_id = :uid AND product_id = :pid";
        $stmt = $conn->prepare($checkSql);
        $stmt->execute([':uid' => $userId, ':pid' => $productId]);
        $exists = $stmt->fetch();

        if ($exists) {
            $delSql = "DELETE FROM $this->table WHERE user_id = :uid AND product_id = :pid";
            $stmtDel = $conn->prepare($delSql);
            $stmtDel->execute([':uid' => $userId, ':pid' => $productId]);
            return 'removed';
        } else {
            $insSql = "INSERT INTO $this->table (user_id, product_id) VALUES (:uid, :pid)";
            $stmtIns = $conn->prepare($insSql);
            $stmtIns->execute([':uid' => $userId, ':pid' => $productId]);
            return 'added';
        }
    }

    public function getFavoritesByUser($userId) {
        $sql = "SELECT p.*, f.created_at as liked_at, MAX(pi.image_path) as image
                FROM products p 
                JOIN favorites f ON p.id = f.product_id 
                LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_thumbnail = 1
                WHERE f.user_id = :uid 
                GROUP BY p.id 
                ORDER BY f.created_at DESC";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}