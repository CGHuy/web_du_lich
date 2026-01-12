<?php
require_once __DIR__ . '/../models/TourImage.php';
require_once __DIR__ . '/../models/Tour.php';

class TourImageController
{
    private $model;
    private $tourModel;

    public function __construct()
    {
        $this->model = new TourImage();
        $this->tourModel = new Tour();
    }

    // List page for image management
    public function index()
    {
        $all_tours = $this->tourModel->getAll();

        $tours = array_map(function ($tour) {
            $images = $this->model->getImagesByTourIdForListTour($tour['id']);
            $tour['has_images'] = !empty($images);
            return $tour;
        }, $all_tours);

        $currentPage = 'TourImage';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyHinhAnh/QuanLyHinhAnh.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    // Return the form partial for a given tour id
    public function getForm()
    {
        $tour_id = $_GET['tour_id'] ?? null;
        if (!$tour_id) {
            echo "Tour ID không hợp lệ.";
            return;
        }
        $tour = $this->tourModel->getById($tour_id);
        if (!$tour) {
            echo "Tour không tồn tại.";
            return;
        }
        $images = $this->model->getImagesByTourIdForListTour($tour_id);
        include __DIR__ . '/../views/admin/QuanLyHinhAnh/FormHinhAnh.php';
    }

    // Handle upload (simple implementation: move files to public/uploads and save paths)
    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('TourImage.index'));
            return;
        }
        $tour_id = $_POST['tour_id'] ?? null;
        if (!$tour_id) {
            $_SESSION['error_message'] = 'Tour ID không hợp lệ.';
            header('Location: ' . route('TourImage.index'));
            return;
        }
        // If images are uploaded, read their contents and store as data URI in DB
        if (!empty($_FILES['images'])) {
            $files = $_FILES['images'];
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;
                $tmpName = $files['tmp_name'][$i];
                $data = @file_get_contents($tmpName);
                if ($data === false) continue;
                $mime = function_exists('mime_content_type') ? mime_content_type($tmpName) : 'application/octet-stream';
                $dataUri = 'data:' . $mime . ';base64,' . base64_encode($data);
                $this->model->create($tour_id, $dataUri);
            }
        }

        header('Location: ' . route('TourImage.index'));
    }

    // AJAX delete
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false]);
            return;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['success' => false]);
            return;
        }
        // For DB-backed images we don't maintain filesystem files, just delete DB record
        $res = $this->model->delete($id);
        echo json_encode(['success' => (bool)$res]);
    }
}
