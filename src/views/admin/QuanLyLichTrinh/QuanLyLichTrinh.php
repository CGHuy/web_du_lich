<div class="card-header d-flex justify-content-between align-items-center p-0 px-4">
    <div>
        <h5 class="card-title">
            <i class="fa-solid fa-route me-2"></i>Quản lý Lịch trình Tour
        </h5>
    </div>
    <div class="text-end mb-2">
        <?php
            $count = 0;
            foreach ($tours as $tour) {
                if ($tour['has_itinerary']) {
                    $count++;
                }
            }
        ?>
        <span class="badge bg-info">Tổng: <?= $count ?> tour đã có lịch trình</span>
    </div>
</div>
<div class="card-body">
    <div class="input-group search-group mb-3">
        <span class="input-group-text search-icon">
            <i class="fa-solid fa-magnifying-glass fa-sm"></i>
        </span>
        <input class="form-control search-input" placeholder="Tìm kiếm tour theo id, tên..." value="" aria-label="Tìm kiếm" />
    </div>
    <ul class="list-group list-group-flush" id="tour-itinerary-list">
        <?php if (!empty($tours)): ?>
            <?php foreach ($tours as $tour): ?>
                <li class="list-group-item p-3 hover-shadow">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-secondary find_id"><?= htmlspecialchars($tour['tour_code']) ?></span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 find_name"><?= htmlspecialchars($tour['name']) ?></h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <?php if ($tour['has_itinerary']): ?>
                                            <span class="text-success"><i class="fas fa-check-circle me-1"></i> Đã có lịch trình</span>
                                        <?php else: ?>
                                            <span class="text-warning"><i class="fas fa-exclamation-circle me-1"></i> Chưa có lịch trình</span>
                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button 
                                class="btn btn-sm open-itinerary-modal <?= $tour['has_itinerary'] ? 'btn-outline-primary' : 'btn-primary' ?>"
                                data-tour-id="<?= $tour['id'] ?>"
                                data-tour-name="<?= htmlspecialchars($tour['name']) ?>"
                                data-action-name="<?= $tour['has_itinerary'] ? 'Sửa' : 'Thêm' ?>"
                                data-form-url="<?= route('TourItinerary.getForm', ['tour_id' => $tour['id']]) ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#itineraryModal"
                            >
                                <?php if ($tour['has_itinerary']): ?>
                                    <i class="fas fa-edit"></i> Chỉnh sửa
                                <?php else: ?>
                                    <i class="fas fa-plus"></i> Thêm mới
                                <?php endif; ?>
                            </button>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted mb-0">Chưa có tour nào. Vui lòng thêm tour trước.</p>
            </li>
        <?php endif; ?>
    </ul>
</div>

<!-- Modal để chứa form - Body sẽ được load động từ server -->
<div class="modal fade" id="itineraryModal" tabindex="-1" aria-labelledby="itineraryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itineraryModalLabel">Lịch trình Tour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0">
                <!-- Form sẽ được load động từ server -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Đang tải...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/web_du_lich/public/js/admin/QuanLyLichTrinh.js"></script>