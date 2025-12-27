<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h5 class="card-title">Quản lý Booking</h5>
        <p style="color: #636465ff;">Danh sách các booking</p>
    </div>
</div>
<div class="card-body position-relative">
    <form method="get" action="<?= route('BookingAdmin.index'); ?>">
        <input type="hidden" name="page" value="1">
        <?php $status = $status ?? ($_REQUEST['sort'] ?? ''); ?>
        <div class="d-flex justify-content-end mb-3">
            <div class="d-flex align-items-center" style="gap: 10px;">
                <label for="" style="margin-bottom:0;">Sắp xếp</label>
                <select name="sort" class="custom-combobox" onchange="this.form.submit()">
                    <option value="" <?= empty($status) ? 'selected' : '' ?>>Tất cả</option>
                    <option value="status-warning" <?= ($status ?? '') === 'status-warning' ? 'selected' : '' ?>>Chờ xác
                        nhận</option>
                    <option value="status-success" <?= ($status ?? '') === 'status-success' ? 'selected' : '' ?>>Đã xác
                        nhận</option>
                    <option value="status-danger" <?= ($status ?? '') === 'status-danger' ? 'selected' : '' ?>>Đã hủy
                    </option>
                </select>
            </div>
        </div>
        <div class="table-container">
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã Booking</th>
                            <th>Tên Khách Hàng</th>
                            <th>Tên Tour</th>
                            <th>Ngày Khởi Hành</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Đặt</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($bookings)): ?>
                            <tr>
                                <td colspan="9" class="text-center">Không có booking nào</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($bookings as $index => $booking): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= htmlspecialchars($booking['booking_code'] ?? $booking['id']) ?></td>
                                    <td><?= htmlspecialchars($booking['user_name'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($booking['tour_name'] ?? $booking['tour_id']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($booking['departure_date'] ?? $booking['booking_date'])) ?>
                                    </td>
                                    <td><?= number_format($booking['total_price'] ?? 0, 0, ',', '.') ?> đ</td>
                                    <td>
                                        <?php
                                        $statusBadge = [
                                            'pending' => '<span class="badge bg-warning">Chờ xác nhận</span>',
                                            'confirmed' => '<span class="badge bg-success">Đã xác nhận</span>',
                                            'cancelled' => '<span class="badge bg-danger">Đã hủy</span>'
                                        ];
                                        echo $statusBadge[$booking['booking_status'] ?? $booking['status']] ?? '<span class="badge bg-secondary">Không rõ</span>';
                                        ?>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($booking['created_at'] ?? $booking['booking_date'])) ?>
                                    </td>
                                    <td>
                                        <a href="<?= route('admin.bookingDetail', ['id' => $booking['id']]); ?>"
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
    <div class="d-flex justify-content-end mt-3">
        <nav aria-label="Page navigation">
            <ul class="pagination mb-0">
                <?php
                $currentPage = isset($page) ? (int) $page : 1;
                $totalPages = isset($totalPages) ? (int) $totalPages : 1;
                $prevPage = max(1, $currentPage - 1);
                $nextPage = min($totalPages, $currentPage + 1);
                $baseUrl = route('BookingAdmin.index');
                $sortParam = isset($status) && $status ? $status : null;
                $buildHref = function ($p) use ($baseUrl, $sortParam) {
                    $qs = ['page' => $p];
                    if ($sortParam)
                        $qs['sort'] = $sortParam;
                    $query = http_build_query($qs);
                    $sep = (strpos($baseUrl, '?') === false) ? '?' : '&';
                    return $baseUrl . $sep . $query;
                };
                ?>
                <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $buildHref($prevPage) ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="<?= $buildHref($i) ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= $buildHref($nextPage) ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>