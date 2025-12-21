<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h5 class="card-title">Quản lý Lịch trình</h5>
        <p style="color: #636465ff;">Danh sách các lịch trình tour</p>
    </div>
    <a href="#" class="btn btn-primary btn-sm">Thêm Lịch trình Mới</a>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tour ID</th>
                    <th>Ngày</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($itineraries)): ?>
                    <?php foreach ($itineraries as $itinerary): ?>
                        <tr>
                            <td><?= htmlspecialchars($itinerary['id']) ?></td>
                            <td><?= htmlspecialchars($itinerary['tour_id']) ?></td>
                            <td>Ngày <?= htmlspecialchars($itinerary['day_number']) ?></td>
                            <td><?= htmlspecialchars(substr($itinerary['description'], 0, 50)) ?>...</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Sửa</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Không có lịch trình nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>