<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container">
        <a class="navbar-brand" href="/index.php">Web Du Lịch</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= route('user.index'); ?>">Danh sách người dùng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= route('user.show', ['id' => 1]); ?>">Chi tiết người dùng (demo)</a>
                </li>
            </ul>
        </div>
    </div>
</nav>