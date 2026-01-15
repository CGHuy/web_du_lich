<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../service/BookingHistoryService.php';
require_once __DIR__ . '/../service/FavouriteTourService.php';
require_once __DIR__ . '/../models/Wishlist.php';


class SettingUserController
{
    private $userModel;
    private $bookingHistoryModel;
    private $userId;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $this->userId = $_SESSION['user_id'] ?? null;
        if (!$this->userId) {
            header('Location: /web_du_lich/public/login.php');
            exit;
        }
        $this->userModel = new User();
        $this->bookingHistoryModel = new BookingHistoryService();
    }

    //=================== Thông tin cá nhân ===================//

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
            header('Location: ' . route('settinguser.edit'));
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
        $password = $_POST['password'] ?? $user['password'];
        $this->userModel->update($this->userId, $fullname, $phone, $email, $password, $user['role'], $user['status']);
        header('Location: ' . route('settinguser.edit'));
    }


    //=================== Đổi mật khẩu ===================//

    public function changePassword()
    {
        include __DIR__ . '/../views/components/ChangePassword.php';
    }
    public function updatePassword()
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
        if ($currentPassword !== $user['password']) {
            echo "Mật khẩu hiện tại không đúng.";
            return;
        }
        if ($newPassword !== $confirmPassword) {
            echo "Mật khẩu mới và xác nhận mật khẩu không khớp.";
            return;
        }
        $this->userModel->update($this->userId, $user['fullname'], $user['phone'], $user['email'], $newPassword, $user['role'], $user['status']);
        header('Location: ' . route('settinguser.changePassword'));
    }

    //=================== Lịch sử đặt tour ===================//
    public function bookingHistory() // Hiển thị danh sách booking với lọc
    {
        $statusRaw = $_REQUEST['sort'] ?? null;
        $statusMap = [
            'status-warning' => 'pending_cancellation',
            'status-success' => 'confirmed',
            'status-danger' => 'cancelled'
        ];
        $statusValue = in_array($statusRaw, ['pending_cancellation', 'confirmed', 'cancelled']) ? $statusRaw : ($statusMap[$statusRaw] ?? null);
        $status = $statusValue ?? null;
        // Lấy danh sách booking của user theo trạng thái đã lọc.
        $bookings = $this->bookingHistoryModel->getByUserId($this->userId, $statusValue);
        include __DIR__ . '/../views/components/BookingHistory.php';
    }
    public function updateBookingHistory()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('settinguser.bookingHistory'));
            return;
        }
        // Cập nhật danh sách booking theo id đc chọn 
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
        include __DIR__ . '/../views/components/BookingHistory.php';
    }
    public function detailBookingHistory() // Hiển thị chi tiết booking
    {
        $bookingId = isset($_GET['id']) ? (int) $_GET['id'] : null;
        if ($bookingId) {
            $bookingDetail = $this->bookingHistoryModel->getById($bookingId);
            if (!$bookingDetail) {
                http_response_code(404);
                echo "Booking không tồn tại";
                return;
            }
            $tourId = $bookingDetail['tour_id'];
            $existingReview = $this->checkExistingReview($this->userId, $tourId);
        } else {
            $bookingDetail = null;
            $existingReview = null;
        }
        include __DIR__ . '/../views/components/DetailBookingHistory.php';
    }

    // Yêu cầu hủy booking (chuyển trạng thái từ confirmed -> pending_cancellation)
    public function requestCancelBooking()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('settinguser.bookingHistory'));
            return;
        }
        $bookingId = isset($_POST['cancel_id']) ? (int) $_POST['cancel_id'] : null;
        if (!$bookingId) {
            http_response_code(400);
            echo "Thiếu mã booking";
            return;
        }
        $bookingDetail = $this->bookingHistoryModel->getById($bookingId);
        if (!$bookingDetail || (int) $bookingDetail['user_id'] !== (int) $this->userId) {
            http_response_code(404);
            echo "Booking không tồn tại hoặc không thuộc về bạn";
            return;
        }
        if (($bookingDetail['booking_status'] ?? '') !== 'confirmed') {
            http_response_code(400);
            echo "Chỉ có thể yêu cầu hủy với booking đã xác nhận";
            return;
        }
        require_once __DIR__ . '/../models/Booking.php';
        $bookingModel = new Booking();
        $bookingModel->updateStatus($bookingId, 'pending_cancellation');
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION['booking_success'] = true;
        $_SESSION['booking_message'] = 'Đã gửi yêu cầu hủy booking.';
        header('Location: ' . route('settinguser.detailBookingHistory', ['id' => $bookingId]));
    }

    //=================== Đánh giá tour ===================//
    public function submitReview()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . route('settinguser.bookingHistory'));
            return;
        }
        $bookingId = isset($_POST['booking_id']) ? (int) $_POST['booking_id'] : null;
        $rating = isset($_POST['rating']) ? (int) $_POST['rating'] : null;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';
        if (!$bookingId || !$rating) {
            if (session_status() === PHP_SESSION_NONE)
                session_start();
            $_SESSION['error_message'] = 'Vui lòng chọn đánh giá.';
            header('Location: ' . route('settinguser.detailBookingHistory', ['id' => $bookingId]));
            return;
        }
        if ($rating < 1 || $rating > 5) {
            if (session_status() === PHP_SESSION_NONE)
                session_start();
            $_SESSION['error_message'] = 'Đánh giá phải từ 1 đến 5 sao.';
            header('Location: ' . route('settinguser.detailBookingHistory', ['id' => $bookingId]));
            return;
        }
        $bookingDetail = $this->bookingHistoryModel->getById($bookingId);
        if (!$bookingDetail || (int) $bookingDetail['user_id'] !== (int) $this->userId) {
            http_response_code(404);
            echo "Booking không tồn tại hoặc không thuộc về bạn";
            return;
        }
        $tourId = $bookingDetail['tour_id'];
        require_once __DIR__ . '/../models/Review.php';
        $reviewModel = new Review();
        $existingReview = $this->checkExistingReview($this->userId, $tourId);
        if ($existingReview) {
            $reviewModel->update($existingReview['id'], $this->userId, $tourId, $rating, $comment);
            $message = 'Cập nhật đánh giá thành công!';
        } else {
            $reviewModel->create($this->userId, $tourId, $rating, $comment);
            $message = 'Đánh giá tour thành công!';
        }
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $_SESSION['booking_success'] = true;
        $_SESSION['booking_message'] = $message;
        header('Location: ' . route('settinguser.detailBookingHistory', ['id' => $bookingId]));
    }

    private function checkExistingReview($userId, $tourId)
    {
        require_once __DIR__ . '/../../config/database.php';
        $db = new Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT id FROM reviews WHERE user_id = ? AND tour_id = ?");
        $stmt->bind_param('ii', $userId, $tourId);
        $stmt->execute();
        $result = $stmt->get_result();
        $review = $result->fetch_assoc();
        $db->close();
        return $review;
    }

    //=================== Tour yêu thích ===================//
    public function favoriteTour()
    {
        $favouriteTourService = new FavouriteTourService();
        $favoriteTours = $favouriteTourService->getFavouriteToursByUser($this->userId);
        include __DIR__ . '/../views/components/FavouriteTour.php';
    }

    public function updateFavoriteTour()
    {
        $wishlistModel = new Wishlist();
        $favouriteTourService = new FavouriteTourService();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $tour_id = isset($_POST['tour_id']) ? (int) $_POST['tour_id'] : null;
            $wishlist_id = isset($_POST['wishlist_id']) ? (int) $_POST['wishlist_id'] : null;
            if ($action === 'add' && $tour_id) {
                $wishlistModel->create($this->userId, $tour_id);
            } elseif ($action === 'delete' && $wishlist_id) {
                $favouriteTourService->deleteFavourite($wishlist_id);
            }
            header('Location: ' . route('settinguser.favoriteTour'));
            return;
        }
        $favoriteTours = $favouriteTourService->getFavouriteToursByUser($this->userId);
        include __DIR__ . '/../views/components/FavouriteTour.php';
    }
}
