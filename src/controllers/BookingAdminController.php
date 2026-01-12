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
        include __DIR__ . '/../views/admin/QuanLyBooking/QuanLyBooking.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    public function detail()
    {
        $id = $_REQUEST['id'] ?? null;
        if (!$id) {
            header('Location: ' . route('BookingAdmin.index'));
            exit;
        }

        $bookingDetail = $this->bookingService->getDetail($id);

        // Chuẩn hóa dữ liệu (moved from view)
        if (!empty($bookingDetail)) {
            require_once __DIR__ . '/../models/TourDeparture.php';
            require_once __DIR__ . '/../models/Tour.php';

            $tourDeparture = new TourDeparture();
            $tourModel = new Tour();

            $departure = $tourDeparture->getById($bookingDetail['departure_id'] ?? null);
            $tour = $tourModel->getById($departure['tour_id'] ?? null);

            $bookingDetail['tour_code'] = $tour['tour_code'] ?? 'N/A';
            $bookingDetail['tour_name'] = $tour['name'] ?? 'N/A';
            $bookingDetail['departure_date'] = $departure['departure_date'] ?? $bookingDetail['created_at'] ?? '';
            $bookingDetail['departure_location'] = $departure['departure_location'] ?? 'N/A';
            $bookingDetail['booking_status'] = $bookingDetail['status'] ?? '';
            $bookingDetail['payment_status'] = $bookingDetail['payment_status'] ?? 'unpaid';
        }

        ob_start();
        include __DIR__ . '/../views/admin/QuanLyBooking/ChiTietBookingAdmin.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    // Xử lý yêu cầu hủy do admin (approve/reject)
    public function processCancel()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('BookingAdmin.index'));
            return;
        }
        $bookingId = isset($_POST['booking_id']) ? (int) $_POST['booking_id'] : null;
        $action = $_POST['admin_action'] ?? '';
        $adminNote = $_POST['admin_note'] ?? '';

        if (!$bookingId) {
            http_response_code(400);
            echo 'Missing booking id';
            return;
        }

        require_once __DIR__ . '/../models/Booking.php';
        $bookingModel = new Booking();

        if ($action === 'approve') {
            // mark as cancelled; in real app you might record refund_amount and process payment
            $bookingModel->updateStatus($bookingId, 'cancelled');
            // store admin note in note field (append)
            $existing = $bookingModel->getById($bookingId);
            $newNote = trim(($existing['note'] ?? '') . "\n[Admin] " . $adminNote);
            $stmt = $bookingModel->update($bookingId, $existing['user_id'], $existing['departure_id'], $existing['adults'], $existing['children'], $existing['total_price'], $existing['payment_status'], 'cancelled', $existing['contact_name'], $existing['contact_phone'], $existing['contact_email'], $newNote);

            if (session_status() === PHP_SESSION_NONE)
                session_start();
            $_SESSION['booking_success'] = true;
            $_SESSION['booking_message'] = 'Yêu cầu hủy đã được phê duyệt và đánh dấu Đã hủy.';
        } elseif ($action === 'reject') {
            // restore to confirmed
            $bookingModel->updateStatus($bookingId, 'confirmed');
            if (session_status() === PHP_SESSION_NONE)
                session_start();
            $_SESSION['booking_success'] = true;
            $_SESSION['booking_message'] = 'Yêu cầu hủy đã bị từ chối.';
        }

        header('Location: ' . route('BookingAdmin.detail', ['id' => $bookingId]));
    }
}