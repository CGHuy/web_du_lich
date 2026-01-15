<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/TourImage.php';
require_once __DIR__ . '/../models/TourDeparture.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Booking.php';
class BookingTourController
{
    private $tourModel;
    private $tour_departureModel;
    private $bookingModel;
    private $userModel;

    public function __construct()
    {
        $this->tourModel = new Tour();
        $this->tour_departureModel = new TourDeparture();
        $this->userModel = new User();
        $this->bookingModel = new Booking();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $tour = null;
        $departures = [];
        $userInfo = null;
        if (!empty($_SESSION['user_id'])) {
            $userInfo = $this->userModel->getById($_SESSION['user_id']);
        }
        if (isset($_GET['tour_id'])) {
            $tour = $this->tourModel->getById($_GET['tour_id']);
            if (!empty($tour['id'])) {
                $allDepartures = $this->tour_departureModel->getByTourId($tour['id']);
                // Lọc chỉ lấy những tour departure có ngày khởi hành >= ngày hôm nay
                $today = date('Y-m-d');
                foreach ($allDepartures as $dep) {
                    if ($dep['departure_date'] >= $today) {
                        $departures[] = $dep;
                    }
                }
            }
        }
        // Truyền $userInfo sang view
        return include __DIR__ . '/../views/components/BookingTour.php';
    }


    public function payment()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $departure_id = $_POST['departure_id'];
        $adults = (int) $_POST['adults'];
        $children = (int) $_POST['children'];
        $tour_id = $_POST['tour_id'];

        $tour = $this->tourModel->getById($tour_id);
        $departure = $this->tour_departureModel->getById($departure_id);

        // Sử dụng method calculateTotalPrice từ Booking model
        $total_price = $this->bookingModel->calculateTotalPrice($adults, $children, $tour_id, $departure_id);

        // Tính chi tiết từng loại chi phí để hiển thị
        $adults_cost = $adults * $tour['price_default'];
        $children_cost = $children * $tour['price_child'];
        $moving_adults = $adults * $departure['price_moving'];
        $moving_children = $children * $departure['price_moving_child'];
        $moving_total = $moving_adults + $moving_children;
        $total_quantity = $adults + $children;

        $contact_name = $_POST['contact_name'];
        $contact_phone = $_POST['contact_phone'];
        $contact_email = $_POST['contact_email'];
        $note = $_POST['note'];

        return include __DIR__ . '/../views/components/Payment.php';
    }

    public function confirmPayment()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $user_id = $_SESSION['user_id'];
        $departure_id = $_POST['departure_id'];
        $adults = isset($_POST['adults']) ? (int) $_POST['adults'] : 1;
        $children = isset($_POST['children']) ? (int) $_POST['children'] : 0;
        $contact_name = $_POST['contact_name'];
        $contact_phone = $_POST['contact_phone'];
        $contact_email = $_POST['contact_email'];
        $note = $_POST['note'];
        $tour_id = $_POST['tour_id'] ?? 0;

        // Sử dụng method calculateTotalPrice từ Booking model để tính tổng giá
        $total_quantity = $adults + $children;
        $total_price = $this->bookingModel->calculateTotalPrice($adults, $children, $tour_id, $departure_id);

        // Tạo booking
        $this->bookingModel->create(
            $user_id,
            $departure_id,
            $adults,
            $children,
            $total_price,
            'paid',
            'confirmed',
            $contact_name,
            $contact_phone,
            $contact_email,
            $note
        );

        // Cập nhật departure 
        $this->tour_departureModel->decreaseSeatsAvailable($departure_id, $total_quantity);

        // Lưu thông báo thành công và redirect
        $_SESSION['booking_success'] = true;
        $_SESSION['booking_message'] = 'Đặt tour thành công!';
        header('Location: ' . route('settinguser.bookingHistory'));
        exit;
    }
}
