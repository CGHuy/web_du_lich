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
            $statusMap = [
                'status-warning' => 'pending',
                'status-success' => 'confirmed',
                'status-danger' => 'cancelled',
            ];
            $filterStatus = $statusMap[$status] ?? '';
            if ($filterStatus) {
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
            $booking['tour_name'] = $booking['tour_name'] ?? 'N/A';
            $booking['departure_date'] = $booking['departure_date'] ?? $booking['booking_date'] ?? '';
            $booking['total_price'] = $booking['total_price'] ?? 0;
            $booking['booking_status'] = $booking['status'] ?? '';
            $booking['created_at'] = $booking['created_at'] ?? date('Y-m-d H:i:s');
        }
        unset($booking);

        return $bookings;
    }

    // Lấy tổng số trang
    public function getTotalPages($status = '', $perPage = 10)
    {
        // Lấy tất cả bookings từ model
        $allBookings = $this->bookingModel->getAll();

        // Lọc theo trạng thái nếu có
        if (!empty($status)) {
            $statusMap = [
                'status-warning' => 'pending',
                'status-success' => 'confirmed',
                'status-danger' => 'cancelled',
            ];
            $filterStatus = $statusMap[$status] ?? '';
            if ($filterStatus) {
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