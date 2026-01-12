<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/TourService.php';
require_once __DIR__ . '/../models/Service.php';

class TourServiceController {
    private $tourModel;
    private $tourServiceModel;
    private $serviceModel;

    public function __construct() {
        $this->tourModel = new Tour();
        $this->tourServiceModel = new TourService();
        $this->serviceModel = new Service();
    }

    public function index() {
        $all_tours = $this->tourModel->getAll();
        $all_tour_services = $this->tourServiceModel->getAll();

        $tour_ids_with_service = array_fill_keys(array_column($all_tour_services, 'tour_id'), true);

        $tours = array_map(function($tour) use ($tour_ids_with_service) {
            $tour['has_service'] = isset($tour_ids_with_service[$tour['id']]);
            return $tour;
        }, $all_tours);

        $currentPage = 'TourService';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyDichVuTour/QuanLyDichVuTour.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

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

        // Lấy tất cả dịch vụ
        $allServices = $this->serviceModel->getAll();

        // Lấy dịch vụ của tour này
        $tourServices = $this->tourServiceModel->getAll();
        $tourServices = array_filter($tourServices, function($ts) use ($tour_id) {
            return $ts['tour_id'] == $tour_id;
        });

        include __DIR__ . '/../views/admin/QuanLyDichVuTour/FormTourService.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die('Invalid request method');
        }

        $tour_id = isset($_POST['tour_id']) ? intval($_POST['tour_id']) : 0;
        $services = isset($_POST['services']) ? $_POST['services'] : [];

        if ($tour_id > 0) {
            // Xóa dịch vụ cũ của tour này
            $allTourServices = $this->tourServiceModel->getAll();
            foreach ($allTourServices as $ts) {
                if ($ts['tour_id'] == $tour_id) {
                    $this->tourServiceModel->delete($ts['id']);
                }
            }
            
            // Thêm dịch vụ mới
            if (!empty($services)) {
                foreach ($services as $service_id) {
                    $service_id = intval($service_id);
                    if ($service_id > 0) {
                        $this->tourServiceModel->create($tour_id, $service_id);
                    }
                }
            }
        }

        header('Location: ' . route('TourService.index'));
        exit;
    }
}
?>
