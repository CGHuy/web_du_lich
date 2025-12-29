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