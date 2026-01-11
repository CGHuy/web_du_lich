<div class="card-header d-flex justify-content-between align-items-center p-0 px-4">
    <div>
        <h5 class="card-title">
            <i class="fa-solid fa-plane-departure me-2"></i>Quản lý Điểm Khởi Hành
        </h5>
    </div>
    <div class="text-end mb-2">
        <span class="badge bg-info">Tổng: <?= count($departures ?? []) ?> điểm khởi hành</span>
    </div>
</div>
<div class="card-body">
    <div class="input-group search-group mb-3">
        <span class="input-group-text search-icon">
            <i class="fa-solid fa-magnifying-glass fa-sm"></i>
        </span>
        <input class="form-control search-input" id="searchTourDeparture" placeholder="Tìm kiếm điểm khởi hành theo id, tên, địa điểm..." value="" aria-label="Tìm kiếm" />
    </div>
    <button class="btn btn-primary mb-3" id="addTourDepartureBtn">Thêm Điểm Khởi Hành Mới</button>
    <div class="list-group">
        <?php if (!empty($departures)): ?>
            <?php foreach ($departures as $departure): ?>
                <div class="list-group-item mb-3 p-3 border rounded shadow-sm d-flex align-items-center tour-departure-item">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1 fw-bold find_name"><?= htmlspecialchars($departure['departure_code']) ?></h5>
                                <small class="text-muted find_id">ID: <?= htmlspecialchars($departure['id']) ?></small>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary edit-tour-departure-btn"
                                    data-id="<?= $departure['id'] ?>">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Sửa
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-tour-departure-btn"
                                    data-id="<?= $departure['id'] ?>"
                                    data-name="<?= htmlspecialchars($departure['departure_code']) ?>">
                                    <i class="fa-solid fa-trash me-1"></i> Xóa
                                </button>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between text-muted small">
                            <span class="d-flex align-items-center">
                                <i class="fa-solid fa-plane-departure me-2"></i>
                                <strong class="me-1">Địa điểm:</strong>
                                <span class="find_location"><?= htmlspecialchars($departure['departure_location']) ?></span>
                            </span>
                            <span class="d-flex align-items-center">
                                <i class="fa-solid fa-calendar me-2"></i>
                                <strong class="me-1">Ngày:</strong>
                                <span><?= htmlspecialchars($departure['departure_date']) ?></span>
                            </span>
                            <span class="d-flex align-items-center">
                                <i class="fa-solid fa-tag me-2"></i>
                                <strong class="me-1">Giá:</strong>
                                <span><?= number_format($departure['price_moving']) ?> VNĐ</span>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Không có điểm khởi hành nào.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal thêm/sửa Điểm Khởi Hành -->
<div class="modal fade" id="tourDepartureModal" tabindex="-1" aria-labelledby="tourDepartureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tourDepartureModalLabel">Thêm Điểm Khởi Hành</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0 pt-0">
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

<script src="/web_du_lich/public/js/admin/QuanLyTourDeparture.js"></script>