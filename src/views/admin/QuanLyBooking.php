<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h5 class="card-title">Quản lý Booking</h5>
        <p style="color: #636465ff;">Danh sách các booking</p>
    </div>
    <a href="#" class="btn btn-primary btn-sm">Thêm Booking Mới</a>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Tour ID</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['id']) ?></td>
                            <td><?= htmlspecialchars($booking['user_id']) ?></td>
                            <td><?= htmlspecialchars($booking['tour_id']) ?></td>
                            <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                            <td>
                                <span class="status-label status-success">Đã xác nhận</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Sửa</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có booking nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>