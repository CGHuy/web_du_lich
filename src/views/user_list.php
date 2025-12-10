<?php include __DIR__ . '/partials/header.php'; ?>
<h2>Danh sách người dùng</h2>
<ul class="list-group">
    <?php foreach ($users as $user): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</span>
            <a class="btn btn-sm btn-primary" href="/index.php?controller=user&action=show&id=<?= (int) $user['id'] ?>">Xem
                chi tiết</a>
        </li>
    <?php endforeach; ?>
</ul>
<?php include __DIR__ . '/partials/footer.php'; ?>