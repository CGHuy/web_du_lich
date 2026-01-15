<?php
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/TourDeparture.php';

class BookingAdminService
{
    private $bookingModel;
    private $tourDepartureModel;

    public function __construct()
    {
        $this->bookingModel = new Booking();
        $this->tourDepartureModel = new TourDeparture();
    }
    // Lấy tất cả bookings với lọc trạng thái và tìm kiếm
    public function getAll($status = '', $search = '')
    {
        // Lấy tất cả bookings từ model
        $allBookings = $this->bookingModel->getAll();

        // Lọc theo trạng thái nếu có
        if (!empty($status)) {
            // Support both legacy option keys and canonical DB status keys
            $statusMap = [
                'status-warning' => 'pending_cancellation',
                'status-success' => 'confirmed',
                'status-danger' => 'cancelled',
                'pending_cancellation' => 'pending_cancellation',
                'confirmed' => 'confirmed',
                'cancelled' => 'cancelled',
            ];
            $filterStatus = $statusMap[$status] ?? '';
            if ($filterStatus) {
                $allBookings = array_filter($allBookings, function ($b) use ($filterStatus) {
                    return ($b['status'] ?? '') === $filterStatus;
                });
            }
        }

        // Lọc theo từ khóa tìm kiếm (booking code, customer name, tour name)
        $search = trim((string) $search);
        if ($search !== '') {
            $searchLower = mb_strtolower($search, 'UTF-8');
            $allBookings = array_filter($allBookings, function ($b) use ($searchLower) {
                $code = mb_strtolower($b['booking_code'] ?? ('BK' . str_pad($b['id'] ?? '', 5, '0', STR_PAD_LEFT)), 'UTF-8');
                $customer = mb_strtolower($b['customer_name'] ?? $b['user_name'] ?? '', 'UTF-8');
                $tour = mb_strtolower($b['tour_name'] ?? '', 'UTF-8');
                return (strpos($code, $searchLower) !== false) || (strpos($customer, $searchLower) !== false) || (strpos($tour, $searchLower) !== false);
            });
        }

        // Chuẩn hóa dữ liệu
        foreach ($allBookings as &$booking) {
            $booking['booking_code'] = $booking['booking_code'] ?? 'BK' . str_pad($booking['id'], 5, '0', STR_PAD_LEFT);
            $booking['user_name'] = $booking['customer_name'] ?? 'N/A';
            $booking['tour_name'] = $booking['tour_name'] ?? null;
            $departure = $this->tourDepartureModel->getById($booking['departure_id']);
            if (empty($booking['tour_name'])) {
                if (!empty($departure['tour_id'])) {
                    require_once __DIR__ . '/../models/Tour.php';
                    $tourModel = new Tour();
                    $tour = $tourModel->getById($departure['tour_id']);
                    $booking['tour_name'] = $tour['name'] ?? 'N/A';
                } else {
                    $booking['tour_name'] = 'N/A';
                }
            }
            $booking['departure_date'] = $departure['departure_date'] ?? '';
            $booking['total_price'] = $booking['total_price'] ?? 0;
            $booking['booking_status'] = $booking['status'] ?? '';
            $booking['created_at'] = $booking['created_at'] ?? date('Y-m-d H:i:s');
        }
        unset($booking);

        return $allBookings;
    }

    // Lấy chi tiết booking
    public function getDetail($id)
    {
        return $this->bookingModel->getById($id);
    }
}