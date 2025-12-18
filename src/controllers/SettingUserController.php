<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../service/BookingHistoryService.php';

class SettingUserController
{
    private $userModel;
    private $bookingHistoryModel;
    private $userId = 1; // cố định

    public function __construct() // Khởi tạo model User
    {
        $this->userModel = new User();
        $this->bookingHistoryModel = new BookingHistoryService();
    }

    //=================== Thông tin cá nhân ===================//
    public function edit()
    {
        $user = $this->userModel->getById($this->userId); // Lấy thông tin user theo $userId
        if (!$user) {
            http_response_code(404);
            echo "User không tồn tại";
            return;
        } // Hiển thị form chỉnh sửa thông tin cá nhân của user 
        include __DIR__ . '/../views/components/SettingAccount.php';
    }

    public function update() // Xử lý cập nhật thông tin cá nhân
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { // ko phải POST thì quay về trang edit
            header('Location: ' . route('settinguser.edit'));
            return;
        }

        $user = $this->userModel->getById($this->userId);
        if (!$user) {
            http_response_code(404);
            echo "User không tồn tại";
            return;
        }
        // Lấy dữ liệu từ form (nếu ko có dữ liệu ms thì giữ nguyên)
        $fullname = $_POST['fullname'] ?? $user['fullname'];
        $phone = $_POST['phone'] ?? $user['phone'];
        $email = $_POST['email'] ?? $user['email'];
        $password = $_POST['password'] ?? '';
        if ($password === '') {
            $password = $user['password']; // giữ nguyên nếu không đổi
        }
        // Gọi hàm update của model User để cập nhật thông tin
        $this->userModel->update(
            $this->userId,
            $fullname,
            $phone,
            $email,
            $password,
            $user['role'],
            $user['status']
        );
        // Cập nhật dữ liệu chuyển về trang edit
        header('Location: ' . route('settinguser.edit'));
    }


    //=================== Đổi mật khẩu ===================//
    public function changePassword() // Hiển thị form đổi mật khẩu
    {
        include __DIR__ . '/../views/components/ChangePassword.php';
    }
    public function updatePassword() // Xử lý cập nhật mật khẩu
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('settinguser.changePassword'));
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

        // Kiểm tra mật khẩu hiện tại (mk nhập ko trùng vs mk trong db thì lỗi)
        if ($currentPassword !== $user['password']) {
            echo "Mật khẩu hiện tại không đúng.";
            return;
        }
        // Kiểm tra mk mới và xác nhận mk có trùng nhau ko
        if ($newPassword !== $confirmPassword) {
            echo "Mật khẩu mới và xác nhận mật khẩu không khớp.";
            return;
        }
        // Cập nhật mật khẩu mới
        $this->userModel->update(
            $this->userId,
            $user['fullname'],
            $user['phone'],
            $user['email'],
            $newPassword,
            $user['role'],
            $user['status']
        );

        header('Location: ' . route('settinguser.changePassword'));
    }

    //=================== Lịch sử đặt tour ===================//
    public function bookingHistory() // Hiển thị lịch sử đặt tour
    {
        // Lấy lịch sử đặt tour từ DB theo userId
        $bookings = $this->bookingHistoryModel->getByUserId($this->userId);
        // Biến $bookings sẽ được dùng trong view
        include __DIR__ . '/../views/components/BookingHistory.php';
    }
    public function updateBookingHistory() // Xử lý cập nhật lịch sử đặt tour
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('settinguser.bookingHistory'));
            return;
        }
        // Nếu có id thì lấy chi tiết, không có thì lấy danh sách
        $bookingId = isset($_POST['id']) ? (int) $_POST['id'] : null;

        if ($bookingId) {
            $bookingDetail = $this->bookingHistoryModel->getById($bookingId);
            if (!$bookingDetail) {
                http_response_code(404);
                echo "Booking không tồn tại";
                return;
            }
            $bookings = [$bookingDetail];
        } else {
            $bookings = $this->bookingHistoryModel->getByUserId($this->userId);
        }

        // Hiển thị lại view với dữ liệu từ DB
        include __DIR__ . '/../views/components/BookingHistory.php';

    }
    public function detailBookingHistory() // Hiển thị chi tiết đặt tour
    {
        // KHÔNG kiểm tra POST, chỉ lấy id từ GET
        $bookingId = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if ($bookingId) {
            $bookingDetail = $this->bookingHistoryModel->getById($bookingId);
            if (!$bookingDetail) {
                http_response_code(404);
                echo "Booking không tồn tại";
                return;
            }
        } else {
            $bookingDetail = null;
        }

        include __DIR__ . '/../views/components/DetailBookingHistory.php';
    }

    //=================== Tour yêu thích ===================//
    public function favoriteTour() // Hiển thị tour yêu thích
    {
        require_once __DIR__ . '/../service/FavouriteTourService.php';
        $favouriteTourService = new FavouriteTourService();
        $favoriteTours = $favouriteTourService->getFavouriteToursByUser($this->userId);
        include __DIR__ . '/../views/components/FavouriteTour.php';
    }

    public function updateFavoriteTour() // Xử lý cập nhật tour yêu thích hoặc xuất danh sách
    {
        require_once __DIR__ . '/../service/FavouriteTourService.php';
        require_once __DIR__ . '/../models/Wishlist.php';
        $wishlistModel = new Wishlist();
        $favouriteTourService = new FavouriteTourService();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $tour_id = isset($_POST['tour_id']) ? (int) $_POST['tour_id'] : null;
            $wishlist_id = isset($_POST['wishlist_id']) ? (int) $_POST['wishlist_id'] : null;

            if ($action === 'add' && $tour_id) {
                $wishlistModel->create($this->userId, $tour_id);
            } elseif ($action === 'delete' && $wishlist_id) {
                $wishlistModel->delete($wishlist_id);
            }

            header('Location: ' . route('settinguser.favoriteTour'));
            return;
        }

        // Nếu là GET, xuất danh sách tour yêu thích
        $favoriteTours = $favouriteTourService->getFavouriteToursByUser($this->userId);
        include __DIR__ . '/../views/components/FavouriteTour.php';
    }


}