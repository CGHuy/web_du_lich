<?php
require_once __DIR__ . '/../models/Service.php';

class ServiceController {   
    private $model;

    public function __construct() {
        $this->model = new Service();
    }

    public function index() {
        $services = $this->model->getAll();
        $currentPage = 'service';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyService.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }
}