<?php
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../service/ListTourService.php';
require_once __DIR__ . '/../models/TourImage.php';
require_once __DIR__ . '/../models/TourItinerary.php';
require_once __DIR__ . '/../models/Review.php';
require_once __DIR__ . '/../models/Wishlist.php';


class ListTourController
{
    private $tourModel;
    private $listTourService;
    private $tourImageModel;
    private $tourItineraryModel;
    private $reviewModel;
    private $wishlistModel;

    public function __construct()
    {
        $this->tourModel = new Tour();
        $this->listTourService = new ListTourService();
        $this->tourImageModel = new TourImage();
        $this->tourItineraryModel = new TourItinerary();
        $this->reviewModel = new Review();
        $this->wishlistModel = new Wishlist();
    }

    public function index()
    {
        $region = isset($_GET['region']) && $_GET['region'] !== '' ? trim($_GET['region']) : '';
        $durationRange = isset($_GET['duration_range']) && $_GET['duration_range'] !== '' ? $_GET['duration_range'] : '';
        $services = isset($_GET['services']) && is_array($_GET['services']) ? array_map('intval', $_GET['services']) : [];
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $minPrice = isset($_GET['min_price']) ? (int) $_GET['min_price'] : null;
        $maxPrice = isset($_GET['max_price']) ? (int) $_GET['max_price'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

        $serviceModel = new Service();
        $allServices = $serviceModel->getAll();

        if ($region !== '' || $durationRange !== '' || !empty($services) || $search !== '' || $minPrice !== null || $maxPrice !== null || $sort !== '') {
            $allTours = $this->listTourService->filterTours($region, $durationRange, $services, $search, $minPrice, $maxPrice, $sort);
        } else {
            $allTours = $this->tourModel->getAll();
        }

        $perPage = 6;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
        $totalTours = count($allTours);
        $totalPages = (int) ceil($totalTours / $perPage);
        $offset = ($page - 1) * $perPage;
        $tours = array_slice($allTours, $offset, $perPage);
        return include __DIR__ . '/../views/components/ListTour.php';
    }

    public function details($id = null)
    {
        if ($id === null && isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $tour = $this->tourModel->getById($id);
        // Lấy lịch trình của tour trực tiếp từ model
        $tourItineraries = $this->tourItineraryModel->getByTourIdForListTour($id);
        // Lấy dịch vụ của tour qua service
        $tourServices = $this->listTourService->getServicesByTourId($id);
        // Lấy review của tour (join user) từ service
        $tourReviews = $this->listTourService->getReviewsWithUserByTourId($id);
        // Lấy ảnh của tour trực tiếp từ model
        $tourImages = $this->tourImageModel->getImagesByTourIdForListTour($id);
        // Chỉ lấy ảnh từ bảng tour_images, không lấy cover_image
        if (!$tour) {
            header("HTTP/1.0 404 Not Found");
            echo "Tour not found";
            exit;
        }
        return include __DIR__ . '/../views/components/DetailTour.php';
    }

    public function addToWishlist()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $userId = $_SESSION['user_id'] ?? null;
        $tour_id = isset($_POST['tour_id']) ? (int) $_POST['tour_id'] : 0;
        $message = '';
        $success = false;
        if (!$userId) {
            $message = 'Bạn cần đăng nhập để thêm vào yêu thích.';
        } elseif (!$tour_id) {
            $message = 'Thiếu thông tin tour.';
        } else {
            $exist = $this->wishlistModel->findWishlistForFormByUserIdAndTourId($userId, $tour_id);
            if ($exist) {
                $message = 'Tour đã có trong danh sách yêu thích.';
            } else {
                $this->wishlistModel->create($userId, $tour_id);
                $message = 'Đã thêm vào danh sách yêu thích!';
                $success = true;
            }
        }
        // Redirect về lại trang chi tiết tour, truyền thông báo qua query string
        $redirectUrl = route('ListTour.details', ['id' => $tour_id, 'wishlist_message' => urlencode($message), 'wishlist_success' => $success ? '1' : '0']);
        header('Location: ' . $redirectUrl);
        exit;
    }
}