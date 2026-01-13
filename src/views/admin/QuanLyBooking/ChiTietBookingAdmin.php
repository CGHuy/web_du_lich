<?php $bookingDetail = $bookingDetail ?? [];
$currentPage = 'booking'; ?>


<link rel="stylesheet" href="css/ChiTietBookingAdmin.css">

<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h2 class="card-title">CHI TIẾT BOOKING
            <?php if (($bookingDetail['booking_status'] ?? '') === 'pending_cancellation'): ?>
                <span class="badge bg-warning ms-2">Yêu cầu hủy</span>
            <?php elseif (($bookingDetail['booking_status'] ?? '') === 'confirmed'): ?>
                <span class="badge bg-success ms-2">Đã xác nhận</span>
            <?php elseif (($bookingDetail['booking_status'] ?? '') === 'cancelled'): ?>
                <span class="badge bg-danger ms-2">Đã hủy</span>
            <?php endif; ?>
        </h2>
        <p style="color: #636465ff;">Thông tin chi tiết về chuyến đi của bạn đã đặt</p>
    </div>
    <div>
        <?php if (session_status() === PHP_SESSION_NONE)
            session_start(); ?>
        <?php if (isset($_SESSION['admin_message'])): ?>
            <div class="alert alert-success mb-2"><?= htmlspecialchars($_SESSION['admin_message']); ?></div>
            <?php unset($_SESSION['admin_message']); ?>
        <?php endif; ?>
        <?php if (($bookingDetail['booking_status'] ?? '') === 'pending_cancellation'): ?>
            <button id="openProcessCancel" class="btn btn-danger btn-sm">Xử lý yêu cầu hủy</button>
        <?php endif; ?>
    </div>
</div>
<div class="table-responsive">
    <form method="post">
        <table class="table align-middle detail-booking-table">
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
                            <?= htmlspecialchars($bookingDetail['booking_code'] ?? 'BK' . str_pad($bookingDetail['id'], 5, '0', STR_PAD_LEFT)) ?>
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
                        <th rowspan="4">
                            <h6 style="color: #1a75c4ff;">THÔNG TIN THANH TOÁN</h6>
                        </th>
                    </tr>

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
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</div>

