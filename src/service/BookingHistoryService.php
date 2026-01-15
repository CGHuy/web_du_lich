<?php
require_once __DIR__ . '/../../config/database.php';

class BookingHistoryService
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Lấy lịch sử đặt tour của một user (có thể lọc theo trạng thái)
     */
    public function getByUserId($userId, $status = null)
    {
        $query = "
            SELECT 
                b.id,
                b.booking_code,
                b.user_id,
                b.departure_id,
                b.adults,
                b.children,
                b.total_price,
                b.payment_status,
                b.status as booking_status,
                b.contact_name,
                b.contact_phone,
                b.contact_email,
                b.note,
                b.created_at,
                b.updated_at,
                td.id as departure_id,
                td.departure_code,
                td.departure_location,
                td.departure_date,
                td.price_moving,
                td.seats_total,
                td.seats_available,
                td.status as departure_status,
                t.id as tour_id,
                t.tour_code,
                t.name as tour_name,
                t.slug,
                t.description,
                t.location,
                t.region,
                t.duration,
                t.price_default,
                t.cover_image
            FROM bookings b
            JOIN tour_departures td ON b.departure_id = td.id
            JOIN tours t ON td.tour_id = t.id
            WHERE b.user_id = ?
        ";

        $types = 'i';
        $params = [$userId];

        if ($status && in_array($status, ['pending_cancellation', 'confirmed', 'cancelled'])) {
            $query .= " AND b.status = ?";
            $types .= 's';
            $params[] = $status;
        }

        $query .= " ORDER BY b.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $bind_names = [];
        $bind_names[] = $types;
        for ($i = 0; $i < count($params); $i++) {
            $bind_name = 'bind' . $i;
            $$bind_name = $params[$i];
            $bind_names[] = &$$bind_name;
        }
        call_user_func_array([$stmt, 'bind_param'], $bind_names);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Lấy chi tiết một booking
     */
    public function getById($bookingId)
    {
        $query = "
            SELECT 
                b.id,
                b.booking_code,
                b.user_id,
                b.departure_id,
                b.adults,
                b.children,
                b.total_price,
                b.payment_status,
                b.status as booking_status,
                b.contact_name,
                b.contact_phone,
                b.contact_email,
                b.note,
                b.created_at,
                b.updated_at,
                td.id as departure_id,
                td.departure_code,
                td.departure_location,
                td.departure_date,
                td.price_moving,
                td.seats_total,
                td.seats_available,
                td.status as departure_status,
                t.id as tour_id,
                t.tour_code,
                t.name as tour_name,
                t.slug,
                t.description,
                t.location,
                t.region,
                t.duration,
                t.price_default,
                t.cover_image
            FROM bookings b
            JOIN tour_departures td ON b.departure_id = td.id
            JOIN tours t ON td.tour_id = t.id
            WHERE b.id = ?
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
