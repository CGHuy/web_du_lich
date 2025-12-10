<?php
require_once __DIR__ . '/../../config/database.php';

class Destination
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllDestinations()
    {
        $sql = "SELECT * FROM destinations";
        $result = $this->conn->query($sql);
        $destinations = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $destinations[] = $row;
            }
        }
        return $destinations;
    }

    public function getDestinationById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM destinations WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function createDestination($name, $user_id, $description)
    {
        $stmt = $this->conn->prepare("INSERT INTO destinations (name, user_id, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $name, $user_id, $description);
        return $stmt->execute();
    }

    public function updateDestination($id, $name, $user_id, $description)
    {
        $stmt = $this->conn->prepare("UPDATE destinations SET name = ?, user_id = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sisi", $name, $user_id, $description, $id);
        return $stmt->execute();
    }

    public function deleteDestination($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM destinations WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
?>