<form id="tourDepartureForm" method="POST" action="?controller=TourDeparture&action=update" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($departure['id']) ?>">
    <div class="modal-body row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="tour_id" class="form-label">Tour</label>
                <select class="form-control" id="tour_id" name="tour_id" required>
                    <option value="">Chọn Tour</option>
                    <?php foreach ($tours as $tour): ?>
                        <option value="<?= $tour['id'] ?>" <?= $tour['id'] == $departure['tour_id'] ? 'selected' : '' ?>><?= htmlspecialchars($tour['tour_code']) ?> - <?= htmlspecialchars($tour['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="departure_location" class="form-label">Địa điểm khởi hành</label>
                <select class="form-control" id="departure_location" name="departure_location" required>
                    <option value="">Chọn địa điểm</option>
                    <option value="Miền Bắc" <?= $departure['departure_location'] == 'Miền Bắc' ? 'selected' : '' ?>>Miền Bắc</option>
                    <option value="Miền Trung" <?= $departure['departure_location'] == 'Miền Trung' ? 'selected' : '' ?>>Miền Trung</option>
                    <option value="Miền Nam" <?= $departure['departure_location'] == 'Miền Nam' ? 'selected' : '' ?>>Miền Nam</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="departure_date" class="form-label">Ngày khởi hành</label>
                <input type="date" class="form-control" id="departure_date" name="departure_date" value="<?= htmlspecialchars($departure['departure_date']) ?>" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="price_moving" class="form-label">Giá di chuyển</label>
                <input type="number" class="form-control" id="price_moving" name="price_moving" step="0.01" value="<?= htmlspecialchars($departure['price_moving']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="price_moving_child" class="form-label">Giá di chuyển trẻ em</label>
                <input type="number" class="form-control" id="price_moving_child" name="price_moving_child" step="0.01" value="<?= htmlspecialchars($departure['price_moving_child']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="seats_total" class="form-label">Tổng số ghế</label>
                <input type="number" class="form-control" id="seats_total" name="seats_total" value="<?= htmlspecialchars($departure['seats_total']) ?>" required>
            </div>
        </div>
    </div>
    <div class="modal-footer p-3 pb-1">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="submit" class="btn btn-primary">Cập Nhật</button>
    </div>
</form>