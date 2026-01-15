<div class="card-header d-flex justify-content-between align-items-center p-0 px-4">
    <div>
        <h5 class="card-title">
            <i class="fa-solid fa-calendar-check me-2"></i>Quản lý Booking
        </h5>
        <p style="color: #636465ff;">Danh sách các booking mà các khách hàng đã đặt </p>
    </div>
</div>
<div class="card-body position-relative">
    <form method="post" action="<?= route('BookingAdmin.index'); ?>">
        <?php $status = $status ?? ($_REQUEST['sort'] ?? ''); ?>
        <div class="d-flex justify-content-between align-items-center mb-3 gap-3">
            <div class="input-group search-group w-50">
                <span class="input-group-text search-icon">
                    <i class="fa-solid fa-magnifying-glass fa-sm"></i>
                </span>
                <input class="form-control search-input" name="search"
                    placeholder="Tìm kiếm booking theo mã, tên khách hàng, tên tour..."
                    value="<?= htmlspecialchars($_REQUEST['search'] ?? '') ?>" aria-label="Tìm kiếm"
                    onkeyup="if(event.key === 'Enter') this.form.submit();" />
            </div>
            <div class="d-flex align-items-center">
                <label for="" class="me-2" style="margin-bottom:0;">Sắp xếp</label>
                <select name="sort" class="custom-combobox" onchange="this.form.submit()">
                    <!-- View nhận $bookings đã lọc từ controller, trả về đúng trạng thái combobox đã chọn -->
                    <option value="" <?= empty($status) ? 'selected' : '' ?>>Tất cả</option>
                    <option value="confirmed" <?= ($status ?? '') === 'confirmed' ? 'selected' : '' ?>>Đã xác
                        nhận</option>
                    <option value="pending_cancellation" <?= ($status ?? '') === 'pending_cancellation' ? 'selected' : '' ?>>Yêu cầu
                        hủy</option>
                    <option value="cancelled" <?= ($status ?? '') === 'cancelled' ? 'selected' : '' ?>>Đã hủy
                    </option>
                </select>
            </div>
        </div>
</div>
<div class="table-container">
    <div class="table-wrapper">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 140px;">Mã Booking</th>
                    <th style="width: 220px;">Tên Khách Hàng</th>
                    <th style="width: 260px;">Tên Tour</th>
                    <th style="width: 150px;">Ngày Khởi Hành</th>
                    <th style="width: 170px;">Tổng Tiền</th>
                    <th style="width: 140px;">Trạng Thái</th>
                    <th style="width: 160px;">Ngày Đặt</th>
                    <th style="width: 120px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="8" class="text-center">Không có booking nào</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bookings as $index => $booking): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['booking_code'] ?? $booking['id']) ?></td>
                            <td><?= htmlspecialchars($booking['user_name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($booking['tour_name'] ?? $booking['tour_id']) ?></td>
                            <td><?= date('d/m/Y', strtotime($booking['departure_date'] ?? $booking['booking_date'])) ?>
                            </td>
                            <td><?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?> đ</td>
                            <td>
                                <?php
                                $statusBadge = [
                                    'pending_cancellation' => '<span class="badge bg-warning">Yêu cầu hủy</span>',
                                    'confirmed' => '<span class="badge bg-success">Đã xác nhận</span>',
                                    'cancelled' => '<span class="badge bg-danger">Đã hủy</span>'
                                ];
                                $statusKey = $booking['booking_status'] ?? $booking['status'] ?? '';
                                echo $statusBadge[$statusKey] ?? htmlspecialchars($statusKey);
                                ?>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($booking['created_at'] ?? $booking['booking_date'])) ?>
                            </td>
                            <td>
                                <a href="<?= route('BookingAdmin.detail', ['id' => $booking['id']]); ?>"
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
</form>
</div>