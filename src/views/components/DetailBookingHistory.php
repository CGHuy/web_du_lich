<?php
include __DIR__ . '/../partials/menu.php';
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
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Chi tiết BookingTour</h2>
                <p>Thông tin chi tiết về chuyến đi của bạn đã đặt</p>
            </div>
            <div class="card-body card-grid">
            </div>
            <div class="table-responsive">
                <table class="table align-top">
                    <form method="post" action="<?= route('settinguser.detailBookingHistory'); ?>">
                        <thead>
                            <tr>
                                <td colspan="2" align="left">Thông tin Booking</td>
                            </tr>
                            <tr>
                                <td colspan="2" align="left">Thông tin thanh toán</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bookings)): ?>
                                <tr>
                                    <td colspan="9" class="text-center">Chưa có lịch sử đặt tour</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($bookings as $index => $booking): ?>
                                    <tr class="align-middle">
                                    <tr>
                                        <td>Mã Booking</td>
                                        <td><?= htmlspecialchars($booking['booking_code']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tên Tour</td>
                                        <td><?= htmlspecialchars($booking['tour_name']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Ngày khởi hành</td>
                                        <td><?= date('d/m/Y', strtotime($booking['departure_date'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Số lượng</td>
                                        <td><?= htmlspecialchars($booking['quantity']) ?></td>
                                    </tr>

                                    <tr>
                                        <td>Địa điểm khởi hành</td>
                                        <td><?= htmlspecialchars($booking['departure_location']) ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color: red">Tổng giá</td>
                                        <td><?= number_format($booking['total_price'], 0, ',', '.') ?> đ</td>
                                    </tr>
                                    <tr>
                                        <td>Trạng thái</td>
                                        <td>
                                            <?php
                                            $statusBadge = [
                                                'pending' => '<span class="badge bg-info">Chờ xác nhận</span>',
                                                'confirmed' => '<span class="badge bg-success">Đã xác nhận</span>',
                                                'cancelled' => '<span class="badge bg-danger">Đã hủy</span>'
                                            ];
                                            echo $statusBadge[$booking['booking_status']] ?? $booking['booking_status'];
                                            ?>
                                        </td>



                                    </tr>
                                    <tr>
                                        <td>Trạng thái thanh toán</td>
                                        <td>
                                            <?php
                                            $statusBadge = [
                                                'unpaid' => '<span class="badge bg-info">Chưa thanh toán</span>',
                                                'paid' => '<span class="badge bg-success">Đã thanh toán</span>',
                                                'refunded' => '<span class="badge bg-danger">Đã hoàn tiền</span>'
                                            ];
                                            echo $statusBadge[$booking['payment_status']] ?? $booking['payment_status'];
                                            ?>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </form>
                </table>
            </div>
        </div>

    </div>


</body>
<?php include __DIR__ . '/../partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>