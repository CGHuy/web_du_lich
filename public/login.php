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
    $stmt = $conn->prepare('SELECT id, email, password FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password === $user['password']) { // demo: plain text comparison (keep as-is for now)
        $_SESSION['user_id'] = $user['id'];
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
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Đăng nhập (Demo)</h4>
                        <?php if ($message): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button class="btn btn-primary w-100">Đăng nhập</button>
                        </form>
                    </div>
                </div>
                <p class="text-center mt-3"><a href="index.php">Quay về trang chủ</a></p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>