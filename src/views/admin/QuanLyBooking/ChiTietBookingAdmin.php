<?php $bookingDetail = $bookingDetail ?? [];
$currentPage = 'booking'; ?>


<link rel="stylesheet" href="css/ChiTietBookingAdmin.css">

<div class="card-header">
    <h2 class="card-title">CHI TIẾT BOOKING</h2>
    <p style="color: #636465ff;">Thông tin chi tiết về chuyến đi của bạn đã đặt</p>
</div>
<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<?php if (isset($_SESSION['booking_success']) && $_SESSION['booking_success']): ?>
    <div class="alert alert-success alert-dismissible fade show mx-3 mb-3" role="alert">
        <strong>
            <?= htmlspecialchars($_SESSION['booking_message'] ?? '') ?>
        </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['booking_success'], $_SESSION['booking_message']); ?>
<?php endif; ?>
<div class="detail-layout d-flex">
    <div class="table-column" style="flex:1">
        <div class="table-responsive">
            <form method="post" id="admin-detail-form">
                <input type="hidden" name="booking_id" value="<?= (int) ($bookingDetail['id'] ?? 0) ?>">
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
    </div>
    <aside class="right-sidebar" style="width:360px; margin-left:24px">
        <div class="card" style="border:1px solid #f0f0f0;">
            <div class="card-body">
                <h6 class="text-danger mb-3"><i class="fa fa-exclamation-circle me-2"></i> Xử lý yêu cầu hủy</h6>
                <div class="policy-box mb-3 p-3 rounded" style="background:#fff6f6; border:1px solid #fde2e2;">
                    <small class="text-muted">CHÍNH SÁCH ÁP DỤNG</small>
                    <p class="mb-1"><small>Hủy trước 15–30 ngày khởi hành</small></p>
                    <p class="mb-0"><small>Phí hủy: <strong class="text-danger">30% Tổng giá trị</strong></small></p>
                    <p class="mb-0"><small>Hoàn trả: <strong class="text-success">70% Tổng giá trị</strong></small></p>
                </div>

                <div class="mb-3">
                    <label class="form-label mb-1">Số tiền hoàn (Tự động)</label>
                    <div class="refund-amount p-3 rounded bg-light text-success fw-bold" id="refundAmount">0 đ</div>
                    <small class="text-muted">Dựa trên <span id="totalPriceText">
                            <?= number_format($bookingDetail['total_price'] ?? 0, 0, ',', '.') ?>
                        </span></small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lý do khách hủy</label>
                    <textarea id="reason" class="form-control" rows="3" placeholder="Lý do khách hủy"
                        readonly><?= htmlspecialchars($bookingDetail['note'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú xử lý (Nội bộ)</label>
                    <textarea id="adminNote" class="form-control" name="admin_note" rows="3"
                        placeholder="Nhập ghi chú cho kế toán..."></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-danger" id="approveRefund">Phê duyệt hoàn tiền</button>
                    <button type="button" class="btn btn-outline-secondary" id="rejectRequest">Từ chối / Liên hệ
                        lại</button>
                </div>

            </div>
        </div>
    </aside>
</div>

<script>
    (function () {
        const total = <?= (float) ($bookingDetail['total_price'] ?? 0) ?>;
        const refundEl = document.getElementById('refundAmount');
        const totalText = document.getElementById('totalPriceText');
        function formatVND(n) { return n.toLocaleString('vi-VN') + ' đ'; }
        const autoRefund = Math.round(total * 0.7);
        if (refundEl) refundEl.textContent = formatVND(autoRefund);
        if (totalText) totalText.textContent = formatVND(total);

        const approveBtn = document.getElementById('approveRefund');
        const rejectBtn = document.getElementById('rejectRequest');
        const form = document.getElementById('admin-detail-form');
        approveBtn && approveBtn.addEventListener('click', function () {
            if (!confirm('Xác nhận phê duyệt hoàn tiền cho booking này?')) return;
            let action = document.createElement('input'); action.type = 'hidden'; action.name = 'admin_action'; action.value = 'approve'; form.appendChild(action);
            let refund = document.createElement('input'); refund.type = 'hidden'; refund.name = 'refund_amount'; refund.value = autoRefund; form.appendChild(refund);
            form.method = 'post'; form.action = '<?= route('BookingAdmin.processCancel'); ?>'; form.submit();
        });
        rejectBtn && rejectBtn.addEventListener('click', function () {
            if (!confirm('Xác nhận từ chối yêu cầu hủy này?')) return;
            let action = document.createElement('input'); action.type = 'hidden'; action.name = 'admin_action'; action.value = 'reject'; form.appendChild(action);
            form.method = 'post'; form.action = '<?= route('BookingAdmin.processCancel'); ?>'; form.submit();
        });
    })();
</script>