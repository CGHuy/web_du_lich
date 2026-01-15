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
        // Lấy trạng thái lọc và từ khóa tìm kiếm nếu có
        $status = $_REQUEST['sort'] ?? '';
        $search = trim((string) ($_REQUEST['search'] ?? ''));

        // Lấy tất cả bookings (không phân trang) để hiển thị trong ô cuộn dọc, có hỗ trợ tìm kiếm
        $bookings = $this->bookingService->getAll($status, $search);

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

            $bookingModel->updateStatus($bookingId, 'cancelled');
            $bookingModel->updatePaymentStatus($bookingId, 'refunded');

            // Thông báo xác nhận phê duyệt hoàn tiền thành công
            $_SESSION['admin_message'] = 'Phê duyệt hoàn tiền thành công! Số tiền hoàn: ' . number_format($refundAmount, 0, ',', '.') . 'đ';

            error_log("BookingAdmin: set admin_message for booking {$bookingId} with amount {$refundAmount}");
        } elseif ($action === 'deny') {

            $bookingModel->updateStatus($bookingId, 'confirmed');
            $_SESSION['admin_message'] = 'Đã từ chối yêu cầu hủy.';
        }

        header('Location: ' . route('BookingAdmin.detail', ['id' => $bookingId]));
    }


}