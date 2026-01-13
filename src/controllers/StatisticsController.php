<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/Booking.php';
require_once __DIR__ . '/../../config/database.php';

class StatisticsController
{
    private $tourModel;
    private $bookingModel;
    private $db;
    private $conn;
    private $currentYear;

    public function __construct()
    {
        $this->tourModel = new Tour();
        $this->bookingModel = new Booking();
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        $this->currentYear = date('Y');
    }

    public function index()
    {
        // Lấy năm từ request, mặc định là năm hiện tại
        $selectedYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
        $this->currentYear = $selectedYear;

        // Lấy dữ liệu thống kê
        $stats = [
            'selectedYear' => $selectedYear,
            'availableYears' => $this->getAvailableYears(),
            'totalRevenue' => $this->getTotalRevenue(),
            'totalBookings' => $this->getTotalBookings(),
            'totalTours' => $this->getTotalTours(),
            'monthlyRevenue' => $this->getMonthlyRevenue(),
            'bookingStatus' => $this->getBookingStatus(),
            'topTours' => $this->getTopTours()
        ];

        ob_start();
        include __DIR__ . '/../views/admin/ThongKe/Statistics.php';
        $content = ob_get_clean();
        $currentPage = 'Statistics';
        return include __DIR__ . '/../views/admin/admin_layout.php';
    }

    // Lấy tổng doanh thu theo năm được chọn
    private function getTotalRevenue()
    {
        $sql = "SELECT COALESCE(SUM(b.total_price), 0) as total
                FROM bookings b
                WHERE YEAR(b.created_at) = {$this->currentYear}
                AND b.payment_status = 'paid'
                AND b.status = 'confirmed'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        // Tính trend so với năm trước
        $prevYear = $this->currentYear - 1;
        $prevSql = "SELECT COALESCE(SUM(b.total_price), 0) as total
                    FROM bookings b
                    WHERE YEAR(b.created_at) = {$prevYear}
                    AND b.payment_status = 'paid'
                    AND b.status = 'confirmed'";
        $prevResult = $this->conn->query($prevSql);
        $prevRow = $prevResult->fetch_assoc();

        $trend = $prevRow['total'] > 0 ? round((($row['total'] - $prevRow['total']) / $prevRow['total']) * 100, 1) : 0;
        $status = $trend > 0 ? 'up' : ($trend < 0 ? 'down' : 'neutral');

        return [
            'value' => $row['total'],
            'trend' => $trend,
            'status' => $status
        ];
    }

    // Lấy tổng số booking theo năm được chọn
    private function getTotalBookings()
    {
        $sql = "SELECT COUNT(id) as total
                FROM bookings
                WHERE YEAR(created_at) = {$this->currentYear}
                AND payment_status = 'paid'
                AND status = 'confirmed'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        // Tính trend so với năm trước
        $prevYear = $this->currentYear - 1;
        $prevSql = "SELECT COUNT(id) as total
                    FROM bookings
                    WHERE YEAR(created_at) = {$prevYear}
                    AND payment_status = 'paid'
                    AND status = 'confirmed'";
        $prevResult = $this->conn->query($prevSql);
        $prevRow = $prevResult->fetch_assoc();

        $trend = $prevRow['total'] > 0 ? round((($row['total'] - $prevRow['total']) / $prevRow['total']) * 100, 1) : 0;
        $status = $trend > 0 ? 'up' : ($trend < 0 ? 'down' : 'neutral');

        return [
            'value' => $row['total'],
            'trend' => $trend,
            'status' => $status
        ];
    }

    // Lấy tổng số tour
    private function getTotalTours()
    {
        $sql = "SELECT COUNT(id) as total FROM tours";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return [
            'value' => $row['total'],
            'trend' => 0,
            'status' => 'neutral'
        ];
    }

    // Lấy danh sách năm có sẵn từ database
    private function getAvailableYears()
    {
        $sql = "SELECT DISTINCT YEAR(created_at) as year
                FROM bookings
                ORDER BY year DESC";

        $result = $this->conn->query($sql);
        $years = [];

        while ($row = $result->fetch_assoc()) {
            $years[] = $row['year'];
        }

        // Nếu không có dữ liệu, trả về năm hiện tại
        if (empty($years)) {
            $years[] = date('Y');
        }

        return $years;
    }

    // Xoá getNewCustomers vì không dùng nữa

