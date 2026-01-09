<?php
require_once __DIR__ . '/../src/controllers/SignupController.php';

if (session_status() === PHP_SESSION_NONE)
    session_start();

$auth = new SignupController();
$result = $auth->signup();

$message = $result['message'];
$message_type = $result['message_type'];
$form_data = $result['form_data'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng ký - VietTour</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Be Vietnam Pro', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#F0F9FF; }
        .card-rounded { border-radius: 12px; }
        .brand { color: #1D4ED8; font-weight:700; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="w-100" style="max-width:520px;">
            <div class="text-center mb-4 d-flex align-items-center gap-2 justify-content-center">
                <div class="p-2 rounded-circle bg-white shadow-sm" style="width:44px;height:44px;display:flex;align-items:center;justify-content:center;color:#1D4ED8">
                    <svg width="22" height="22" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24 4C12.95 4 4 12.95 4 24C4 35.05 12.95 44 24 44C35.05 44 44 35.05 44 24C44 12.95 35.05 4 24 4ZM32.18 33.15L24.51 29.3C23.8 28.9 23.25 28.23 23.25 27.45V14.5C23.25 13.67 23.92 13 24.75 13C25.58 13 26.25 13.67 26.25 14.5V26.54L33.2 30.01C33.91 30.38 34.21 31.25 33.83 31.95C33.46 32.66 32.59 32.96 31.88 32.59L32.18 33.15Z" fill="currentColor"></path></svg>
                </div>
                <h2 class="mb-0 ms-2 brand">VietTour</h2>
            </div>

            <div class="card card-rounded shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h4 text-center fw-bold mb-2">Tạo tài khoản mới</h1>
                    <p class="text-center text-muted mb-4">Cùng khám phá Việt Nam với hàng ngàn tour du lịch hấp dẫn.</p>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo htmlspecialchars($message_type); ?> alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="signup.php" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label small">Họ và tên</label>
                            <input name="fullname" type="text" class="form-control form-control-lg" placeholder="Nhập họ và tên của bạn" value="<?php echo htmlspecialchars($form_data['fullname']); ?>" required>
                            <div class="invalid-feedback">Vui lòng nhập họ và tên.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Số điện thoại</label>
                            <input name="phone" type="tel" class="form-control form-control-lg" placeholder="Nhập số điện thoại" pattern="0[0-9]{9}" value="<?php echo htmlspecialchars($form_data['phone']); ?>" required>
                            <small class="form-text text-muted">Phải có 10 số và bắt đầu bằng 0</small>
                            <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ (10 chữ số, bắt đầu bằng 0).</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Email</label>
                            <input name="email" type="email" class="form-control form-control-lg" placeholder="Nhập địa chỉ email" value="<?php echo htmlspecialchars($form_data['email']); ?>" required>
                            <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Mật khẩu</label>
                            <div class="input-group input-group-lg">
                                <input id="passwordInput" name="password" type="password" class="form-control" placeholder="Nhập mật khẩu" required>
                                <button id="togglePassword" class="btn btn-outline-secondary" type="button">Hiện</button>
                                <div class="invalid-feedback">Vui lòng nhập mật khẩu.</div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Đăng ký</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">Đã có tài khoản? <a href="/web_du_lich/public/login.php" class="fw-semibold text-primary">Đăng nhập</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/signup.js"></script>
</body>
</html>
