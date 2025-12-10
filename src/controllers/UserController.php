<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = $this->userModel->getAllUsers(); //Lấy hết danh sách người dùng
        include __DIR__ . '/../views/user_list.php';
    }

    // Hiển thị thông tin một người dùng
    public function show($id)
    {
        $user = $this->userModel->getUserById($id);
        include __DIR__ . '/../views/user_detail.php';
    }

    // Xử lý tạo người dùng mới
    public function create($name, $email)
    {
        if (empty($name) || empty($email)) {
            echo "Tên và email không được để trống!";
            return;
        }
        $result = $this->userModel->createUser($name, $email);
        header("Location: /index.php?controller=user&action=index");
    }

    // Xử lý cập nhật người dùng
    public function update($id, $name, $email)
    {
        if (empty($id) || empty($name) || empty($email)) {
            echo "Thiếu thông tin cập nhật!";
            return;
        }
        $result = $this->userModel->updateUser($id, $name, $email);
        header("Location: /index.php?controller=user&action=index");
    }

    // Xử lý xóa người dùng
    public function delete($id)
    {
        if (empty($id)) {
            echo "Thiếu thông tin xóa!";
            return;
        }
        $result = $this->userModel->deleteUser($id);
        header("Location: /index.php?controller=user&action=index");
    }
}
?>