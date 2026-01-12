<form method="post" action="<?= route('user.create') ?>">
    <div class="modal-body">
        <div class="mb-3">
            <label for="fullname" class="form-label">Họ và tên</label>
            <input type="text" class="form-control" id="fullname" name="fullname" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required aria-describedby="email_error">
            <div class="invalid-feedback" id="email_error"></div>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="tel" class="form-control" id="phone" name="phone" pattern="0[0-9]{9}" placeholder="0xxxxxxxxx" required aria-describedby="phone_error">
            <div class="invalid-feedback" id="phone_error"></div>
            <small class="form-text text-muted">Phải có 10 số và bắt đầu bằng 0</small>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Vai trò</label>
            <select class="form-select" id="role" name="role" required>
                <option value="customer">Khách hàng</option>
                <option value="admin">Admin</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="submit" id="add_submit_btn" class="btn btn-primary">Thêm</button>
    </div>
</form>
