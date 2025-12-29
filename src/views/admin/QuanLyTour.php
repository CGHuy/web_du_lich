<div class="card-header d-flex justify-content-between align-items-center p-0 px-4">
    <div>
        <h5 class="card-title">Quản lý Tour</h5>
    </div>
</div>
<div class="card-body">
    <div class="input-group search-group mb-3">
        <span class="input-group-text search-icon">
            <i class="fa-solid fa-magnifying-glass fa-sm"></i>
        </span>
        <input class="form-control search-input" placeholder="Tìm kiếm tour theo id, tên, địa điểm..." value="" aria-label="Tìm kiếm" />
    </div>
    <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTourModal">Thêm Tour Mới</a>
    <div class="list-group">
        <?php if (!empty($tours)): ?>
            <?php foreach ($tours as $tour): ?>
                <div class="list-group-item mb-3 p-3 border rounded shadow-sm d-flex align-items-center">
                    <img src="data:image/jpeg;base64,<?= base64_encode($tour['cover_image']) ?>" alt="<?= htmlspecialchars($tour['name']) ?>" style="width: 150px; height: 120px; object-fit: cover; border-radius: 8px;">
                    <div class="flex-grow-1 ms-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1 fw-bold find_name"><?= htmlspecialchars($tour['name']) ?></h5>
                                <small class="text-muted find_id">ID: <?= htmlspecialchars($tour['tour_code']) ?></small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#viewTourModal"
                                    data-id="<?= $tour['id'] ?>">
                                    <i class="fa-solid fa-eye me-1"></i> Xem
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTourModal" 
                                    data-id="<?= $tour['id'] ?>">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Sửa
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteTourModal"
                                    data-id="<?= $tour['id'] ?>"
                                    data-name="<?= htmlspecialchars($tour['name']) ?>">   
                                    <i class="fa-solid fa-trash me-1"></i> Xóa
                                </a>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between text-muted small">
                            <span class="d-flex align-items-center">
                                <i class="fa-solid fa-location-dot me-2"></i>
                                <strong class="me-1">Địa điểm:</strong>
                                <span class="find_location"><?= htmlspecialchars($tour['location']) ?></span>
                            </span>
                            <span class="d-flex align-items-center"><i class="fa-solid fa-map me-2"></i><strong class="me-1">Miền:</strong> <?= htmlspecialchars($tour['region']) ?></span>
                            <span class="d-flex align-items-center"><i class="fa-solid fa-tag me-2"></i><strong class="me-1">Giá:</strong> <?= number_format($tour['price_default']) ?> VNĐ</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Không có tour nào.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Thêm Tour -->
<div class="modal fade" id="addTourModal" tabindex="-1" aria-labelledby="addTourModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTourModalLabel">Thêm Tour Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Nội dung form sẽ được load động -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Đang tải form...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sửa Tour -->
<div class="modal fade" id="editTourModal" tabindex="-1" aria-labelledby="editTourModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTourModalLabel">Sửa Tour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0">
                <!-- Nội dung form sẽ được load động -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Đang tải form...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Xóa Tour -->
<div class="modal fade" id="deleteTourModal" tabindex="-1" aria-labelledby="deleteTourModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteTourModalLabel">Xác nhận xóa tour</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form method="post" action="<?= route('tour.delete') ?>">
                <input type="hidden" name="id" id="delete_id">

                <div class="modal-body">
                    <p class="m-0 p-2">Bạn có chắc chắn muốn xóa tour:</p>
                    <strong id="delete_name" class="p-2"></strong>
                    <p class="text-danger m-0 p-2"><strong>Hành động này không thể hoàn tác.</strong></p>
                </div>

                <div class="modal-footer pb-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Xem Tour -->
<div class="modal fade" id="viewTourModal" tabindex="-1" aria-labelledby="viewTourModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTourModalLabel">Chi Tiết Tour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0">
                <!-- Nội dung chi tiết tour sẽ được tải động bằng JavaScript hoặc AJAX -->
                <p>Đang tải chi tiết tour...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script src="/web_du_lich/public/js/admin/QuanLyTour.js"></script>