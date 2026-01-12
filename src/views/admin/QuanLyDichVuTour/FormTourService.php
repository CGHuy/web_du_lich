<form action="<?= route('TourService.save')?>" method="POST" id="service-form">
    <input type="hidden" name="tour_id" id="form-tour-id" value="<?= htmlspecialchars($tour['id']) ?>">
    
    <div class="modal-body">
        <div class="input-group search-group mb-3">
            <span class="input-group-text search-icon">
                <i class="fa-solid fa-magnifying-glass fa-sm"></i>
            </span>
            <input id="service-search-input" class="form-control" placeholder="Tìm kiếm dịch vụ theo id, tên..." value="" aria-label="Tìm kiếm" />
        </div>
        <div id="services-container">
            <?php if (!empty($allServices)): ?>
                <?php foreach ($allServices as $service): ?>
                        <div class="form-check mb-3 p-3 border rounded bg-light service-item" 
                            data-service-id="<?= htmlspecialchars($service['service_code'] ?? $service['id']) ?>" 
                            data-service-name="<?= htmlspecialchars(strtolower($service['name'])) ?>">
                            <input 
                                class="form-check-input service-checkbox" 
                                type="checkbox" 
                                name="services[]" 
                                value="<?= $service['id'] ?>"
                                id="service<?= $service['id'] ?>"
                                <?= in_array($service['id'], array_column($tourServices, 'service_id')) ? 'checked' : '' ?>
                            >
                            <label class="form-check-label w-100 cursor-pointer" for="service<?= $service['id'] ?>">
                                <strong><?= htmlspecialchars($service['name']) ?></strong>
                                <br>
                                <small class="text-muted">Mã dịch vụ: <?= htmlspecialchars($service['service_code'] ?? 'N/A') ?></small>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($service['description'] ?? 'Không có mô tả') ?></small>
                            </label>
                        </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Chưa có dịch vụ nào. 
                        <a href="<?= route('Service.index'); ?>" target="_blank">Thêm dịch vụ</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="modal-footer p-3 pb-0">
        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-save me-1"></i> Lưu Dịch vụ
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Hủy
        </button>
    </div>
</form>

<style>
     .cursor-pointer {
          cursor: pointer;
     }
</style>
