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

    // Xử lý yêu cầu hủy (admin)
    public function processCancelRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('BookingAdmin.index'));
            return;
        }

        $bookingId = isset($_POST['booking_id']) ? (int) $_POST['booking_id'] : null;
        $action = $_POST['action'] ?? '';
        $refundAmount = isset($_POST['refund_amount']) ? floatval($_POST['refund_amount']) : 0;
        $refundNote = $_POST['refund_note'] ?? '';
        $adminNote = $_POST['admin_note'] ?? '';

        if (!$bookingId) {
            http_response_code(400);
            echo "Thiếu mã booking";
            return;
        }

        $bookingDetail = $this->bookingService->getDetail($bookingId);
        if (!$bookingDetail) {
            http_response_code(404);
            echo "Booking không tồn tại";
            return;
        }

        require_once __DIR__ . '/../models/Booking.php';
        $bookingModel = new Booking();
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        if ($action === 'approve') {
            // mark as cancelled and refunded
            $bookingModel->updateStatus($bookingId, 'cancelled');
            $bookingModel->updatePaymentStatus($bookingId, 'refunded');

            // Append admin note only when there is a positive refund amount or staff provided a note
            if (floatval($refundAmount) > 0 || trim($refundNote) !== '') {
                $noteParts = [];
                if (floatval($refundAmount) > 0) {
                    // store raw number amount (no thousands separator) for clarity
                    $noteParts[] = "Hoàn tiền: " . number_format($refundAmount, 0, '', '');
                }
                if (trim($refundNote) !== '') {
                    $noteParts[] = $refundNote;
                }
                $bookingModel->appendAdminNote($bookingId, implode(' - ', $noteParts));
            }

            // Show refund amount in the success message
            $_SESSION['admin_message'] = 'Đã phê duyệt hoàn tiền: <strong>' . number_format($refundAmount, 0, ',', '.') . ' đ</strong> và hủy booking.';
        } elseif ($action === 'deny') {
            // revert to confirmed state
            $bookingModel->updateStatus($bookingId, 'confirmed');
            $bookingModel->appendAdminNote($bookingId, "Từ chối yêu cầu hủy: " . $adminNote);
            $_SESSION['admin_message'] = 'Đã từ chối yêu cầu hủy.';
        }

        header('Location: ' . route('BookingAdmin.detail', ['id' => $bookingId]));
    }
}