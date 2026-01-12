<form method="post" action="<?= route('Tour.update') ?>" enctype="multipart/form-data">
    <input type="hidden" id="id" name="id" value="<?= htmlspecialchars($tour['id']) ?>">
    <div class="modal-body row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="edit_name" class="form-label">Tên Tour</label>
                <input type="text" class="form-control" id="edit_name" name="edit_name" value="<?= htmlspecialchars($tour['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="edit_location" class="form-label">Địa điểm</label>
                <input type="text" class="form-control" id="edit_location" name="edit_location" value="<?= htmlspecialchars($tour['location']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="edit_price_default" class="form-label">Giá</label>
                <input type="number" class="form-control" id="edit_price_default" name="edit_price_default" value="<?= htmlspecialchars($tour['price_default']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="edit_description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="edit_description" name="edit_description" rows="3"><?= htmlspecialchars($tour['description']) ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="edit_slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="edit_slug" name="edit_slug" value="<?= htmlspecialchars($tour['slug']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="edit_region" class="form-label">Miền</label>
                <select class="form-control" id="edit_region" name="edit_region" required>
                    <option value="">Chọn miền</option>
                    <option value="Miền Bắc" <?= $tour['region'] == 'Miền Bắc' ? 'selected' : '' ?>>Miền Bắc</option>
                    <option value="Miền Trung" <?= $tour['region'] == 'Miền Trung' ? 'selected' : '' ?>>Miền Trung</option>
                    <option value="Miền Nam" <?= $tour['region'] == 'Miền Nam' ? 'selected' : '' ?>>Miền Nam</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="edit_price_child" class="form-label">Giá Trẻ Em</label>
                <input type="number" class="form-control" id="edit_price_child" name="edit_price_child" value="<?= htmlspecialchars($tour['price_child']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="edit_duration" class="form-label">Thời gian</label>
                <input type="text" class="form-control" id="edit_duration" name="edit_duration" value="<?= htmlspecialchars($tour['duration']) ?>" required>
            </div>
            
            <div>
                <label for="edit_cover_image" class="form-label">Ảnh Bìa</label>
                <input type="file" class="form-control" id="edit_cover_image" name="edit_cover_image" accept="image/*">
                <img id="edit_preview" class="img-fluid rounded mt-3 d-block mx-auto" style="max-height: 200px" src="data:image/jpeg;base64,<?= base64_encode($tour['cover_image']) ?>">
            </div>
        </div>
    </div>
    <div class="modal-footer p-3 pb-1">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="submit" class="btn btn-primary">Lưu</button>
    </div>
</form>