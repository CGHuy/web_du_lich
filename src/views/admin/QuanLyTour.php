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
        <input class="form-control search-input" placeholder="Tìm kiếm tour theo tên, địa điểm..." value="" aria-label="Tìm kiếm" />
    </div>
    <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTourModal">Thêm Tour Mới</a>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Tour</th>
                    <th>Địa điểm</th>
                    <th>Miền</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tours)): ?>
                    <?php foreach ($tours as $tour): ?>
                        <tr>
                            <td><?= htmlspecialchars($tour['tour_code']) ?></td>
                            <td><?= htmlspecialchars($tour['name']) ?></td>
                            <td><?= htmlspecialchars($tour['location']) ?></td>
                            <td><?= htmlspecialchars($tour['region']) ?></td>
                            <td><?= number_format($tour['price_default']) ?> VNĐ</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#viewTourModal" data-id="<?= $tour['id'] ?>">Xem</a>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTourModal" 
                                    data-id="<?= $tour['id'] ?>"
                                    data-name="<?= htmlspecialchars($tour['name']) ?>"
                                    data-slug="<?= htmlspecialchars($tour['slug']) ?>"
                                    data-description="<?= htmlspecialchars($tour['description']) ?>"
                                    data-location="<?= htmlspecialchars($tour['location']) ?>"
                                    data-region="<?= htmlspecialchars($tour['region']) ?>"
                                    data-duration="<?= htmlspecialchars($tour['duration']) ?>"
                                    data-price_default="<?= htmlspecialchars($tour['price_default']) ?>"
                                    data-cover_image="<?= base64_encode($tour['cover_image']) ?>"
                                >Sửa</a>
                                <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteTourModal" data-id="<?= $tour['id'] ?>"data-name="<?= htmlspecialchars($tour['name']) ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có tour nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
            <form method="post" action="<?= route('tour.create') ?>" enctype="multipart/form-data">
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên Tour</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Địa điểm</label>
                            <input type="text" class="form-control" id="location" name="location" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="region" class="form-label">Miền</label>
                            <input type="text" class="form-control" id="region" name="region" required>
                        </div>
                        <div class="mb-3">
                            <label for="duration" class="form-label">Thời gian</label>
                            <input type="text" class="form-control" id="duration" name="duration" required>
                        </div>
                        <div class="mb-3">
                            <label for="price_default" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="price_default" name="price_default" required>
                        </div>
                        <div class="mb-3">
                            <label for="cover_image" class="form-label">Ảnh Bìa</label>
                            <input type="file" class="form-control" id="cover_image" name="cover_image" accept="image/*" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3 pb-1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
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
            <div class="modal-body">
                <!-- Nội dung chi tiết tour sẽ được tải động bằng JavaScript hoặc AJAX -->
                <p>Đang tải chi tiết tour...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
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
            <form method="post" action="<?= route('tour.update') ?>" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id">
                <div class="modal-body row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Tên Tour</label>
                            <input type="text" class="form-control" id="edit_name" name="edit_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="edit_slug" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="edit_description" name="edit_description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_location" class="form-label">Địa điểm</label>
                            <input type="text" class="form-control" id="edit_location" name="edit_location" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_region" class="form-label">Miền</label>
                            <input type="text" class="form-control" id="edit_region" name="edit_region" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="edit_duration" class="form-label">Thời gian</label>
                            <input type="text" class="form-control" id="edit_duration" name="edit_duration" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price_default" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="edit_price_default" name="edit_price_default" required>
                        </div>
                        <div>
                            <label for="edit_cover_image" class="form-label">Ảnh Bìa</label>
                            <input type="file" class="form-control" id="edit_cover_image" name="edit_cover_image" accept="image/*">
                            <img id="edit_preview" class="img-fluid rounded mt-3 d-block mx-auto" style="max-height: 200px">
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-3 pb-1">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>