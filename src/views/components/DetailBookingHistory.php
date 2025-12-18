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
                <h2 class="card-title">CHI TIẾT BOOKING</h2>
                <p style="color: #636465ff ;">Thông tin chi tiết về chuyến đi của bạn đã đặt</p>
            </div>
            <div class="table-responsive">
                <table class="table align-middle">
                    <form method="post" action="<?= route('settinguser.detailBookingHistory'); ?>">
                        <tbody>
                            <?php if (empty($bookingDetail)): ?>
                                <tr>
                                    <td colspan="9" class="text-center">Không tìm thấy booking</td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <th rowspan="4">
                                        <h6 style="color: #1a75c4ff;">THÔNG TIN LIÊN LẠC</h6>
                                    </th>
                                </tr>
                                <tr>
                                    <td>Họ và tên</td>
                                    <td><?= htmlspecialchars($bookingDetail['contact_name']) ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?= htmlspecialchars($bookingDetail['contact_email']) ?></td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại</td>
                                    <td><?= htmlspecialchars($bookingDetail['contact_phone']) ?></td>
                                </tr>

                                <tr>
                                    <th rowspan="8">
                                        <h6 style="color: #1a75c4ff;">CHI TIẾT BOOKING </h6>
                                    </th>
                                </tr>

                                <tr>
                                    <td>Mã Booking</td>
                                    <td style="color: blue; font-weight: bold;">
                                        <?= htmlspecialchars($bookingDetail['booking_code']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Mã Tour</td>
                                    <td style="color: blue; font-weight: bold;">
                                        <?= htmlspecialchars($bookingDetail['tour_code']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tên Tour</td>
                                    <td><?= htmlspecialchars($bookingDetail['tour_name']) ?></td>
                                </tr>
                                <tr>
                                    <td>Ngày khởi hành</td>
                                    <td><?= date('d/m/Y', strtotime($bookingDetail['departure_date'])) ?></td>
                                </tr>
                                <tr>
                                    <td>Số lượng</td>
                                    <td><?= htmlspecialchars($bookingDetail['quantity']) ?></td>
                                </tr>
                                <tr>
                                    <td>Địa điểm khởi hành</td>
                                    <td><?= htmlspecialchars($bookingDetail['departure_location']) ?></td>
                                </tr>
                                <tr>
                                    <td>Ghi chú</td>
                                    <td><?= htmlspecialchars($bookingDetail['note']) ?></td>
                                </tr>

                                <tr>
                                    <th rowspan="4">
                                        <h6 style="color: #1a75c4ff;">THÔNG TIN THANH TOÁN</h6>
                                    </th>

                                </tr>
                                <tr>
                                    <td>Tổng giá</td>
                                    <td style="color: red; font-weight: bold;">
                                        <?= number_format($bookingDetail['total_price'], 0, ',', '.') ?> đ
                                    </td>
                                </tr>
                                <tr>
                                    <td>Trạng thái</td>
                                    <td>
                                        <?php
                                        $statusBadge = [
                                            'pending' => '<span class="badge bg-warning">Chờ xác nhận</span>',
                                            'confirmed' => '<span class="badge bg-success">Đã xác nhận</span>',
                                            'cancelled' => '<span class="badge bg-danger">Đã hủy</span>'
                                        ];
                                        echo $statusBadge[$bookingDetail['booking_status']] ?? $bookingDetail['booking_status'];
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Trạng thái thanh toán</td>
                                    <td>
                                        <?php
                                        $statusBadge = [
                                            'unpaid' => '<span class="badge bg-warning">Chưa thanh toán</span>',
                                            'paid' => '<span class="badge bg-success">Đã thanh toán</span>',
                                            'refunded' => '<span class="badge bg-danger">Đã hoàn tiền</span>'
                                        ];
                                        echo $statusBadge[$bookingDetail['payment_status']] ?? $bookingDetail['payment_status'];
                                        ?>
                                    </td>
                                </tr>
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