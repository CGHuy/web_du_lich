<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/TourDeparture.php';

class TourController {
    private $model;
    private $departureModel;

    public function __construct() {
        $this->model = new Tour();
        $this->departureModel = new TourDeparture();
    }

    public function index() {
        $page = $_GET['page'] ?? 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $tours = $this->model->getAllPaginated($offset, $limit);
        $total = $this->model->getTotal();
        $totalPages = ceil($total / $limit);
        $currentPage = 'Tour';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyTour/QuanLyTour.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $name = $_POST['name'];
            $slug = $_POST['slug'];
            $description = $_POST['description'];
            $location = $_POST['location'];
            $region = $_POST['region'];
            $duration = $_POST['duration'];
            $price_default = $_POST['price_default'];
            $price_child = $_POST['price_child'];
            $cover_image = null;
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $cover_image = file_get_contents($_FILES['cover_image']['tmp_name']);
            }
            $this->model->create($name, $slug, $description, $location, $region, $duration, $price_default, $price_child, $cover_image);
            $_SESSION['success_message'] = 'Tour đã được thêm thành công.';
            header('Location: ' . route('Tour.index'));
            exit;
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $id = $_POST['id'];
            $name = $_POST['edit_name'];
            $slug = $_POST['edit_slug'];
            $description = $_POST['edit_description'];
            $location = $_POST['edit_location'];
            $region = $_POST['edit_region'];
            $duration = $_POST['edit_duration'];
            $price_default = $_POST['edit_price_default'];
            $price_child = $_POST['edit_price_child'];
            
            $cover_image = null;
            if (isset($_FILES['edit_cover_image']) && $_FILES['edit_cover_image']['error'] === UPLOAD_ERR_OK) {
                $cover_image = file_get_contents($_FILES['edit_cover_image']['tmp_name']);
            }

            $this->model->update($id, $name, $slug, $description, $location, $region, $duration, $price_default, $price_child, $cover_image);
            $_SESSION['success_message'] = 'Tour đã được cập nhật thành công.';
            header('Location: ' . route('Tour.index'));
            exit;
        }
    }

    public function delete() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_POST['id'];
        
        $departures = $this->departureModel->getByTourIdForBookingTour($id);
        if (!empty($departures)) {
            $_SESSION['error_message'] = 'Không thể xóa tour vì tour này đã có lịch khởi hành. Vui lòng xóa các lịch khởi hành trước.';
            header('Location: ' . route('Tour.index'));
            exit;
        }
        
        $this->model->delete($id);
        $_SESSION['success_message'] = 'Tour đã được xóa thành công.';
        header('Location: ' . route('Tour.index'));
        exit;
    }

    public function getAddForm() {
        include __DIR__ . '/../views/admin/QuanLyTour/FormAddTour.php';
    }

    public function getEditForm() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID tour không hợp lệ.";
            return;
        }
        $tour = $this->model->getById($id);
        if (!$tour) {
            echo "Tour không tồn tại.";
            return;
        }
        include __DIR__ . '/../views/admin/QuanLyTour/FormEditTour.php';
    }
}
