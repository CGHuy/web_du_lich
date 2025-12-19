<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>
<header
    class="d-flex align-items-center justify-content-between border-bottom px-4 py-3 sticky-top bg-white bg-opacity-80 backdrop-blur-sm z-50"
    style="top:0;">
    <div class="d-flex align-items-center gap-3">
        <div class="me-2" style="width: 32px; height: 32px; color: #1976d2;">
            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                <g clip-path="url(#clip0_6_330)">
                    <path clip-rule="evenodd"
                        d="M24 0.757355L47.2426 24L24 47.2426L0.757355 24L24 0.757355ZM21 35.7574V12.2426L9.24264 24L21 35.7574Z"
                        fill="currentColor" fill-rule="evenodd"></path>
                </g>
                <defs>
                    <clipPath id="clip0_6_330">
                        <rect fill="white" height="48" width="48"></rect>
                    </clipPath>
                </defs>
            </svg>
        </div>
        <h2 class="fs-4 fw-bold mb-0">VietTour</h2>
    </div>
    <nav class="d-none d-lg-flex flex-grow-1 justify-content-center align-items-center gap-4">
        <a class="text-decoration-none text-body fw-medium px-2 py-1" href="<?= route('ListTour.index') ?>">Tours</a>
        <a class="text-decoration-none text-body fw-medium px-2 py-1" href="#">Điểm đến</a>
        <a class="text-decoration-none text-body fw-medium px-2 py-1" href="#">Về chúng tôi</a>
        <a class="text-decoration-none text-body fw-medium px-2 py-1" href="#">Liên hệ</a>
    </nav>
    <div class="d-flex align-items-center gap-2">
        <?php
        // Determine current script to allow hiding account/logout on index.php after login
        $currentScript = basename($_SERVER['SCRIPT_NAME'] ?? ($_SERVER['PHP_SELF'] ?? ''));
        ?>
        <?php if (empty($_SESSION['user_id'])): ?>
            <a href="/web_du_lich/public/login.php" class="d-none d-sm-flex btn btn-primary rounded-pill px-4 fw-bold">Đăng
                nhập</a>
            <a href="/web_du_lich/public/register.php"
                class="d-none d-sm-flex btn btn-light rounded-pill px-4 fw-bold border">Đăng ký</a>
        <?php else: ?>
            <?php if ($currentScript !== 'index.php'): ?>
                <a href="<?= route('settinguser.edit'); ?>"
                    class="d-none d-sm-flex btn btn-outline-secondary rounded-pill px-3">Tài khoản</a>
                <a href="/web_du_lich/public/logout.php" class="d-none d-sm-flex btn btn-light rounded-pill px-3">Đăng xuất</a>
            <?php endif; ?>

            <!-- Always show avatar when logged in -->
            <a href="<?= route('settinguser.edit'); ?>" class="rounded-circle overflow-hidden"
                style="width:40px; height:40px; cursor: pointer;" title="Thông tin cá nhân">
                <img src="images/image.png" alt="Avatar" style="width:100%; height:100%; object-fit:cover;">
            </a>
        <?php endif; ?>
    </div>
</header>