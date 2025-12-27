<div class="card-header d-flex justify-content-between align-items-center p-0 px-4">
    <div>
        <h5 class="card-title">Quản lý Lịch trình</h5>
    </div>
</div>
<div class="card-body">
    <ul class="list-group" id="tour-itinerary-list">
        <?php if (!empty($tours)): ?>
            <?php foreach ($tours as $tour): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?= htmlspecialchars($tour['name']) ?></span>
                    <button 
                        class="btn btn-sm open-itinerary-modal <?= $tour['has_itinerary'] ? 'btn-outline-primary' : 'btn-primary' ?>"
                        data-tour-id="<?= $tour['id'] ?>"
                        data-tour-name="<?= htmlspecialchars($tour['name']) ?>"
                        data-action-name="<?= $tour['has_itinerary'] ? 'Sửa' : 'Thêm' ?>"
                    >
                        <?php if ($tour['has_itinerary']): ?>
                            <i class="fas fa-edit me-1"></i> Sửa Lịch Trình
                        <?php else: ?>
                            <i class="fas fa-plus me-1"></i> Thêm Lịch Trình
                        <?php endif; ?>
                    </button>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="list-group-item text-center">Chưa có tour nào. Vui lòng thêm tour trước.</li>
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

<script src="/web_du_lich/public/js/admin/QuanLyItinerary.js"></script>