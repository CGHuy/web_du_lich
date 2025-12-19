<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/TourImage.php';
require_once __DIR__ . '/../models/TourDeparture.php';
class BookingTourController
{
    private $tourModel;
    private $tour_departureModel;

    public function __construct()
    {
        $this->tourModel = new Tour();
        $this->tour_departureModel = new TourDeparture();
    }

    public function index()
    {
        $tour = null;
        $departures = [];
        if (isset($_GET['tour_id'])) {
            $tour = $this->tourModel->getById($_GET['tour_id']);
            if (!empty($tour['id'])) {
                $departures = $this->tour_departureModel->getByTourIdForBookingTour($tour['id']);
            }
        }
        return include __DIR__ . '/../views/components/BookingTour.php';
    }
}