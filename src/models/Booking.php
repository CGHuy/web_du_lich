<?php
require_once __DIR__ . '/../../config/database.php';
class Booking
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
        $sql = "SELECT * FROM bookings";
        $result = $this->conn->query($sql);
        $bookings = [];
        if ($result)
            while ($row = $result->fetch_assoc())
                $bookings[] = $row;
        return $bookings;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function create($user_id, $departure_id, $quantity, $total_price, $payment_status, $status, $contact_name, $contact_phone, $contact_email, $note)
    {
        $stmt = $this->conn->prepare("INSERT INTO bookings (user_id, departure_id, quantity, total_price, payment_status, status, contact_name, contact_phone, contact_email, note) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidssssss", $user_id, $departure_id, $quantity, $total_price, $payment_status, $status, $contact_name, $contact_phone, $contact_email, $note);
        return $stmt->execute();
    }
    public function update($id, $user_id, $departure_id, $quantity, $total_price, $payment_status, $status, $contact_name, $contact_phone, $contact_email, $note)
    {
        $stmt = $this->conn->prepare("UPDATE bookings SET user_id = ?, departure_id = ?, quantity = ?, total_price = ?, payment_status = ?, status = ?, contact_name = ?, contact_phone = ?, contact_email = ?, note = ? WHERE id = ?");
        $stmt->bind_param("iiidssssssi", $user_id, $departure_id, $quantity, $total_price, $payment_status, $status, $contact_name, $contact_phone, $contact_email, $note, $id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function __destruct()
    {
        $this->db->close();
    }
}
