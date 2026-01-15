<?php
require_once __DIR__ . '/../service/StatisticsService.php';

class StatisticsController
{
    private $statisticsService;

    public function __construct()
    {
        $this->statisticsService = new StatisticsService();
    }

    public function index()
    {
        // Lấy danh sách các năm có dữ liệu từ database
        $availableYears = $this->statisticsService->getAvailableYears();

        // Lấy năm từ GET parameter, mặc định là năm đầu tiên có dữ liệu
        $year = isset($_GET['year']) ? (int)$_GET['year'] : ($availableYears[0] ?? date('Y'));

        // Lấy dữ liệu thống kê từ service
        $stats = [
            'totalRevenue' => $this->statisticsService->getTotalRevenue($year),
            'totalBookings' => $this->statisticsService->getTotalBookings($year),
            'totalTours' => $this->statisticsService->getTotalTours(),
            'monthlyRevenue' => $this->statisticsService->getMonthlyRevenue($year),
            'bookingStatus' => $this->statisticsService->getBookingStatus($year),
            'topTours' => $this->statisticsService->getTopTours($year),
            'availableYears' => $availableYears
        ];

        ob_start();
        include __DIR__ . '/../views/admin/ThongKe/Statistics.php';
        $content = ob_get_clean();
        $currentPage = 'Statistics';
        return include __DIR__ . '/../views/admin/admin_layout.php';
    }
}
