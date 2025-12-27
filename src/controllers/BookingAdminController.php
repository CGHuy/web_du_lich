<?php
require_once __DIR__ . '/../service/BookingAdminService.php';

class BookingAdminController
{
    private $bookingService;

    public function __construct()
    {
        $this->bookingService = new BookingAdminService();
    }

    public function index()
    {
        // Lấy trạng thái lọc nếu có
        $status = $_REQUEST['sort'] ?? '';
        $page = isset($_REQUEST['page']) ? max(1, (int) $_REQUEST['page']) : 1;
        $perPage = 5;

        // Lấy bookings từ service
        $bookings = $this->bookingService->getAllWithPagination($status, $page, $perPage);
        $totalPages = $this->bookingService->getTotalPages($status, $perPage);

        // Render view qua layout admin
        $currentPage = 'booking';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyBooking.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }
}