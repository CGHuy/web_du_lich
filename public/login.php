<?php
require_once __DIR__ . '/../config/database.php';
if (session_status() === PHP_SESSION_NONE)
    session_start();
// Simple login demo: check email+password against users table
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare('SELECT id, email, password, role FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['password']) { // demo: plain text comparison (keep as-is for now)
        $_SESSION['user_id'] = $user['id'];
        // store role for authorization checks in views
        $_SESSION['role'] = $user['role'] ?? 'customer';
        header('Location: index.php');
        exit;
    } else {
        $message = 'Email hoặc mật khẩu không đúng.';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Màn hình Đăng nhập - VietTour</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Spline+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Spline Sans', system-ui, -apple-system, 'Segoe UI', Roboto, Arial; background: #f0f9ff; }
        .hero {
            background-image: linear-gradient(rgba(0,0,0,0.12), rgba(0,0,0,0.4)), url('https://lh3.googleusercontent.com/aida-public/AB6AXuC51e84TCIPZTYMq655AazrEd19gy6J5SkPICaV-OsgOfSAQRMAKNGCUK4a6I3_mTz9pnfqYQ6xwqwYJpCDSCHBFbVTcFtqOmbmi2MOTqlc11QtfH_j1w1hmgv8QDP0wyx9J15UAOZdq7OuPV3oOTK85frBtp6XMuZan1uPOyo1VBxgAgH-HiEtsOjBlZepkJ14XdXjx_Ggg5Q_MShc6ZnHDFSc4OBM1NJY0slp0GtyePDeIEGSnOiCwNI3LqO4-Ecgmmqip3HfoWr8');
            background-size: cover; background-position: center; height: 260px; border-radius: 14px;
        }
        .card-floating { margin-top: -80px; border-radius: 14px; }
        .input-icon { width:48px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; border-top-left-radius: 999px; border-bottom-left-radius: 999px; }
        .rounded-pill-input { border-top-right-radius: 999px; border-bottom-right-radius: 999px; }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="hero d-flex align-items-center justify-content-center text-center text-white mb-0">
                    <div>
                        <h1 class="h3 fw-bold">Đăng nhập</h1>
                        <p class="mb-0">Chào mừng trở lại với VietTour</p>
                    </div>
                </div>

                <div class="card card-floating shadow-sm p-4">
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>

                        <form method="post" action="" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label class="form-label small">Email hoặc số điện thoại</label>
                                <div class="d-flex">
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                          <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                          <path fill-rule="evenodd" d="M8 9a5 5 0 0 0-4.546 2.916.5.5 0 0 0 .447.725h8.198a.5.5 0 0 0 .447-.725A5 5 0 0 0 8 9z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="email" class="form-control rounded-pill-input" placeholder="Nhập email hoặc số điện thoại" required>
                                </div>
                                <div class="invalid-feedback">Vui lòng nhập email hoặc số điện thoại.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small">Mật khẩu</label>
                                <div class="d-flex">
                                    <div class="input-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                          <path d="M8 1a3 3 0 0 0-3 3v3h6V4a3 3 0 0 0-3-3z"/>
                                          <path d="M3 8a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2H3z"/>
                                        </svg>
                                    </div>
                                    <input id="password" type="password" name="password" class="form-control" placeholder="Nhập mật khẩu của bạn" required>
                                    <button id="togglePwd" class="btn btn-outline-secondary ms-2" type="button">Hiện</button>
                                </div>
                                <div class="invalid-feedback">Vui lòng nhập mật khẩu.</div>
                            </div>

                            <div class="d-grid mt-3">
                                <button class="btn btn-primary btn-lg">Đăng nhập</button>
                            </div>
                        </form>

                        <p class="text-center small text-muted mt-3 mb-0">Chưa có tài khoản? <a href="/web_du_lich/public/signup.php" class="fw-semibold">Đăng ký ngay</a></p>
                    </div>
                </div>

                <p class="text-center mt-3"><a href="index.php">Quay về trang chủ</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        (function(){
            const toggle = document.getElementById('togglePwd');
            const input = document.getElementById('password');
            toggle?.addEventListener('click', function(){
                if (input.type === 'password') { input.type = 'text'; toggle.textContent = 'Ẩn'; }
                else { input.type = 'password'; toggle.textContent = 'Hiện'; }
            });

            // Bootstrap validation
            (function () {
                'use strict'
                const forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms).forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })()
        })();
    </script>
</body>

</html>