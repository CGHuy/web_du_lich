<?php
$currentYear = isset($_GET['year']) ? (int)$_GET['year'] : ($stats['availableYears'][0] ?? date('Y'));
$yearList = $stats['availableYears'] ?? [];
?>

<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Thống kê năm <?= $currentYear ?></h4>
        </div>
        <div>
            <select id="yearSelector" class="form-select" style="width: 150px;">
                <?php foreach ($yearList as $y): ?>
                    <option value="<?= $y ?>" <?= $y == $currentYear ? 'selected' : '' ?>>Năm <?= $y ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="card stat-card h-100" style="border-left-color: #1976d2;">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="stat-icon revenue">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <span class="trend-badge trend-<?= $stats['totalRevenue']['status'] ?>">
                        <i class="fas fa-arrow-<?= $stats['totalRevenue']['status'] === 'up' ? 'up' : ($stats['totalRevenue']['status'] === 'down' ? 'down' : 'right') ?>"></i>
                        <?= $stats['totalRevenue']['trend'] > 0 ? '+' : '' ?><?= $stats['totalRevenue']['trend'] ?>%
                    </span>
                </div>
                <p class="text-muted small fw-bold text-uppercase mb-1">Tổng doanh thu (<?= $currentYear ?>)</p>
                <h3 class="mb-0">
                    <?= number_format($stats['totalRevenue']['value'], 0, ',', '.') ?>
                    <span class="text-muted small fw-normal">VNĐ</span>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="card stat-card h-100" style="border-left-color: #388e3c;">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="stat-icon booking">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span class="trend-badge trend-<?= $stats['totalBookings']['status'] ?>">
                        <i class="fas fa-arrow-<?= $stats['totalBookings']['status'] === 'up' ? 'up' : ($stats['totalBookings']['status'] === 'down' ? 'down' : 'right') ?>"></i>
                        <?= $stats['totalBookings']['trend'] > 0 ? '+' : '' ?><?= $stats['totalBookings']['trend'] ?>%
                    </span>
                </div>
                <p class="text-muted small fw-bold text-uppercase mb-1">Tổng Booking (<?= $currentYear ?>)</p>
                <h3 class="mb-0"><?= $stats['totalBookings']['value'] ?></h3>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="card stat-card h-100" style="border-left-color: #f57c00;">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="stat-icon tour">
                        <i class="fas fa-map"></i>
                    </div>
                    <span class="trend-badge trend-neutral">
                        <i class="fas fa-minus"></i> 0%
                    </span>
                </div>
                <p class="text-muted small fw-bold text-uppercase mb-1">Tổng số Tour</p>
                <h3 class="mb-0"><?= $stats['totalTours']['value'] ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4 chart-row">
    <div class="col-12 col-lg-8 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="chart-header">
                    <h5 class="card-title mb-1">Biểu đồ doanh thu năm <?= $currentYear ?></h5>
                    <p class="text-muted small">Thống kê chi tiết lợi nhuận theo từng tháng</p>
                </div>

                <div class="chart-wrapper">
                    <div class="revenue-chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="chart-header">
                    <h5 class="card-title mb-1">Phân bố đơn đặt chỗ</h5>
                    <p class="text-muted small">Tỉ lệ phần trăm các booking theo trạng thái năm <?= $currentYear ?></p>
                </div>

                <div class="chart-wrapper">
                    <div class="pie-chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="chart-status-list">
                    <div class="status-item">
                        <div class="d-flex align-items-center">
                            <span class="status-dot" style="background-color: #10b981;"></span>
                            <small class="text-muted fw-medium">Đã xác nhận</small>
                        </div>
                        <small class="fw-bold"><?= $stats['bookingStatus']['confirmed']['count'] ?> đơn (<?= $stats['bookingStatus']['confirmed']['percentage'] ?>%)</small>
                    </div>
                    <div class="status-item">
                        <div class="d-flex align-items-center">
                            <span class="status-dot" style="background-color: #f59e0b;"></span>
                            <small class="text-muted fw-medium">Chờ hủy</small>
                        </div>
                        <small class="fw-bold"><?= $stats['bookingStatus']['pending_cancellation']['count'] ?> đơn (<?= $stats['bookingStatus']['pending_cancellation']['percentage'] ?>%)</small>
                    </div>
                    <div class="status-item">
                        <div class="d-flex align-items-center">
                            <span class="status-dot" style="background-color: #ef4444;"></span>
                            <small class="text-muted fw-medium">Đã hủy</small>
                        </div>
                        <small class="fw-bold"><?= $stats['bookingStatus']['cancelled']['count'] ?> đơn (<?= $stats['bookingStatus']['cancelled']['percentage'] ?>%)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Top 3 tour được đặt nhiều nhất năm <?= $currentYear ?></h5>
            <p class="text-muted small mt-1 mb-0">Xếp hạng dựa trên dữ liệu booking thực tế</p>
        </div>
        <span class="update-badge">Cập nhật vừa xong</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="text-center" style="width: 80px;">
                        <small class="text-muted fw-bold text-uppercase">Hạng</small>
                    </th>
                    <th>
                        <small class="text-muted fw-bold text-uppercase">Tên tour</small>
                    </th>
                    <th>
                        <small class="text-muted fw-bold text-uppercase">Số lượt đặt (Booking)</small>
                    </th>
                    <th class="text-end">
                        <small class="text-muted fw-bold text-uppercase">Tổng doanh thu</small>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $rank = 1; ?>
                <?php if (!empty($stats['topTours'])): ?>
                    <?php foreach ($stats['topTours'] as $tour): ?>
                        <tr>
                            <td class="text-center">
                                <span class="table-rank-badge rank-<?= $rank ?>">
                                    <?= $rank ?>
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="tour-img-placeholder">
                                        <?php if ($tour['image']): ?>
                                            <img src="data:image/jpeg;base64,<?= base64_encode($tour['image']) ?>"
                                                alt="<?= htmlspecialchars($tour['name']) ?>"
                                                style="width: 48px; height: 48px; object-fit: cover; border-radius: 6px;">
                                        <?php else: ?>
                                            <i class="fas fa-image"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= htmlspecialchars($tour['name']) ?></div>
                                        <small class="text-muted">Mã tour: <?= htmlspecialchars($tour['code']) ?></small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold text-dark"><?= $tour['bookings'] ?></span>
                                    <small class="text-<?= $tour['trend'] >= 0 ? 'success' : 'danger' ?> fw-semibold">
                                        <i class="fas fa-arrow-<?= $tour['trend'] >= 0 ? 'up' : 'down' ?>"></i>
                                        <?= $tour['trend'] > 0 ? '+' : '' ?><?= $tour['trend'] ?>%
                                    </small>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="fw-bold text-primary">
                                    <?= number_format($tour['revenue'], 0, ',', '.') ?>
                                    <span class="text-muted small fw-normal">VNĐ</span>
                                </div>
                            </td>
                        </tr>
                        <?php $rank++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Không có dữ liệu</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dữ liệu biểu đồ doanh thu
    window.monthlyData = <?= json_encode($stats['monthlyRevenue']) ?>;
    window.statusData = <?= json_encode($stats['bookingStatus']) ?>;
</script>
<script src="js/admin/Statistics.js"></script>