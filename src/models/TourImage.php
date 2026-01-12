
<?php
require_once __DIR__ . '/../../config/database.php';
class TourImage
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
        $sql = "SELECT * FROM tour_images";
        $result = $this->conn->query($sql);
        $images = [];
        if ($result)
            while ($row = $result->fetch_assoc())
                $images[] = $row;
        return $images;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_images WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function create($tour_id, $image)
    {
        $stmt = $this->conn->prepare("INSERT INTO tour_images (tour_id, image) VALUES (?, ?)");
        $stmt->bind_param("is", $tour_id, $image);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tour_images WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function __destruct()
    {
        $this->db->close();
    }

    public function getImagesByTourIdForListTour($tour_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_images WHERE tour_id = ?");
        $stmt->bind_param("i", $tour_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $images[] = $row;
        }
        return $images;
    }
}