    // Lấy doanh thu theo tháng
    private function getMonthlyRevenue()
    {
        $sql = "SELECT MONTH(b.created_at) as month, COALESCE(SUM(b.total_price), 0) as revenue
                FROM bookings b
                WHERE YEAR(b.created_at) = {$this->currentYear}
                AND b.payment_status = 'paid'
                AND b.status = 'confirmed'
                GROUP BY MONTH(b.created_at)
                ORDER BY MONTH(b.created_at)";

        $result = $this->conn->query($sql);
        $monthlyData = array_fill(1, 12, 0);

        while ($row = $result->fetch_assoc()) {
            $monthlyData[$row['month']] = $row['revenue'];
        }

        // Chuẩn hóa dữ liệu cho biểu đồ (tính % so với max)
        $maxRevenue = max($monthlyData);
        $maxRevenue = $maxRevenue > 0 ? $maxRevenue : 100;

        $chartData = [];
        foreach ($monthlyData as $month => $revenue) {
            $chartData[] = [
                'month' => $month,
                'value' => (int)$revenue,
                'percentage' => round(($revenue / $maxRevenue) * 100, 2)
            ];
        }

        return $chartData;
    }

    // Lấy trạng thái đơn đặt chỗ
    private function getBookingStatus()
    {
        $sql = "SELECT b.status, COUNT(id) as count
                FROM bookings b
                WHERE YEAR(b.created_at) = {$this->currentYear}
                GROUP BY b.status";

        $result = $this->conn->query($sql);
        $statusData = [
            'confirmed' => 0,
            'pending_cancellation' => 0,
            'cancelled' => 0
        ];

        while ($row = $result->fetch_assoc()) {
            if (isset($statusData[$row['status']])) {
                $statusData[$row['status']] = $row['count'];
            }
        }

        $total = array_sum($statusData);

        return [
            'confirmed' => [
                'count' => $statusData['confirmed'],
                'percentage' => $total > 0 ? round(($statusData['confirmed'] / $total) * 100, 0) : 0,
                'label' => 'Đã xác nhận',
                'color' => '#10b981'
            ],
            'pending_cancellation' => [
                'count' => $statusData['pending_cancellation'],
                'percentage' => $total > 0 ? round(($statusData['pending_cancellation'] / $total) * 100, 0) : 0,
                'label' => 'Chờ hủy',
                'color' => '#f59e0b'
            ],
            'cancelled' => [
                'count' => $statusData['cancelled'],
                'percentage' => $total > 0 ? round(($statusData['cancelled'] / $total) * 100, 0) : 0,
                'label' => 'Đã hủy',
                'color' => '#ef4444'
            ],
            'total' => $total
        ];
    }

    // Lấy top 3 tour được đặt nhiều nhất
    private function getTopTours()
    {
        $sql = "SELECT t.id, t.name, t.tour_code, COUNT(b.id) as booking_count,
                        COALESCE(SUM(b.total_price), 0) as total_revenue,
                        t.cover_image
                FROM tours t
                LEFT JOIN tour_departures td ON t.id = td.tour_id
                LEFT JOIN bookings b ON td.id = b.departure_id 
                           AND YEAR(b.created_at) = {$this->currentYear}
                           AND b.payment_status = 'paid'
                           AND b.status = 'confirmed'
                GROUP BY t.id, t.name, t.tour_code, t.cover_image
                ORDER BY booking_count DESC, total_revenue DESC
                LIMIT 3";

        $result = $this->conn->query($sql);
        $topTours = [];

        while ($row = $result->fetch_assoc()) {
            // Tính trend so với năm trước
            $prevYear = $this->currentYear - 1;
            $prevSql = "SELECT COUNT(b.id) as prev_booking_count
                        FROM tours t
                        LEFT JOIN tour_departures td ON t.id = td.tour_id
                        LEFT JOIN bookings b ON td.id = b.departure_id 
                                   AND YEAR(b.created_at) = {$prevYear}
                                   AND b.payment_status = 'paid'
                                   AND b.status = 'confirmed'
                        WHERE t.id = {$row['id']}
                        GROUP BY t.id";

            $prevResult = $this->conn->query($prevSql);
            $prevRow = $prevResult->fetch_assoc();
            $prevBookingCount = $prevRow['prev_booking_count'] ?? 0;

            // Chỉ tính trend nếu năm trước có dữ liệu
            $trend = null;
            if ($prevBookingCount > 0) {
                $trend = round((($row['booking_count'] - $prevBookingCount) / $prevBookingCount) * 100, 0);
            }

            $topTours[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'code' => $row['tour_code'],
                'bookings' => $row['booking_count'],
                'revenue' => $row['total_revenue'],
                'trend' => $trend,
                'image' => $row['cover_image']
            ];
        }

        return $topTours;
    }
}
