<?php
require_once __DIR__ . '/../../config/database.php';
class Review
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
        $sql = "SELECT * FROM reviews";
        $result = $this->conn->query($sql);
        $reviews = [];
        if ($result)
            while ($row = $result->fetch_assoc())
                $reviews[] = $row;
        return $reviews;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function create($user_id, $tour_id, $rating, $comment = null)
    {
        $stmt = $this->conn->prepare("INSERT INTO reviews (user_id, tour_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $user_id, $tour_id, $rating, $comment);
        return $stmt->execute();
    }
    public function update($id, $user_id, $tour_id, $rating, $comment)
    {
        $stmt = $this->conn->prepare("UPDATE reviews SET user_id = ?, tour_id = ?, rating = ?, comment = ? WHERE id = ?");
        $stmt->bind_param("iiisi", $user_id, $tour_id, $rating, $comment, $id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function __destruct()
    {
        $this->db->close();
    }

    public function getByTourIdForListTour($tour_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE tour_id = ?");
        $stmt->bind_param("i", $tour_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $reviews = [];
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
        return $reviews;
    }
}
