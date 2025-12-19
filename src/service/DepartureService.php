<?php
require_once __DIR__ . '/../models/TourDeparture.php';
class DepartureService
{
    private $departureModel;
    public function __construct()
    {
        $this->departureModel = new TourDeparture();
    }
    // Lấy price_moving theo id lịch khởi hành
    public function getPriceMovingById($departure_id)
    {
        $dep = $this->departureModel->getById($departure_id);
        return $dep ? $dep['price_moving'] : null;
    }
}