<!-- Modal: Process Cancel Request -->
<div class="modal fade" id="processCancelModal" tabindex="-1" aria-labelledby="processCancelModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="/web_du_lich/public/index.php?route=BookingAdmin.processCancel">
                <div class="modal-header">
                    <h5 class="modal-title" id="processCancelModalLabel">Xử lý yêu cầu hủy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="booking_id" value="<?= (int) $bookingDetail['id']; ?>">
                    <div class="row">
                        <div class="col-md-7">
                            <div style="background-color:#e6f2ff;padding:20px;border-radius:8px;margin-bottom:30px;">
                                <h4 class="mb-3"><strong>
                                        <?php echo htmlspecialchars($tour['name'] ?? 'Chưa chọn tour'); ?>
                                    </strong></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Thông tin booking</h6>
                                        <p><strong>Mã Booking:</strong>
                                            <?= htmlspecialchars($bookingDetail['booking_code']) ?>
                                        </p>
                                        <p><strong>Tên Tour:</strong>
                                            <?= htmlspecialchars($bookingDetail['tour_name']) ?>
                                        </p>
                                        <p><strong>Tổng giá:</strong>
                                            <?= number_format($bookingDetail['total_price'], 0, ',', '.') ?> đ
                                        </p>
                                    </div>

                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Lý do khách hủy</label>
                                <textarea class="form-control" name="refund_note" rows="3"
                                    placeholder="Ghi lý do (nếu khách cung cấp)"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ghi chú xử lý (nội bộ)</label>
                                <textarea class="form-control" name="admin_note" rows="2"
                                    placeholder="Ghi chú cho kế toán/thủ quỹ"></textarea>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card p-3 bg-light">
                                <h6>Chính sách áp dụng</h6>
                                <p>Hủy trước 15-30 ngày khởi hành: Phí hủy 30%, Hoàn trả 70%</p>
                                <hr>
                                <div class="mb-2"><strong>Số tiền hoàn (tạm tính):</strong></div>
                                <?php $refundAmount = round(($bookingDetail['total_price'] ?? 0) * 0.7, 0); ?>
                                <div class="display-6 text-success mb-2">
                                    <?= number_format($refundAmount, 0, ',', '.') ?> đ
                                </div>
                                <input type="hidden" name="refund_amount" value="<?= (int) $refundAmount; ?>">
                                <small class="text-muted">(70% của tổng giá)</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="action" value="deny" class="btn btn-outline-secondary">Từ chối / Liên hệ
                        lại</button>
                    <button type="button" id="btnApproveRefund" class="btn btn-danger">Phê duyệt hoàn tiền</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal xác nhận hoàn tiền sẽ được tạo động bằng JS -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var btn = document.getElementById('openProcessCancel');
        if (btn) {
            btn.addEventListener('click', function (e) {
                var modal = new bootstrap.Modal(document.getElementById('processCancelModal'));
                modal.show();
            });
        }

        // Modal xác nhận hoàn tiền
        var btnApprove = document.getElementById('btnApproveRefund');
        if (btnApprove) {
            btnApprove.addEventListener('click', function (e) {
                e.preventDefault();
                var refundAmount = document.querySelector('input[name="refund_amount"]').value;
                var now = new Date();
                var timeStr = now.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' }) + ' ' + now.toLocaleDateString('vi-VN');
                var confirmModal = document.createElement('div');
                confirmModal.className = 'modal fade';
                confirmModal.id = 'confirmRefundModal';
                confirmModal.innerHTML = `
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Xác nhận hoàn tiền</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <div class="display-6 text-success mb-2">Hoàn tiền: <strong>${parseInt(refundAmount).toLocaleString('vi-VN')} đ</strong></div>
                                                <div class="mb-2">Thời gian: <strong>${timeStr}</strong></div>
                                                <div class="mb-2 text-muted">Bạn chắc chắn muốn phê duyệt hoàn tiền này?</div>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                <button type="button" id="confirmRefundBtn" class="btn btn-danger">Xác nhận</button>
                                            </div>
                                        </div>
                                    </div>
                                `;
                document.body.appendChild(confirmModal);
                var bsModal = new bootstrap.Modal(confirmModal);
                bsModal.show();
                confirmModal.addEventListener('hidden.bs.modal', function () {
                    confirmModal.remove();
                });
                setTimeout(function () {
                    var confirmBtn = document.getElementById('confirmRefundBtn');
                    if (confirmBtn) {
                        confirmBtn.onclick = function () {
                            // Hiển thị thông báo thành công
                            bsModal.hide();
                            setTimeout(function () {
                                // Cập nhật trạng thái ngay trên giao diện (UX tốt hơn)
                                var statusBadges = document.querySelectorAll('.card-title .badge, td .badge');
                                statusBadges.forEach(function (badge) {
                                    if (badge.textContent.trim() === 'Yêu cầu hủy') {
                                        badge.className = 'badge bg-danger ms-2';
                                        badge.textContent = 'Đã hủy';
                                    }
                                    if (badge.textContent.trim() === 'Chưa thanh toán' || badge.textContent.trim() === 'Đã thanh toán') {
                                        badge.className = 'badge bg-danger';
                                        badge.textContent = 'Đã hoàn tiền';
                                    }
                                });
                                // Thêm alert thành công
                                var alertDiv = document.createElement('div');
                                alertDiv.className = 'alert alert-success mb-2';
                                alertDiv.innerHTML = `Hoàn tiền thành công: <strong>${parseInt(refundAmount).toLocaleString('vi-VN')} đ</strong> lúc <strong>${timeStr}</strong>`;
                                var cardHeader = document.querySelector('.card-header');
                                if (cardHeader) {
                                    cardHeader.insertBefore(alertDiv, cardHeader.firstChild);
                                } else {
                                    document.body.insertBefore(alertDiv, document.body.firstChild);
                                }
                                // Sau 1.5s reload lại trang để lấy dữ liệu mới từ server
                                setTimeout(function () {
                                    window.location.reload();
                                }, 1500);
                            }, 400); // Đợi modal đóng
                        };
                    }
                }, 300);
            });
        }
    });
</script>