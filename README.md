# Web Du Lịch (PHP MVC tối giản)

## Luồng hoạt động

Sơ đồ luồng hoạt động:

Trình duyệt
|
v
public/.htaccess -- rewrite --> public/index.php
|
v
Đọc query controller/action -> đối chiếu routes.php
|
v
Controller (UserController) ----> Model (User) ----> MySQL
|
v
View (user_list.php, user_detail.php)
|
v
HTML trả về trình duyệt

## Cách thêm một form mới (ví dụ: form thêm người dùng)

1. **Thêm route mới**

   - Mở `config/routes.php`, thêm route cho form (ví dụ: `user.create`, `user.store`).

2. **Tạo controller method**

   - Trong `src/controllers/UserController.php`, thêm method:
     - `create()` để hiển thị form.
     - `store()` để xử lý dữ liệu POST từ form.

3. **Tạo view cho form**

   - Tạo file mới trong `src/views/` (ví dụ: `user_create.php`) chứa HTML form.
   - Form action trỏ về route xử lý POST (dùng helper `route()` nếu có).

4. **Cập nhật model**

   - Đảm bảo model (`src/models/User.php`) có phương thức thêm mới (ví dụ: `createUser($name, $email)`).

5. **Cập nhật menu hoặc nút điều hướng**

   - Thêm link tới form trong `src/views/partials/menu.php` hoặc trong danh sách người dùng.

6. **Xử lý chuyển hướng sau khi submit**
   - Sau khi thêm mới thành công, controller chuyển hướng về trang danh sách hoặc trang chi tiết.

**Ví dụ luồng thêm người dùng:**

- Truy cập menu "Thêm người dùng" → gọi `UserController::create()` → hiển thị form.
- Submit form → gọi `UserController::store()` → lưu vào DB → chuyển về danh sách.
