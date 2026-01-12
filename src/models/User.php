<?php
require_once __DIR__ . '/../../config/database.php';
class User
{
    private $db;
    private $conn;
    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }
    public function getAll()
    {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        $users = [];
        if ($result)
            while ($row = $result->fetch_assoc())
                $users[] = $row;
        return $users;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function create($fullname, $phone, $email, $password, $role = 'customer', $status = 1)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (fullname, phone, email, password, role, status) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssi", $fullname, $phone, $email, $password, $role, $status);
        return $stmt->execute();
    }
    public function update($id, $fullname, $phone, $email, $password, $role, $status)
    {
        $stmt = $this->conn->prepare("UPDATE users SET fullname = ?, phone = ?, email = ?, password = ?, role = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $fullname, $phone, $email, $password, $role, $status, $id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // Count bookings for a user
    public function countBookings($userId)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as cnt FROM bookings WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return isset($row['cnt']) ? (int)$row['cnt'] : 0;
    }

    public function getConnection()
    {
        return $this->conn;
    }
    public function __destruct()
    {
        $this->db->close();
    }
}
