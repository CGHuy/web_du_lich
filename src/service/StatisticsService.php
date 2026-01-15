<?php
require_once __DIR__ . '/../../config/database.php';

class StatisticsService
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Tính tăng trưởng giữa 2 năm
     */
    private function calculateTrend($currentValue, $previousValue)
    {
        if ($previousValue == 0) {
            return [
                'trend' => 0,
                'status' => 'neutral'
            ];
        }

        $trend = round((($currentValue - $previousValue) / $previousValue) * 100, 1);
        $status = $trend > 0 ? 'up' : ($trend < 0 ? 'down' : 'neutral');

        return [
            'trend' => $trend,
            'status' => $status
        ];
    }

    /**
     * Lấy tổng doanh thu
     */
    public function getTotalRevenue($year = null)
    {
        $year = $year ?? date('Y');
        $sql = "SELECT COALESCE(SUM(b.total_price), 0) as total
                FROM bookings b
                WHERE YEAR(b.created_at) = {$year}
                AND b.payment_status = 'paid'
                AND b.status = 'confirmed'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $currentValue = $row['total'];

        // Lấy dữ liệu năm trước để tính trend
        $previousYear = $year - 1;
        $sqlPrev = "SELECT COALESCE(SUM(b.total_price), 0) as total
                    FROM bookings b
                    WHERE YEAR(b.created_at) = {$previousYear}
                    AND b.payment_status = 'paid'
                    AND b.status = 'confirmed'";
        $resultPrev = $this->conn->query($sqlPrev);
        $rowPrev = $resultPrev->fetch_assoc();
        $previousValue = $rowPrev['total'];

        $trendData = $this->calculateTrend($currentValue, $previousValue);

        return [
            'value' => $currentValue,
            'trend' => $trendData['trend'],
            'status' => $trendData['status']
        ];
    }

    /**
     * Lấy tổng số booking
     */
    public function getTotalBookings($year = null)
    {
        $year = $year ?? date('Y');
        $sql = "SELECT COUNT(id) as total
                FROM bookings
                WHERE YEAR(created_at) = {$year}
                AND payment_status = 'paid'
                AND status = 'confirmed'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        $currentValue = $row['total'];

        // Lấy dữ liệu năm trước để tính trend
        $previousYear = $year - 1;
        $sqlPrev = "SELECT COUNT(id) as total
                    FROM bookings
                    WHERE YEAR(created_at) = {$previousYear}
                    AND payment_status = 'paid'
                    AND status = 'confirmed'";
        $resultPrev = $this->conn->query($sqlPrev);
        $rowPrev = $resultPrev->fetch_assoc();
        $previousValue = $rowPrev['total'];

        $trendData = $this->calculateTrend($currentValue, $previousValue);

        return [
            'value' => $currentValue,
            'trend' => $trendData['trend'],
            'status' => $trendData['status']
        ];
    }

    /**
     * Lấy tổng số tour
     */
    public function getTotalTours()
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

    /**
     * Lấy doanh thu theo tháng
     */
    public function getMonthlyRevenue($year = null)
    {
        $year = $year ?? date('Y');
        $sql = "SELECT MONTH(b.created_at) as month, COALESCE(SUM(b.total_price), 0) as revenue
                FROM bookings b
                WHERE YEAR(b.created_at) = {$year}
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

    /**
     * Lấy trạng thái đơn đặt chỗ
     */
    public function getBookingStatus($year = null)
    {
        $year = $year ?? date('Y');
        $sql = "SELECT b.status, COUNT(id) as count
                FROM bookings b
                WHERE YEAR(b.created_at) = {$year}
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

    /**
     * Lấy top 3 tour được đặt nhiều nhất
     */
    public function getTopTours($year = null)
    {
        $year = $year ?? date('Y');
        $sql = "SELECT t.id, t.name, t.tour_code, COUNT(b.id) as booking_count,
                        COALESCE(SUM(b.total_price), 0) as total_revenue,
                        t.cover_image
                FROM tours t
                LEFT JOIN tour_departures td ON t.id = td.tour_id
                LEFT JOIN bookings b ON td.id = b.departure_id 
                           AND YEAR(b.created_at) = {$year}
                           AND b.payment_status = 'paid'
                           AND b.status = 'confirmed'
                GROUP BY t.id, t.name, t.tour_code, t.cover_image
                ORDER BY booking_count DESC, total_revenue DESC
                LIMIT 3";

        $result = $this->conn->query($sql);
        $topTours = [];

        $previousYear = $year - 1;

        while ($row = $result->fetch_assoc()) {
            // Lấy số booking của năm trước để tính trend
            $sqlPrevTour = "SELECT COUNT(b.id) as booking_count
                            FROM tours t
                            LEFT JOIN tour_departures td ON t.id = td.tour_id
                            LEFT JOIN bookings b ON td.id = b.departure_id 
                                       AND YEAR(b.created_at) = {$previousYear}
                                       AND b.payment_status = 'paid'
                                       AND b.status = 'confirmed'
                            WHERE t.id = {$row['id']}";
            $resultPrevTour = $this->conn->query($sqlPrevTour);
            $rowPrevTour = $resultPrevTour->fetch_assoc();
            $previousBookings = $rowPrevTour['booking_count'] ?? 0;

            // Tính trend
            $trendData = $this->calculateTrend($row['booking_count'], $previousBookings);

            $topTours[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'code' => $row['tour_code'],
                'bookings' => $row['booking_count'],
                'revenue' => $row['total_revenue'],
                'trend' => $trendData['trend'],
                'image' => $row['cover_image']
            ];
        }

        return $topTours;
    }

    /**
     * Lấy danh sách các năm có dữ liệu từ database
     */
    public function getAvailableYears()
    {
        $sql = "SELECT DISTINCT YEAR(created_at) as year 
                FROM bookings 
                ORDER BY year DESC";

        $result = $this->conn->query($sql);
        $years = [];

        while ($row = $result->fetch_assoc()) {
            if ($row['year']) {
                $years[] = $row['year'];
            }
        }

        return $years;
    }
}
