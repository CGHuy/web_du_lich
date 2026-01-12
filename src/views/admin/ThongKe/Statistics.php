<style>
    .stat-card {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-icon.revenue {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .stat-icon.booking {
        background-color: #e8f5e9;
        color: #388e3c;
    }

    .stat-icon.tour {
        background-color: #fff3e0;
        color: #f57c00;
    }

    .trend-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .trend-up {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .trend-down {
        background-color: #ffebee;
        color: #c62828;
    }

    .trend-neutral {
        background-color: #f5f5f5;
        color: #616161;
    }

    .status-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .status-item:last-child {
        border-bottom: none;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin-right: 8px;
    }

    .table-rank-badge {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
    }

    .rank-1 {
        background-color: #fef3c7;
        color: #d97706;
    }

    .rank-2 {
        background-color: #f3f4f6;
        color: #6b7280;
    }

    .rank-3 {
        background-color: #fed7aa;
        color: #ea580c;
    }

    .tour-img-placeholder {
        width: 48px;
        height: 48px;
        background-color: #f5f5f5;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
    }

    .update-badge {
        display: inline-block;
        background-color: #dbeafe;
        color: #1e40af;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .year-selector-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .year-selector {
        min-width: 150px;
    }
</style>

<!-- Chọn năm -->
<div class="year-selector-wrapper mb-4">
    <label for="yearSelect" class="form-label mb-0 fw-bold">Chọn năm:</label>
    <select id="yearSelect" class="form-select form-select-sm year-selector" style="max-width: 180px;">
        <?php
        $currentYear = date('Y');
        $startYear = 2024;
        for ($year = $currentYear; $year >= $startYear; $year--) {
            $selected = ($year == $stats['selectedYear']) ? 'selected' : '';
            echo "<option value='$year' $selected>Năm $year</option>";
        }
        ?>
    </select>
</div>

<script>
    document.getElementById('yearSelect').addEventListener('change', function() {
        // Lấy URL hiện tại và thêm/cập nhật query parameter 'year'
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('year', this.value);
        window.location.href = currentUrl.toString();
    });
</script>

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
    <div class="col-12 col-lg-8 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h5 class="card-title mb-1">Biểu đồ doanh thu năm <?= $stats['selectedYear'] ?></h5>
                        <p class="text-muted small">Thống kê chi tiết lợi nhuận theo từng tháng</p>
                    </div>
                </div>

                <canvas id="revenueChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-1">Phân bố đơn đặt chỗ</h5>
                <p class="text-muted small">Tỉ lệ phần trăm các booking theo trạng thái năm <?= $stats['selectedYear'] ?></p>

                <div class="pie-chart-container">
                    <canvas id="statusChart"></canvas>
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
    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Top 3 tour được đặt nhiều nhất năm <?= $stats['selectedYear'] ?></h5>
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
    const monthlyData = <?= json_encode($stats['monthlyRevenue']) ?>;
    const months = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'];
    const revenues = monthlyData.map(d => d.value);

    // Biểu đồ doanh thu (Bar Chart)
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: revenues,
                backgroundColor: '#1976d2',
                borderColor: '#1565c0',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: '#1565c0'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return (value / 1000000).toFixed(0) + 'M';
                        }
                    }
                }
            }
        }
    });

    // Biểu đồ phân bố đơn đặt chỗ (Doughnut Chart)
    const statusData = <?= json_encode($stats['bookingStatus']) ?>;
    const statusCtx = document.getElementById('statusChart').getContext('2d');

    const confirmed = statusData.confirmed.count;
    const pendingCancellation = statusData.pending_cancellation.count;
    const cancelled = statusData.cancelled.count;

    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Đã xác nhận', 'Chờ hủy', 'Đã hủy'],
            datasets: [{
                data: [confirmed, pendingCancellation, cancelled],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderColor: ['#059669', '#d97706', '#dc2626'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' đơn';
                        }
                    }
                }
            }
        }
    });
</script>