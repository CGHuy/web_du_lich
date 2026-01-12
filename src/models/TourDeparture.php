<?php
require_once __DIR__ . '/../../config/database.php';
class TourDeparture
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
        $sql = "SELECT td.*, t.name AS tour_name FROM tour_departures td JOIN tours t ON td.tour_id = t.id";
        $result = $this->conn->query($sql);
        $departures = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Kiểm tra và cập nhật status nếu đã quá thời gian khởi hành
                if ($row['status'] != 'closed' && strtotime($row['departure_date']) < time()) {
                    $this->updateStatus($row['id'], 'closed');
                    $row['status'] = 'closed';
                }
                // Kiểm tra và cập nhật status nếu hết chỗ
                elseif ($row['seats_available'] == 0 && $row['status'] != 'full') {
                    $this->updateStatus($row['id'], 'full');
                    $row['status'] = 'full';
                }
                $departures[] = $row;
            }
        }
        return $departures;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_departures WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function create($tour_id, $departure_location, $departure_date, $price_moving, $price_moving_child, $seats_total, $seats_available, $status = 'open')
    {
        $stmt = $this->conn->prepare("INSERT INTO tour_departures (tour_id, departure_location, departure_date, price_moving, price_moving_child, seats_total, seats_available, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issddiis", $tour_id, $departure_location, $departure_date, $price_moving, $price_moving_child, $seats_total, $seats_available, $status);
        return $stmt->execute();
    }
    public function update($id, $tour_id, $departure_location, $departure_date, $price_moving, $price_moving_child, $seats_total, $seats_available, $status)
    {
        $stmt = $this->conn->prepare("UPDATE tour_departures SET tour_id = ?, departure_location = ?, departure_date = ?, price_moving = ?, price_moving_child = ?, seats_total = ?, seats_available = ?, status = ? WHERE id = ?");
        $stmt->bind_param("issddiisi", $tour_id, $departure_location, $departure_date, $price_moving, $price_moving_child, $seats_total, $seats_available, $status, $id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tour_departures WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getByTourIdForBookingTour($tour_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_departures WHERE tour_id = ?");
        $stmt->bind_param("i", $tour_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $departures = [];
        while ($row = $result->fetch_assoc()) {
            $departures[] = $row;
        }
        return $departures;
    }

    public function updateStatus($id, $status)
    {
        $stmt = $this->conn->prepare("UPDATE tour_departures SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
