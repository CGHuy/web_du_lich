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

    <style>
        .rating-input input[type="radio"] {
            display: none;
        }

        .rating-input .star-wrapper {
            display: inline-block;
            position: relative;
            cursor: pointer;
        }

        .rating-input .star-label {
            display: block;
            color: #ddd;
            cursor: pointer;
            font-size: 40px;
            transition: color 0.15s ease, text-shadow 0.15s ease;
            margin: 0;
            line-height: 1;
            padding: 0 8px;
            user-select: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid my-4">
        <div class="d-flex gap-4 px-5">
            <?php
            $currentPage = 'booking-history';
            include __DIR__ . '/../partials/settings-menu.php';
            ?>
            <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                <div class="card-header">
                    <h2 class="card-title">CHI TIẾT BOOKING</h2>
                    <p style="color: #636465ff ;">Thông tin chi tiết về chuyến đi của bạn đã đặt</p>
                </div>
                <?php if (session_status() === PHP_SESSION_NONE)
                    session_start(); ?>
                <?php if (isset($_SESSION['booking_success']) && $_SESSION['booking_success']):
                    // Preserve values for client-side redirect before clearing session
                    $jsBookingSuccess = true;
                    $jsBookingMessage = $_SESSION['booking_message'] ?? 'Thao tác thành công';
                    unset($_SESSION['booking_success'], $_SESSION['booking_message']);
                ?>
                    <div class="alert alert-success m-3" role="alert">
                        <?= htmlspecialchars($jsBookingMessage) ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger m-3" role="alert">
                        <?= htmlspecialchars($_SESSION['error_message']) ?>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>
                <div class="table-responsive">
                    <form method="post" action="<?= route('settinguser.detailBookingHistory'); ?>">
                        <table class="table align-middle detail-booking-table ">
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
                                        <td class="detail-booking-title">Họ và tên</td>
                                        <td><?= htmlspecialchars($bookingDetail['contact_name']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Email</td>
                                        <td><?= htmlspecialchars($bookingDetail['contact_email']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Số điện thoại</td>
                                        <td><?= htmlspecialchars($bookingDetail['contact_phone']) ?></td>
                                    </tr>

                                    <tr>
                                        <th rowspan="9">
                                            <h6 style="color: #1a75c4ff;">CHI TIẾT BOOKING </h6>
                                        </th>
                                    </tr>

                                    <tr>
                                        <td class="detail-booking-title">Mã Booking</td>
                                        <td style="color: blue; font-weight: bold;">
                                            <?= htmlspecialchars($bookingDetail['booking_code']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Mã Tour</td>
                                        <td style="color: blue; font-weight: bold;">
                                            <?= htmlspecialchars($bookingDetail['tour_code']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Tên Tour</td>
                                        <td><?= htmlspecialchars($bookingDetail['tour_name']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Ngày khởi hành</td>
                                        <td><?= date('d/m/Y', strtotime($bookingDetail['departure_date'])) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Người lớn</td>
                                        <td><?= htmlspecialchars($bookingDetail['adults'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Trẻ em</td>
                                        <td><?= htmlspecialchars($bookingDetail['children'] ?? 0) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Địa điểm khởi hành</td>
                                        <td><?= htmlspecialchars($bookingDetail['departure_location']) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Ghi chú</td>
                                        <td><?= htmlspecialchars($bookingDetail['note']) ?></td>
                                    </tr>

                                    <tr class="detail-payment-header">
                                        <th rowspan="5">
                                            <h6 style="color: #1a75c4ff;">THÔNG TIN THANH TOÁN</h6>
                                        </th>

                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Tổng giá</td>
                                        <td style="color: red; font-weight: bold;">
                                            <?= number_format($bookingDetail['total_price'], 0, ',', '.') ?> đ
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="detail-booking-title">Trạng thái</td>
                                        <td>
                                            <?php
                                            $statusBadge = [
                                                'pending_cancellation' => '<span class="badge bg-warning">Yêu cầu hủy</span>',
                                                'confirmed' => '<span class="badge bg-success">Đã xác nhận</span>',
                                                'cancelled' => '<span class="badge bg-danger">Đã hủy</span>'
                                            ];
                                            echo $statusBadge[$bookingDetail['booking_status']] ?? $bookingDetail['booking_status'];
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="detail-booking-title">Trạng thái thanh toán</td>
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
                                    <tr>
                                        <td class="detail-booking-title">Hành động</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <?php if (($bookingDetail['booking_status'] ?? '') === 'confirmed'): ?>
                                                    <form method="post" style="display: inline;">
                                                        <input type="hidden" name="cancel_id" value="<?= (int) $bookingDetail['id']; ?>">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            formaction="<?= route('settinguser.requestCancelBooking'); ?>" formmethod="post"
                                                            onclick="return confirm('Bạn chắc chắn muốn yêu cầu hủy booking này?');">
                                                            Yêu cầu hủy
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#reviewModal">
                                                        <?= !empty($existingReview) ? 'Sửa đánh giá' : 'Đánh giá' ?>
                                                    </button>
                                                <?php else: ?>
                                                    <span class="text-muted">Không có hành động khả dụng</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Đánh giá tour -->
    <?php if (!empty($bookingDetail) && ($bookingDetail['booking_status'] ?? '') === 'confirmed'): ?>
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Đánh giá tour: <?= htmlspecialchars($bookingDetail['tour_name']) ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="<?= route('settinguser.submitReview'); ?>">
                        <div class="modal-body">
                            <input type="hidden" name="booking_id" value="<?= (int) $bookingDetail['id']; ?>">

                            <div class="mb-3">
                                <label for="rating" class="form-label">Đánh giá (sao) <span style="color: red;">*</span></label>
                                <div class="rating-input" id="ratingInput">
                                    <div style="display: flex; gap: 0; justify-content: flex-start;">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <input type="radio" id="star<?= $i ?>" name="rating" value="<?= $i ?>"
                                                <?= (isset($existingReview['rating']) && $existingReview['rating'] == $i) ? 'checked' : '' ?>
                                                required>
                                            <label for="star<?= $i ?>" class="star-wrapper">
                                                <span class="star-label">★</span>
                                            </label>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>

                            <script>
                                const ratingInputs = document.querySelectorAll('#ratingInput input[type="radio"]');

                                // Highlight sao dựa trên giá trị thực
                                function updateStarDisplay() {
                                    let checkedValue = null;

                                    // Tìm input được check
                                    ratingInputs.forEach(input => {
                                        if (input.checked) {
                                            checkedValue = parseInt(input.value);
                                        }
                                    });

                                    // Highlight tất cả sao từ 1 đến checkedValue
                                    ratingInputs.forEach(input => {
                                        const label = document.querySelector(`label[for="${input.id}"] .star-label`);
                                        const value = parseInt(input.value);

                                        if (checkedValue !== null) {
                                            // Highlight từ 1 đến checkedValue
                                            if (value <= checkedValue) {
                                                label.style.color = '#ffc107';
                                                label.style.textShadow = '0 0 10px rgba(255, 193, 7, 0.5)';
                                            } else {
                                                label.style.color = '#ddd';
                                                label.style.textShadow = 'none';
                                            }
                                        } else {
                                            label.style.color = '#ddd';
                                            label.style.textShadow = 'none';
                                        }
                                    });
                                }

                                // Thêm event listener cho mỗi input
                                ratingInputs.forEach(input => {
                                    input.addEventListener('change', updateStarDisplay);

                                    // Hover effect
                                    const wrapper = document.querySelector(`label[for="${input.id}"]`);
                                    wrapper.addEventListener('mouseenter', function() {
                                        const hoverValue = parseInt(input.value);
                                        ratingInputs.forEach(inp => {
                                            const lbl = document.querySelector(`label[for="${inp.id}"] .star-label`);
                                            const val = parseInt(inp.value);
                                            if (val <= hoverValue) {
                                                lbl.style.color = '#ffc107';
                                                lbl.style.textShadow = '0 0 10px rgba(255, 193, 7, 0.5)';
                                            } else {
                                                lbl.style.color = '#ddd';
                                                lbl.style.textShadow = 'none';
                                            }
                                        });
                                    });

                                    wrapper.addEventListener('mouseleave', function() {
                                        // Restore lại trạng thái checked
                                        updateStarDisplay();
                                    });
                                });

                                // Trigger highlight khi modal mở (nếu có review cũ)
                                const reviewModal = document.getElementById('reviewModal');
                                if (reviewModal) {
                                    reviewModal.addEventListener('shown.bs.modal', function() {
                                        updateStarDisplay();
                                    });
                                }
                            </script>

                            <div class="mb-3">
                                <label for="comment" class="form-label">Bình luận (tùy chọn)</label>
                                <textarea class="form-control" id="comment" name="comment" rows="4"
                                    placeholder="Chia sẻ trải nghiệm của bạn về tour..."><?= isset($existingReview['comment']) ? htmlspecialchars($existingReview['comment']) : '' ?></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

</body>
<?php include __DIR__ . '/../partials/footer.php'; ?>
<?php if (!empty($jsBookingSuccess) && $jsBookingSuccess): ?>
    <script>
        (function() {
            // Show message briefly then navigate to booking history to refresh statuses
            setTimeout(function() {
                window.location.href = '<?= route('settinguser.bookingHistory'); ?>';
            }, 1500);
        })();
    </script>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    (function() {
        // Only poll if the booking is currently a pending cancellation
        var initialStatus = <?= json_encode($bookingDetail['booking_status'] ?? '') ?>;
        if (!initialStatus) return;
        if (initialStatus !== 'pending_cancellation') return; // no need to poll

        var bookingId = <?= (int) ($bookingDetail['id'] ?? 0) ?>;
        var statusCell = document.getElementById('bookingStatusCell');
        var cancelMsgEl = document.getElementById('cancelResultMessage');
        var pollInterval = 5000; // ms
        var timer = null;

        function renderStatus(status) {
            var map = {
                'pending_cancellation': '<span class="badge bg-warning">Yêu cầu hủy</span>',
                'confirmed': '<span class="badge bg-success">Đã xác nhận</span>',
                'cancelled': '<span class="badge bg-danger">Đã hủy</span>'
            };
            return map[status] || status;
        }

        function checkStatus() {
            var url = '<?= route('settinguser.bookingStatusApi') ?>' + '?id=' + bookingId;
            fetch(url, { credentials: 'same-origin' })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.error) return;
                    var newStatus = data.booking_status || '';
                    var note = data.note || '';

                    if (newStatus && statusCell && statusCell.innerHTML.trim() !== renderStatus(newStatus).trim()) {
                        statusCell.innerHTML = renderStatus(newStatus);
                    }

                    if (note && /Yêu cầu hủy thất bại/i.test(note)) {
                        // show explicit message
                        cancelMsgEl.innerHTML = '<div class="alert alert-danger p-2 m-0">Yêu cầu hủy thất bại</div>';
                        cancelMsgEl.style.display = 'block';
                    } else if (note && /thất bại/i.test(note)) {
                        cancelMsgEl.innerHTML = '<div class="alert alert-danger p-2 m-0">' + (note.length > 100 ? note.substring(0, 100) + '...' : note) + '</div>';
                        cancelMsgEl.style.display = 'block';
                    }

                    // Stop polling if the booking is no longer pending_cancellation
                    if (newStatus && newStatus !== 'pending_cancellation') {
                        if (timer) clearInterval(timer);
                    }
                })
                .catch(function (err) {
                    console.warn('Polling booking status failed', err);
                });
        }

        // Start immediate check and periodic polling
        checkStatus();
        timer = setInterval(checkStatus, pollInterval);
    })();
</script>

</html>