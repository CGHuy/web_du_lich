<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/TourItinerary.php';
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Service.php';

class AdminController {

    public function tour() {
        $tourModel = new Tour();
        $tours = $tourModel->getAll();
        include __DIR__ . '/../views/components/QuanLyTour.php';
    }

    public function itinerary() {
        $itineraryModel = new TourItinerary();
        $itineraries = $itineraryModel->getAll();
        include __DIR__ . '/../views/components/QuanLyLichTrinh.php'; // Giả sử tạo file này
    }

    public function booking() {
        $bookingModel = new Booking();
        $bookings = $bookingModel->getAll();
        include __DIR__ . '/../views/components/QuanLyBooking.php'; // Giả sử
    }

    public function user() {
        $userModel = new User();
        $users = $userModel->getAll();
        include __DIR__ . '/../views/components/QuanLyUser.php'; // Giả sử
    }

    public function service() {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();
        include __DIR__ . '/../views/components/QuanLyService.php'; // Giả sử
    }
}
?>
