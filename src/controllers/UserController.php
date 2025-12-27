<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    
    public function index()
    {
        $userModel = new User();
        $users = $userModel->getAll();
        $currentPage = 'user';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyUser.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }
}