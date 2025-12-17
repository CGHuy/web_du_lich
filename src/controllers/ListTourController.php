<?php
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../service/ListTourService.php';

class ListTourController
{
    private $tourModel;
    private $listTourService;

    public function __construct()
    {
        $this->tourModel = new Tour();
        $this->listTourService = new ListTourService();
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
}