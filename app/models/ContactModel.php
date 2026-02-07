<?php
class ContactModel extends Model {
    private $table = 'contacts';

    public function create($data) {
        $sql = "INSERT INTO $this->table (name, email, phone, subject, message) 
                VALUES (:name, :email, :phone, :subject, :message)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            ':name'    => $data['name'],
            ':email'   => $data['email'],
            ':phone'   => $data['phone'] ?? '',
            ':subject' => $data['subject'] ?? 'Liên hệ từ khách hàng',
            ':message' => $data['message']
        ]);
    }

    public function all() {
        $sql = "SELECT * FROM $this->table ORDER BY created_at DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}