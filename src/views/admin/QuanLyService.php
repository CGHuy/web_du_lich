<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h5 class="card-title">Quản lý Dịch vụ</h5>
        <p style="color: #636465ff;">Danh sách các dịch vụ</p>
    </div>
    <a href="#" class="btn btn-primary btn-sm">Thêm Dịch vụ Mới</a>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Dịch vụ</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?= htmlspecialchars($service['id']) ?></td>
                            <td><?= htmlspecialchars($service['name']) ?></td>
                            <td><?= htmlspecialchars(substr($service['description'], 0, 50)) ?>...</td>
                            <td><?= number_format($service['price']) ?> VNĐ</td>
                            <td>
                                <span class="status-label status-success">Hoạt động</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary">Sửa</a>
                                <a href="#" class="btn btn-sm btn-outline-danger">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có dịch vụ nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>