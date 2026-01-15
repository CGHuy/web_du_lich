<div class="card-header d-flex justify-content-between align-items-center p-0 px-4">
    <div>
        <h5 class="card-title">
            <i class="fa-solid fa-user me-2"></i>Quản lý User
        </h5>
    </div>
</div>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <?= htmlspecialchars($_SESSION['success_message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="card-body">
    <div class="input-group search-group mb-3">
        <span class="input-group-text search-icon">
            <i class="fa-solid fa-magnifying-glass fa-sm"></i>
        </span>
        <input class="form-control search-input" placeholder="Tìm kiếm user theo id, tên, email, số điện thoại..." value="" aria-label="Tìm kiếm" />
    </div>
    <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Thêm User Mới</a>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
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
                            <td class="find_id"><?= htmlspecialchars($user['id']) ?></td>
                            <td class="find_name"><?= htmlspecialchars($user['fullname']) ?></td>
                            <td class="find_email"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="find_phone"><?= htmlspecialchars($user['phone']) ?></td>
                            <td class="find_role"><?= htmlspecialchars($user['role']) ?></td>
                            <td>
                                <span class="status-label status-success">Hoạt động</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="<?= $user['id'] ?>"><i class="fa-solid fa-pen-to-square me-1"></i> Sửa</a>
                                <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="<?= $user['id'] ?>" data-name="<?= htmlspecialchars($user['fullname']) ?>"><i class="fa-solid fa-trash me-1"></i> Xóa</a>
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

<!-- Modal Thêm User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Thêm User Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
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

<!-- Modal Sửa User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Sửa User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
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

<!-- Modal Xóa User -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteUserModalLabel">Xác nhận xóa user</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" action="<?= route('user.delete') ?>">
                <input type="hidden" name="id" id="delete_id">
                <div class="modal-body">
                    <p class="m-0 p-2">Bạn có chắc chắn muốn xóa user:</p>
                    <strong id="delete_name" class="p-2"></strong>
                    <div id="delete_booking_info" class="p-2"></div>
                    <p class="text-danger m-0 p-2"><strong>Hành động này không thể hoàn tác.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" id="confirm_delete_btn" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Handle delete user modal
    document.getElementById('deleteUserModal')?.addEventListener('show.bs.modal', function(e) {
        const button = e.relatedTarget;
        const userId = button.getAttribute('data-id');
        const userName = button.getAttribute('data-name');
        document.getElementById('delete_id').value = userId;
        document.getElementById('delete_name').textContent = userName;

        // Reset info
        const infoEl = document.getElementById('delete_booking_info');
        const confirmBtn = document.getElementById('confirm_delete_btn');
        infoEl.textContent = 'Đang kiểm tra lịch đặt...';
        confirmBtn.disabled = true;

        fetch('index.php?controller=user&action=checkBookings&id=' + encodeURIComponent(userId))
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (data.count > 0) {
                        infoEl.innerHTML = '<span class="text-danger">Người dùng hiện có ' + data.count + ' booking. Không thể xóa.</span>';
                        confirmBtn.disabled = true;
                    } else {
                        infoEl.innerHTML = '<span class="text-success">Người dùng không có booking. Có thể xóa.</span>';
                        confirmBtn.disabled = false;
                    }
                } else {
                    infoEl.innerHTML = '<span class="text-warning">Không xác định trạng thái đặt chỗ.</span>';
                    confirmBtn.disabled = false;
                }
            })
            .catch(err => {
                infoEl.innerHTML = '<span class="text-warning">Lỗi kiểm tra: ' + err.message + '</span>';
                confirmBtn.disabled = false;
            });
    });
</script>

<script src="/web_du_lich/public/js/admin/QuanLyUser.js"></script>