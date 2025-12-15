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
        include __DIR__ . '/../views/components/QuanLyLichTrinh.php';
    }

    public function booking() {
        $bookingModel = new Booking();
        $bookings = $bookingModel->getAll();
        include __DIR__ . '/../views/components/QuanLyBooking.php';
    }

    public function user() {
        $userModel = new User();
        $users = $userModel->getAll();
        include __DIR__ . '/../views/components/QuanLyUser.php';
    }

    public function service() {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();
        include __DIR__ . '/../views/components/QuanLyService.php';
    }

    public function storeTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourModel = new Tour();
            $name = $_POST['name'] ?? '';
            $slug = $_POST['slug'] ?? '';
            $description = $_POST['description'] ?? '';
            $location = $_POST['location'] ?? '';
            $region = $_POST['region'] ?? '';
            $duration = $_POST['duration'] ?? 0;
            $price_default = $_POST['price_default'] ?? 0;
            $cover_image = null;
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $cover_image = file_get_contents($_FILES['cover_image']['tmp_name']);
            }
            $tourModel->create($name, $slug, $description, $location, $region, $duration, $price_default, $cover_image);
            header('Location: ?controller=AdminController&action=tour');
            exit;
        }
    }

    public function updateTour() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourModel = new Tour();
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $slug = $_POST['slug'] ?? '';
            $description = $_POST['description'] ?? '';
            $location = $_POST['location'] ?? '';
            $region = $_POST['region'] ?? '';
            $duration = $_POST['duration'] ?? 0;
            $price_default = $_POST['price_default'] ?? 0;
            $cover_image = null;
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $cover_image = file_get_contents($_FILES['cover_image']['tmp_name']);
            }
            $tourModel->update($id, $name, $slug, $description, $location, $region, $duration, $price_default, $cover_image);
            header('Location: ?controller=AdminController&action=tour');
            exit;
        }
    }

    public function deleteTour() {
        $id = $_GET['id'] ?? 0;
        $tourModel = new Tour();
        $tourModel->delete($id);
        header('Location: ?controller=AdminController&action=tour');
        exit;
    }

    public function getTour() {
        $id = $_GET['id'] ?? 0;
        $tourModel = new Tour();
        $tour = $tourModel->getById($id);
        header('Content-Type: application/json');
        echo json_encode($tour);
        exit;
    }
}
?>
