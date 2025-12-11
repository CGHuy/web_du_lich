<?php
require_once __DIR__ . '/../../config/database.php';
class Wishlist
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
        $sql = "SELECT * FROM wishlist";
        $result = $this->conn->query($sql);
        $wishlist = [];
        if ($result)
            while ($row = $result->fetch_assoc())
                $wishlist[] = $row;
        return $wishlist;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM wishlist WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function create($user_id, $tour_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO wishlist (user_id, tour_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $tour_id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM wishlist WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function __destruct()
    {
        $this->db->close();
    }
}
