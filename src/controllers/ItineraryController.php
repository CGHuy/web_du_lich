<?php
require_once __DIR__ . '/../models/TourItinerary.php';

class ItineraryController
{
    public function index()
    {
        $itineraryModel = new TourItinerary();
        $itineraries = $itineraryModel->getAll();
        $currentPage = 'itinerary';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyItinerary.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }
}