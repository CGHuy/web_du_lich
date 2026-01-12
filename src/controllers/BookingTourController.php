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
                $departures = $this->tour_departureModel->getByTourIdForBookingTour($tour['id']);
            }
        }
        // Truyền $userInfo sang view
        return include __DIR__ . '/../views/components/BookingTour.php';
    }

    public function book()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $user_id = $_SESSION['user_id'];
        $departure_id = $_POST['departure_id'];
        $quantity = $_POST['quantity'];
        $contact_name = $_POST['contact_name'];
        $contact_phone = $_POST['contact_phone'];
        $contact_email = $_POST['contact_email'];
        $note = $_POST['note'];
        $tour_id = $_POST['tour_id'] ?? 0;

        // Lấy thông tin tour và departure để tính giá
        $tour = null;
        if (isset($_POST['tour_id'])) {
            $tour = $this->tourModel->getById($_POST['tour_id']);
        }
        $departure = $this->tour_departureModel->getById($departure_id);
        $tour_price = $tour['price_default'] ?? 0;
        $moving_price = $departure['price_moving'] ?? 0;
        $total_price = ($tour_price + $moving_price) * $quantity;

        // Tạo booking (tạm gán tất cả là người lớn; trẻ em = 0)
        $adults = max(1, (int) $quantity);
        $children = 0;
        $this->bookingModel->create(
            $user_id,
            $departure_id,
            $adults,
            $children,
            $total_price,
            'unpaid',
            'confirmed',
            $contact_name,
            $contact_phone,
            $contact_email,
            $note
        );

        //Cập nhật departure 
        $this->tour_departureModel->decreaseSeatsAvailable($departure_id, $adults);

        // Lưu thông báo thành công và redirect
        $_SESSION['booking_success'] = true;
        $_SESSION['booking_message'] = 'Đặt tour thành công!';
        header('Location: ' . route('settinguser.bookingHistory'));
        exit;
    }

}