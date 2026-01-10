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
        public function create($name, $slug, $description, $status = 1)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO services (name, slug, description, status)
            VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("sssi", $name, $slug, $description, $status);

        if ($stmt->execute()) {
            return $this->conn->insert_id;
        }
        return false;
    }

        public function update($id, $name, $slug, $description, $status)
        {
            $stmt = $this->conn->prepare(
                "UPDATE services
                SET name = ?, slug = ?, description = ?, status = ?
                WHERE id = ?"
            );
            $stmt->bind_param("sssii", $name, $slug, $description, $status, $id);
            return $stmt->execute();
        }


    public function getPaged($limit, $offset)
    {
        $stmt = $this->conn->prepare("SELECT * FROM services ORDER BY id DESC LIMIT ? OFFSET ?");
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) $items[] = $row;
        return $items;
    }

    public function count()
    {
        $res = $this->conn->query("SELECT COUNT(*) AS cnt FROM services");
        return $res ? (int)$res->fetch_assoc()['cnt'] : 0;
    }

    public function toggleStatus($id)
    {
        $stmt = $this->conn->prepare("UPDATE services SET status = 1 - status WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getBySlug($slug)
    {
        $stmt = $this->conn->prepare("SELECT * FROM services WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
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
