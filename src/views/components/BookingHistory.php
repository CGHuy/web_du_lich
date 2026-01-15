<?php
include __DIR__ . '/../partials/header.php';

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Du Lịch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
    <link rel="stylesheet" href="css/SettingAccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

</head>

<body>
    <div class="container-fluid my-4">
        <?php if (isset($_SESSION['booking_success']) && $_SESSION['booking_success']): ?>
            <div class="alert alert-success alert-dismissible fade show mx-5 mb-3" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                <strong> <?= htmlspecialchars($_SESSION['booking_message'] ?? 'Đặt tour thành công!') ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['booking_success'], $_SESSION['booking_message']); ?>
        <?php endif; ?>

        <div class="d-flex gap-4 px-5">
            <?php
            $currentPage = 'booking-history';
            include __DIR__ . '/../partials/settings-menu.php';
            ?>
            <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                <div class="card-header">
                    <h5 class="card-title">Lịch sử Booking</h5>
                    <p style="color: #636465ff ;">Xem lại tất cả chuyến đi bạn đã đặt</p>
                </div>
                <div class="card-body position-relative">
                    <form method="post" action="<?= route('settinguser.bookingHistory'); ?>">
                        <?php $status = $status ?? ($_REQUEST['sort'] ?? ''); ?>
                        <div class="d-flex justify-content-end mb-3">
                            <div class="d-flex align-items-center" style="gap: 10px;">
                                <label for="" style="margin-bottom:0;">Sắp xếp</label>
                                <select name="sort" class="custom-combobox" onchange="this.form.submit()">
                                    <!-- View nhận $bookings đã lọc từ controller, trả về đúng trạng thái combobox đã chọn -->
                                    <option value="" <?= empty($status) ? 'selected' : '' ?>>Tất cả</option>
                                    <option value="confirmed" <?= ($status ?? '') === 'confirmed' ? 'selected' : '' ?>>Đã
                                        xác nhận</option>
                                    <option value="pending_cancellation" <?= ($status ?? '') === 'pending_cancellation' ? 'selected' : '' ?>>Yêu cầu hủy</option>
                                    <option value="cancelled" <?= ($status ?? '') === 'cancelled' ? 'selected' : '' ?>>Đã
                                        hủy</option>
                                </select>
                            </div>
                        </div>
                        <div class="table-container">
                            <div class="table-wrapper">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th style="width: 140px;">Mã Booking</th>
                                            <th style="width: 280px;">Tên Tour</th>
                                            <th style="width: 150px;">Ngày Khởi Hành</th>
                                            <th style="width: 130px;">Tổng Tiền</th>
                                            <th style="width: 140px;">Trạng Thái</th>
                                            <th style="width: 160px;">Ngày Đặt</th>
                                            <th style="width: 120px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($bookings)): ?>
                                            <tr>
                                                <td colspan="9" class="text-center">Chưa có lịch sử đặt tour</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($bookings as $index => $booking): ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= htmlspecialchars($booking['booking_code']) ?></td>
                                                    <td><?= htmlspecialchars($booking['tour_name']) ?></td>
                                                    <td><?= date('d/m/Y', strtotime($booking['departure_date'])) ?></td>
                                                    <td><?= number_format($booking['total_price'], 0, ',', '.') ?> đ</td>
                                                    <td>
                                                        <?php
                                                        $statusBadge = [
                                                            'pending_cancellation' => '<span class="badge bg-warning">Yêu cầu hủy</span>',
                                                            'confirmed' => '<span class="badge bg-success">Đã xác nhận</span>',
                                                            'cancelled' => '<span class="badge bg-danger">Đã hủy</span>'
                                                        ];
                                                        echo $statusBadge[$booking['booking_status']] ?? $booking['booking_status'];
                                                        ?>
                                                    </td>
                                                    <td><?= date('d/m/Y H:i', strtotime($booking['created_at'])) ?></td>
                                                    <td>
                                                        <a href="<?= route('settinguser.detailBookingHistory', ['id' => $booking['id']]); ?>"
                                                            class="btn btn-primary btn-sm px-3">
                                                            Xem chi tiết
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Form đã được loại bỏ, không cần thiết cho nút xem chi tiết -->
                    </form>
                    <!-- Pagination removed: using vertical + horizontal scroll within the table container -->
                </div>
            </div>



        </div>




</body>
<?php
include __DIR__ . '/../partials/footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>