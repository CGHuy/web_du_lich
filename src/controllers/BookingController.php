<?php
require_once __DIR__ . '/../models/Booking.php';

class BookingController
{
    public function index()
    {
        $bookingModel = new Booking();
        $bookings = $bookingModel->getAll();
        $currentPage = 'booking';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyBooking.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }
}