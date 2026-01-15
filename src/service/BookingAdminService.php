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

    // Lấy booking với phân trang và lọc theo trạng thái
    public function getAllWithPagination($status = '', $page = 1, $perPage = 10)
    {
        $page = max(1, (int) $page);

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
                // Filter strictly by canonical DB status (pending_cancellation, confirmed, cancelled)
                $allBookings = array_filter($allBookings, function ($b) use ($filterStatus) {
                    return ($b['status'] ?? '') === $filterStatus;
                });
            }
        }

        // Phân trang
        $offset = ($page - 1) * $perPage;
        $bookings = array_slice($allBookings, $offset, $perPage);

        // Chuẩn hóa dữ liệu
        foreach ($bookings as &$booking) {
            $booking['booking_code'] = $booking['booking_code'] ?? 'BK' . str_pad($booking['id'], 5, '0', STR_PAD_LEFT);
            $booking['user_name'] = $booking['customer_name'] ?? 'N/A';
            // Try to ensure we have a tour name: prefer joined value, fallback to departure -> tour lookup
            $booking['tour_name'] = $booking['tour_name'] ?? null;
            $departure = $this->tourDepartureModel->getById($booking['departure_id']);
            if (empty($booking['tour_name'])) {
                // attempt to resolve via departure -> tour
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

        return $bookings;
    }

    // Lấy tất cả bookings (không phân trang), giữ chuẩn hóa giống getAllWithPagination
    public function getAll($status = '')
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

        // Chuẩn hóa dữ liệu
        foreach ($allBookings as &$booking) {
            $booking['booking_code'] = $booking['booking_code'] ?? 'BK' . str_pad($booking['id'], 5, '0', STR_PAD_LEFT);
            $booking['user_name'] = $booking['customer_name'] ?? 'N/A';
            // Try to ensure we have a tour name: prefer joined value, fallback to departure -> tour lookup
            $booking['tour_name'] = $booking['tour_name'] ?? null;
            $departure = $this->tourDepartureModel->getById($booking['departure_id']);
            if (empty($booking['tour_name'])) {
                // attempt to resolve via departure -> tour
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


    // Lấy tổng số trang
    public function getTotalPages($status = '', $perPage = 10)
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
                // Filter strictly by canonical DB status (pending_cancellation, confirmed, cancelled)
                $allBookings = array_filter($allBookings, function ($b) use ($filterStatus) {
                    return ($b['status'] ?? '') === $filterStatus;
                });
            }
        }

        $total = count($allBookings);
        return ceil($total / $perPage);
    }

    // Lấy chi tiết booking
    public function getDetail($id)
    {
        return $this->bookingModel->getById($id);
    }
}