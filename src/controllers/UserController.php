<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;
    private $userId = 1; // cố định

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function edit()
    {
        $user = $this->userModel->getById($this->userId);
        if (!$user) {
            http_response_code(404);
            echo "User không tồn tại";
            return;
        }
        include __DIR__ . '/../views/components/SettingAccount.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('user.edit'));
            return;
        }

        $user = $this->userModel->getById($this->userId);
        if (!$user) {
            http_response_code(404);
            echo "User không tồn tại";
            return;
        }

        $fullname = $_POST['fullname'] ?? $user['fullname'];
        $phone = $_POST['phone'] ?? $user['phone'];
        $email = $_POST['email'] ?? $user['email'];
        $password = $_POST['password'] ?? '';
        if ($password === '') {
            $password = $user['password']; // giữ nguyên nếu không đổi
        }

        $this->userModel->update(
            $this->userId,
            $fullname,
            $phone,
            $email,
            $password,
            $user['role'],
            $user['status']
        );

        header('Location: ' . route('user.edit'));
    }
    public function changePassword()
    {
        include __DIR__ . '/../views/components/ChangePassword.php';
    }
    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('user.changePassword'));
            return;
        }

        $user = $this->userModel->getById($this->userId);
        if (!$user) {
            http_response_code(404);
            echo "User không tồn tại";
            return;
        }

        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if ($currentPassword !== $user['password']) {
            echo "Mật khẩu hiện tại không đúng.";
            return;
        }

        if ($newPassword !== $confirmPassword) {
            echo "Mật khẩu mới và xác nhận mật khẩu không khớp.";
            return;
        }

        $this->userModel->update(
            $this->userId,
            $user['fullname'],
            $user['phone'],
            $user['email'],
            $newPassword,
            $user['role'],
            $user['status']
        );

        header('Location: ' . route('user.changePassword'));
    }
}