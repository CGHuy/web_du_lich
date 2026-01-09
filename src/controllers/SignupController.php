<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';

class SignupController
{
    private $db;
    private $conn;
    private $user;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        $this->user = new User();
    }

    public function signup()
    {
        $message = '';
        $message_type = '';
        $form_data = ['fullname' => '', 'phone' => '', 'email' => '', 'password' => ''];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = trim($_POST['fullname'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($fullname) || empty($phone) || empty($email) || empty($password)) {
                $message = 'Vui lòng điền đầy đủ tất cả các trường.';
                $message_type = 'danger';
                $form_data = ['fullname' => $fullname, 'phone' => $phone, 'email' => $email, 'password' => $password];
            } elseif (!preg_match('/^0[0-9]{9}$/', $phone)) {
                $message = 'Số điện thoại phải có 10 chữ số và bắt đầu bằng 0.';
                $message_type = 'danger';
                $form_data = ['fullname' => $fullname, 'phone' => $phone, 'email' => $email, 'password' => $password];
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message = 'Email không hợp lệ.';
                $message_type = 'danger';
                $form_data = ['fullname' => $fullname, 'phone' => $phone, 'email' => $email, 'password' => $password];
            } else {
                // Check if phone already exists
                $stmt = $this->conn->prepare('SELECT id FROM users WHERE phone = ? LIMIT 1');
                $stmt->bind_param('s', $phone);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $message = 'Số điện thoại này đã được đăng ký.';
                    $message_type = 'danger';
                    $form_data = ['fullname' => $fullname, 'phone' => $phone, 'email' => $email, 'password' => $password];
                } else {
                    // Check if email already exists
                    $stmt = $this->conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $message = 'Email này đã được đăng ký.';
                        $message_type = 'danger';
                        $form_data = ['fullname' => $fullname, 'phone' => $phone, 'email' => $email, 'password' => $password];
                    } else {
                        if ($this->user->create($fullname, $phone, $email, $password)) {
                            $message = 'Đăng ký thành công! Chuyển hướng đến trang đăng nhập...';
                            $message_type = 'success';
                            $form_data = ['fullname' => '', 'phone' => '', 'email' => '', 'password' => ''];
                            header('refresh:2;url=login.php');
                        } else {
                            $message = 'Lỗi khi đăng ký. Vui lòng thử lại.';
                            $message_type = 'danger';
                            $form_data = ['fullname' => $fullname, 'phone' => $phone, 'email' => $email, 'password' => $password];
                        }
                    }
                }
            }
        }

        return [
            'message' => $message,
            'message_type' => $message_type,
            'form_data' => $form_data
        ];
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
