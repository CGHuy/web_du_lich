<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/TourItinerary.php';
require_once __DIR__ . '/../models/TourService.php';
require_once __DIR__ . '/../models/Service.php';

class ListTourService
{
    private $tourModel;

    public function __construct()
    {
        $this->tourModel = new Tour();
    }



    /**
     * Lấy danh sách dịch vụ theo tour_id (join Service và TourService)
     */
    public function getServicesByTourId($tour_id)
    {
        $tourServiceModel = new TourService();
        $serviceModel = new Service();
        $allTourServices = $tourServiceModel->getAll();
        $allServices = $serviceModel->getAll();
        $serviceIds = [];
        foreach ($allTourServices as $item) {
            if (isset($item['tour_id']) && $item['tour_id'] == $tour_id) {
                $serviceIds[] = $item['service_id'];
            }
        }
        $result = [];
        foreach ($allServices as $service) {
            if (in_array($service['id'], $serviceIds)) {
                $result[] = $service;
            }
        }
        return $result;
    }

    /**
     * Lọc tour theo region, duration, services, search
     * $services: mảng id dịch vụ (int)
     */
    public function filterTours($region = '', $durationRange = '', $services = [], $search = '', $minPrice = null, $maxPrice = null, $sort = '')
    {
        $params = [];
        $where = [];
        $join = '';
        $having = '';
        $group = '';
        if ($region !== '') {
            $where[] = 't.region = ?';
            $params[] = $region;
        }
        if ($search !== '') {
            $where[] = 't.name LIKE ?';
            $params[] = '%' . $search . '%';
        }
        if ($minPrice !== null) {
            $where[] = 't.price_default >= ?';
            $params[] = $minPrice;
        }
        if ($maxPrice !== null) {
            $where[] = 't.price_default <= ?';
            $params[] = $maxPrice;
        }
        if (!empty($services)) {
            $count = count($services);
            $join .= ' INNER JOIN tour_services ts ON t.id = ts.tour_id ';
            $where[] = 'ts.service_id IN (' . implode(',', array_fill(0, $count, '?')) . ')';
            $params = array_merge($params, $services);
            $group = ' GROUP BY t.id ';
            $having = ' HAVING COUNT(DISTINCT ts.service_id) = ' . $count;
        }
        $sql = 'SELECT t.* FROM tours t ' . $join;
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= $group . $having;
        // Sắp xếp theo giá nếu có
        if ($sort === 'price_asc') {
            $sql .= ' ORDER BY t.price_default ASC';
        } elseif ($sort === 'price_desc') {
            $sql .= ' ORDER BY t.price_default DESC';
        }
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare($sql);
        if ($params) {
            $types = '';
            foreach ($params as $p) {
                $types .= is_int($p) ? 'i' : 's';
            }
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $tours = [];
        while ($row = $result->fetch_assoc()) {
            $tours[] = $row;
        }
        return $this->filterByDuration($tours, $durationRange);
    }

    /**
     * Lọc tour theo duration (private, dùng chung)
     */
    private function filterByDuration($tours, $durationRange)
    {
        if ($durationRange === '' || $durationRange === null) {
            return $tours;
        }
        $filtered = [];
        foreach ($tours as $tour) {
            $days = null;
            if (preg_match('/(\d+)\s*ngày/i', $tour['duration'], $matches)) {
                $days = (int) $matches[1];
            } elseif (preg_match('/(\d+)/', $tour['duration'], $matches)) {
                $days = (int) $matches[1];
            }
            if ($days !== null) {
                if (
                    ($durationRange === '1-3' && $days >= 1 && $days <= 3) ||
                    ($durationRange === '4+' && $days >= 4)
                ) {
                    $filtered[] = $tour;
                }
            }
        }
        return $filtered;
    }
}

