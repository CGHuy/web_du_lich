<?php
require_once __DIR__ . '/../models/Tour.php';

class TourController {
    private $model;

    public function __construct() {
        $this->model = new Tour();
    }

    public function index() {
        $tours = $this->model->getAll();
        $currentPage = 'Tour';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyTour/QuanLyTour.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            header('Location: ' . route('Tour.index'));
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            header('Location: ' . route('Tour.index'));
        }
    }

    public function delete() {
        $id = $_POST['id'];
        $this->model->delete($id);
        header('Location: ' . route('Tour.index'));
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
