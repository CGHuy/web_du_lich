<?php include __DIR__ . '/partials/header.php'; ?>
<h2>Thông tin người dùng</h2>
<p><strong>Tên:</strong> <?= htmlspecialchars($user['name']) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
<a class="btn btn-secondary" href="/index.php?controller=user&action=index">Quay lại danh sách</a>
<?php include __DIR__ . '/partials/footer.php'; ?>