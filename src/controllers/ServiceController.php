<?php
require_once __DIR__ . '/../models/Service.php';

class ServiceController {
    private $model;

    public function __construct() {
        $this->model = new Service();
    }

    public function index() {
        $keyword = $_GET['keyword'] ?? '';

    if ($keyword !== '') {
        $services = $this->model->search($keyword);
    } else {
        $services = $this->model->getAll();
    }
        $currentPage = 'Service';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyDichVu/QuanLyService.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    public function create() {
        // Add is handled via modal on index page; redirect to index
        header('Location: ?controller=Service&action=index');
        exit;
    }

    public function store() {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = (int)($_POST['status'] ?? 0);

        // handle upload
    $this->model->create($name, $slug, $description, $status);


               header('Location: ?controller=Service&action=index');
    }

    public function edit() {
        // Edit is handled via modal on index page; redirect to index
        header('Location: ?controller=Service&action=index');
        exit;
    }

    public function update() {
        $id = (int)($_GET['id'] ?? 0);
        $service = $this->model->getById($id);
        if (!$service) {
            header('Location: ?controller=Service&action=index');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status = (int)($_POST['status'] ?? 0);

        // handle upload
   $this->model->update($id, $name, $slug, $description, $status);
        header('Location: ?controller=Service&action=index');
    }

    public function delete() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            $this->model->delete($id);
        }
        header('Location: ?controller=Service&action=index');
    }
}