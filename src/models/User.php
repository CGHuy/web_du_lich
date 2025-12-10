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

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        $users = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function getUserById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        if (!$stmt)
            return null;
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createUser($name, $email)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
        if (!$stmt)
            return false;
        $stmt->bind_param("ss", $name, $email);
        return $stmt->execute();
    }

    public function updateUser($id, $name, $email)
    {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        if (!$stmt)
            return false;
        $stmt->bind_param("ssi", $name, $email, $id);
        return $stmt->execute();
    }

    public function deleteUser($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        if (!$stmt)
            return false;
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
?>