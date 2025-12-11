<?php
require_once __DIR__ . '/../../config/database.php';
class Service
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
        $sql = "SELECT * FROM services";
        $result = $this->conn->query($sql);
        $services = [];
        if ($result)
            while ($row = $result->fetch_assoc())
                $services[] = $row;
        return $services;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function create($name, $slug, $description, $icon, $status = 1)
    {
        $stmt = $this->conn->prepare("INSERT INTO services (name, slug, description, icon, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $slug, $description, $icon, $status);
        return $stmt->execute();
    }
    public function update($id, $name, $slug, $description, $icon, $status)
    {
        $stmt = $this->conn->prepare("UPDATE services SET name = ?, slug = ?, description = ?, icon = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssii", $name, $slug, $description, $icon, $status, $id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM services WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function __destruct()
    {
        $this->db->close();
    }
}
