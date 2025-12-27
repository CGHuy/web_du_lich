<?php
require_once __DIR__ . '/../models/TourItinerary.php';
require_once __DIR__ . '/../models/Tour.php';

class ItineraryController {
    private $itineraryModel;
    private $tourModel;

    public function __construct() {
        $this->itineraryModel = new TourItinerary();
        $this->tourModel = new Tour();
    }

    public function index() {
        $all_tours = $this->tourModel->getAll();
        $all_itineraries = $this->itineraryModel->getAll();

        $tour_ids_with_itinerary = array_fill_keys(array_column($all_itineraries, 'tour_id'), true);

        $tours = array_map(function($tour) use ($tour_ids_with_itinerary) {
            $tour['has_itinerary'] = isset($tour_ids_with_itinerary[$tour['id']]);
            return $tour;
        }, $all_tours);

        $currentPage = 'itinerary';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyItinerary.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    // trả về HTML form để load vào modal
    public function getForm() {
        $tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;

        if ($tour_id === 0) {
            echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Tour ID không hợp lệ!</div>';
            return;
        }

        $tour = $this->tourModel->getById($tour_id);
        if (!$tour) {
            echo '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Không tìm thấy tour!</div>';
            return;
        }

        // Lấy itineraries từ database
        $itineraries = $this->itineraryModel->getByTourId($tour_id);

        // Include view để render HTML form
        include __DIR__ . '/../views/admin/FormItinerary.php';
    }

    /**
     * Trang chỉnh sửa lịch trình (dạng full page - ít dùng)
     */
    public function edit() {
        $tour_id = isset($_GET['tour_id']) ? intval($_GET['tour_id']) : 0;
        $layout = isset($_GET['layout']) ? $_GET['layout'] : 'full';

        if ($tour_id === 0) {
            die('Invalid Tour ID');
        }

        $tour = $this->tourModel->getById($tour_id);
        if (!$tour) {
            die('Tour not found');
        }

        $itineraries = $this->itineraryModel->getByTourId($tour_id);

        // Nếu layout là 'bare', chỉ render view của form
        if ($layout === 'bare') {
            include __DIR__ . '/../views/admin/ChinhSuaItinerary.php';
        } else {
            // Render với layout admin đầy đủ
            $currentPage = 'itinerary';
            ob_start();
            include __DIR__ . '/../views/admin/ChinhSuaItinerary.php';
            $content = ob_get_clean();
            include __DIR__ . '/../views/admin/admin_layout.php';
        }
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die('Invalid request method');
        }

        $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : 0;
        $days = isset($_POST['days']) ? $_POST['days'] : [];

        if ($tour_id > 0) {
            // Xóa itineraries cũ
            $this->itineraryModel->deleteByTourId($tour_id);
            
            // Thêm itineraries mới
            if (!empty($days)) {
                foreach ($days as $day) {
                    $description = isset($day['description']) ? trim($day['description']) : '';
                    $day_number = isset($day['day_number']) ? intval($day['day_number']) : 1;
                    
                    // Bỏ qua nếu description trống
                    if (empty($description)) {
                        continue;
                    }
                    
                    // Lưu vào database
                    $this->itineraryModel->create(
                        $tour_id,
                        $day_number,
                        $description
                    );
                }
            }
        }
        
        // Redirect về trang quản lý itinerary
        header('Location: index.php?controller=itinerary&action=index');
        exit;
    }
}