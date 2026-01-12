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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $slug = $_POST['slug'];
            $description = $_POST['description'];
            $status = (int)$_POST['status'];
            $this->model->create($name, $slug, $description, $status);
            header('Location: ?controller=Service&action=index');
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $slug = $_POST['slug'];
            $description = $_POST['description'];
            $status = (int)$_POST['status'];
            $this->model->update($id, $name, $slug, $description, $status);
            header('Location: ?controller=Service&action=index');
        }
    }

    public function delete() {
        $id = $_POST['id'];
        $this->model->delete($id);
        header('Location: ?controller=Service&action=index');
    }

    public function getAddForm() {
        include __DIR__ . '/../views/admin/QuanLyDichVu/FormAddService.php';
    }

    public function getEditForm() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID dịch vụ không hợp lệ.";
            return;
        }
        $service = $this->model->getById($id);
        if (!$service) {
            echo "Dịch vụ không tồn tại.";
            return;
        }
        include __DIR__ . '/../views/admin/QuanLyDichVu/FormEditService.php';
    }
}