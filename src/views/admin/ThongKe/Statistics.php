<link rel="stylesheet" href="/web_du_lich/public/css/Statistics.css">

<!-- Chọn năm -->
<div class="year-selector-wrapper mb-4">
    <label for="yearSelect" class="form-label mb-0 fw-bold">Chọn năm:</label>
    <select id="yearSelect" class="form-select form-select-sm year-selector" style="max-width: 180px;">
        <?php
        foreach ($stats['availableYears'] as $year) {
            $selected = ($year == $stats['selectedYear']) ? 'selected' : '';
            echo "<option value='$year' $selected>Năm $year</option>";
        }
        ?>
    </select>
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
                <p class="text-muted small fw-bold text-uppercase mb-1">Tổng doanh thu (<?= $stats['selectedYear'] ?>)</p>
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
                <p class="text-muted small fw-bold text-uppercase mb-1">Tổng Booking (<?= $stats['selectedYear'] ?>)</p>
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

<div class="row mb-4">
    <div class="col-12 col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="card-title mb-1">Biểu đồ doanh thu năm <?= $stats['selectedYear'] ?></h5>
                        <p class="text-muted small">Thống kê chi tiết lợi nhuận theo từng tháng</p>
                    </div>
                </div>

                <div style="flex-grow: 1; display: flex; align-items: center;">
                    <canvas id="revenueChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title mb-1">Phân bố đơn đặt chỗ</h5>
                <p class="text-muted small">Tỉ lệ phần trăm các booking theo trạng thái năm <?= $stats['selectedYear'] ?></p>

                <div class="pie-chart-container" style="flex-grow: 1; display: flex; align-items: center; justify-content: center;">
                    <canvas id="statusChart" style="max-height: 300px;"></canvas>
                </div>

                <div style="margin-top: 30px;">
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
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h5 class="card-title mb-1">Top 3 tour được đặt nhiều nhất năm <?= $stats['selectedYear'] ?></h5>
                <p class="text-muted small">Xếp hạng dựa trên dữ liệu booking thực tế</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0 table-large">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 60px;">
                            <small class="text-muted fw-bold text-uppercase">Hạng</small>
                        </th>
                        <th style="width: auto;">
                            <small class="text-muted fw-bold text-uppercase">Tên tour</small>
                        </th>
                        <th class="text-center" style="width: 140px;">
                            <small class="text-muted fw-bold text-uppercase">Số lượt đặt</small>
                        </th>
                        <th class="text-end" style="width: 140px;">
                            <small class="text-muted fw-bold text-uppercase">Tổng doanh thu</small>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $rank = 1; ?>
                    <?php if (!empty($stats['topTours'])): ?>
                        <?php foreach ($stats['topTours'] as $tour): ?>
                            <tr class="tour-row-clickable" onclick="window.location.href='<?= route('ListTour.details', ['id' => $tour['id']]) ?>'">
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
                                                    style="width: 56px; height: 56px; object-fit: cover; border-radius: 6px;">
                                            <?php else: ?>
                                                <i class="fas fa-image"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark" style="font-size: 16px;"><?= htmlspecialchars($tour['name']) ?></div>
                                            <small class="text-muted" style="font-size: 13px;">Mã tour: <?= htmlspecialchars($tour['code']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <span class="fw-bold text-dark" style="font-size: 16px;"><?= $tour['bookings'] ?></span>
                                        <?php if ($tour['trend'] !== null): ?>
                                            <small class="text-<?= $tour['trend'] >= 0 ? 'success' : 'danger' ?> fw-semibold" style="font-size: 13px;">
                                                <i class="fas fa-arrow-<?= $tour['trend'] >= 0 ? 'up' : 'down' ?>"></i>
                                                <?= $tour['trend'] > 0 ? '+' : '' ?><?= $tour['trend'] ?>%
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 2px;">
                                        <div class="fw-bold" style="font-size: 18px; color: #1e40af;">
                                            <?= number_format($tour['revenue'], 0, ',', '.') ?>
                                        </div>
                                        <span class="text-muted" style="font-size: 12px;">VNĐ</span>
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
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Pass data to JavaScript and initialize charts -->
<script>
    window.monthlyData = <?= json_encode($stats['monthlyRevenue']) ?>;
    window.statusData = <?= json_encode($stats['bookingStatus']) ?>;
</script>

<script src="/web_du_lich/public/js/admin/Statistics.js"></script>