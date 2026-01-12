<?php
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $users = $this->model->getAll();
        $currentPage = 'user';
        ob_start();
        include __DIR__ . '/../views/admin/QuanlyUser/QuanLyUser.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'customer';

            // Validate phone format
            if (!preg_match('/^0[0-9]{9}$/', $phone)) {
                $_SESSION['error_message'] = 'Số điện thoại không hợp lệ';
                header('Location: ' . route('user.index'));
                return;
            }

            // Check email duplicate
            $conn = $this->model->getConnection();
            $stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $_SESSION['error_message'] = 'Email này đã được đăng ký';
                header('Location: ' . route('user.index'));
                return;
            }

            // Check phone duplicate
            $stmt = $conn->prepare('SELECT id FROM users WHERE phone = ? LIMIT 1');
            $stmt->bind_param('s', $phone);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $_SESSION['error_message'] = 'Số điện thoại này đã được đăng ký';
                header('Location: ' . route('user.index'));
                return;
            }

            try {
                $this->model->create($fullname, $phone, $email, $password, $role);
                $_SESSION['success_message'] = 'Tạo user thành công!';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Lỗi tạo user: ' . $e->getMessage();
            }
            header('Location: ' . route('user.index'));
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $password = $_POST['password'] ?? null;
            $role = $_POST['role'] ?? 'customer';

            // Validate phone format
            if (!preg_match('/^0[0-9]{9}$/', $phone)) {
                $_SESSION['error_message'] = 'Số điện thoại không hợp lệ';
                header('Location: ' . route('user.index'));
                return;
            }

            // Check email duplicate (exclude current user)
            $conn = $this->model->getConnection();
            $stmt = $conn->prepare('SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1');
            $stmt->bind_param('si', $email, $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $_SESSION['error_message'] = 'Email này đã được đăng ký';
                header('Location: ' . route('user.index'));
                return;
            }

            // Check phone duplicate (exclude current user)
            $stmt = $conn->prepare('SELECT id FROM users WHERE phone = ? AND id != ? LIMIT 1');
            $stmt->bind_param('si', $phone, $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows > 0) {
                $_SESSION['error_message'] = 'Số điện thoại này đã được đăng ký';
                header('Location: ' . route('user.index'));
                return;
            }

            // If password is empty, keep the old one
            if (empty($password)) {
                $user = $this->model->getById($id);
                $password = $user['password'];
            }

            try {
                $this->model->update($id, $fullname, $phone, $email, $password, $role, 1);
                $_SESSION['success_message'] = 'Cập nhật user thành công!';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Lỗi cập nhật user: ' . $e->getMessage();
            }
            header('Location: ' . route('user.index'));
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            // Server-side check: do not delete if user has bookings
            $count = $this->model->countBookings($id);
            if ($count > 0) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['error_message'] = 'Không thể xóa user vì user đang có ' . $count . ' booking.';
                header('Location: ' . route('user.index'));
                return;
            }

            $this->model->delete($id);
            header('Location: ' . route('user.index'));
        }
    }

    // AJAX: check if user has bookings
    public function checkBookings()
    {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo json_encode(['success' => false, 'count' => 0]);
            return;
        }
        $count = $this->model->countBookings($id);
        echo json_encode(['success' => true, 'count' => $count, 'hasBookings' => $count > 0]);
    }

    public function getAddForm()
    {
        include __DIR__ . '/../views/admin/QuanlyUser/FormAddUser.php';
    }

    public function getEditForm()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID user không hợp lệ.";
            return;
        }
        $user = $this->model->getById($id);
        if (!$user) {
            echo "User không tồn tại.";
            return;
        }
        include __DIR__ . '/../views/admin/QuanlyUser/FormEditUser.php';
    }

    public function checkDuplicate()
    {
        header('Content-Type: application/json');
        $field = $_GET['field'] ?? null; // 'email' or 'phone'
        $value = $_GET['value'] ?? null;
        $excludeId = $_GET['excludeId'] ?? null; // For edit mode, exclude current user

        if (!$field || !$value) {
            echo json_encode(['exists' => false]);
            return;
        }

        $db = new \mysqli('localhost', 'root', '', 'db_web_du_lich');
        if ($field === 'email') {
            $stmt = $db->prepare('SELECT id FROM users WHERE email = ? AND id != ? LIMIT 1');
        } else if ($field === 'phone') {
            $stmt = $db->prepare('SELECT id FROM users WHERE phone = ? AND id != ? LIMIT 1');
        } else {
            echo json_encode(['exists' => false]);
            return;
        }

        $id = $excludeId ?: 0;
        $stmt->bind_param('si', $value, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        echo json_encode(['exists' => $result->num_rows > 0]);
        $db->close();
    }
}