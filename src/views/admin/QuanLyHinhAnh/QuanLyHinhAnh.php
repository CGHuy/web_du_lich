<div class="card-header d-flex justify-content-between align-items-center p-0 px-4">
    <div>
        <h5 class="card-title">
            <i class="fa-solid fa-image me-2"></i>Quản lý Hình ảnh Tour
        </h5>
    </div>
    <div class="text-end mb-2">
        <?php
        $count = 0;
        foreach ($tours as $tour) {
            // assume each tour may have images
            if (!empty($tour['has_images'])) {
                $count++;
            }
        }
        ?>
        <span class="badge bg-info">Tổng: <?= $count ?> tour có ảnh</span>
    </div>
</div>
<div class="card-body">
    <div class="input-group search-group mb-3">
        <span class="input-group-text search-icon">
            <i class="fa-solid fa-magnifying-glass fa-sm"></i>
        </span>
        <input class="form-control search-input" placeholder="Tìm kiếm tour theo id, tên..." value="" aria-label="Tìm kiếm" />
    </div>
    <ul class="list-group list-group-flush" id="tour-image-list">
        <?php if (!empty($tours)): ?>
            <?php foreach ($tours as $tour): ?>
                <li class="list-group-item p-3 hover-shadow">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-start align-items-center">
                                <div class="me-3">
                                    <span class="badge bg-secondary"><?= htmlspecialchars($tour['tour_code']) ?></span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= htmlspecialchars($tour['name']) ?></h6>
                                    <small class="text-muted">
                                        <i class="fas fa-images me-1"></i>
                                        <?php if (!empty($tour['has_images'])): ?>
                                            <span class="text-success"><i class="fas fa-check-circle me-1"></i> Có ảnh</span>
                                        <?php else: ?>
                                            <span class="text-warning"><i class="fas fa-exclamation-circle me-1"></i> Chưa có ảnh</span>
                                        <?php endif; ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <button 
                                class="btn btn-sm btn-outline-primary open-images-modal"
                                data-tour-id="<?= $tour['id'] ?>"
                                data-tour-name="<?= htmlspecialchars($tour['name']) ?>"
                                data-form-url="<?= route('TourImage.getForm', ['tour_id' => $tour['id']]) ?>"
                                data-bs-toggle="modal"
                                data-bs-target="#imagesModal"
                            >
                                <i class="fas fa-images"></i> Quản lý ảnh
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
<div class="modal fade" id="imagesModal" tabindex="-1" aria-labelledby="imagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagesModalLabel">Hình ảnh Tour</h5>
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

<script src="/web_du_lich/public/js/admin/QuanLyHinhAnh.js"></script>
