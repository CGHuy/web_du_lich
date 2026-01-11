<?php
require_once __DIR__ . '/../models/TourDeparture.php';

class TourDepartureController {
    private $model;

    public function __construct() {
        $this->model = new TourDeparture();
    }

    public function index() {
        $departures = $this->model->getAll();
        $currentPage = 'TourDeparture';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyDiemKhoiHanh/QuanLyDiemKhoiHanh.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tour_id = $_POST['tour_id'];
            $departure_location = $_POST['departure_location'];
            $departure_date = $_POST['departure_date'];
            $price_moving = $_POST['price_moving'];
            $price_moving_child = $_POST['price_moving_child'];
            $seats_total = $_POST['seats_total'];
            $seats_available = $seats_total; // mặc định
            $status = 'open'; // mặc định
            $this->model->create($tour_id, $departure_location, $departure_date, $price_moving, $price_moving_child, $seats_total, $seats_available, $status);
            echo json_encode(['success' => true]);
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $tour_id = $_POST['tour_id'];
            $departure_location = $_POST['departure_location'];
            $departure_date = $_POST['departure_date'];
            $price_moving = $_POST['price_moving'];
            $price_moving_child = $_POST['price_moving_child'];
            $seats_total = $_POST['seats_total'];
            $seats_available = $_POST['seats_available'] ?? $seats_total;
            $status = $_POST['status'] ?? 'open';
            $this->model->update($id, $tour_id, $departure_location, $departure_date, $price_moving, $price_moving_child, $seats_total, $seats_available, $status);
            echo json_encode(['success' => true]);
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->model->delete($id);
            echo json_encode(['success' => true]);
        }
    }

    public function getAddForm() {
        require_once __DIR__ . '/../models/Tour.php';
        $tourModel = new Tour();
        $tours = $tourModel->getAll();
        include __DIR__ . '/../views/admin/QuanLyDiemKhoiHanh/FormAddTourDeparture.php';
    }

    public function getEditForm() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID không hợp lệ.";
            return;
        }
        $departure = $this->model->getById($id);
        if (!$departure) {
            echo "Điểm khởi hành không tồn tại.";
            return;
        }
        require_once __DIR__ . '/../models/Tour.php';
        $tourModel = new Tour();
        $tours = $tourModel->getAll();
        include __DIR__ . '/../views/admin/QuanLyDiemKhoiHanh/FormEditTourDeparture.php';
    }
}