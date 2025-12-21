<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h5 class="card-title">Quản lý User</h5>
        <p style="color: #636465ff;">Danh sách các người dùng</p>
    </div>
    <a href="#" class="btn btn-primary btn-sm">Thêm User Mới</a>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['fullname']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
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
                        <td colspan="7" class="text-center">Không có user nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>