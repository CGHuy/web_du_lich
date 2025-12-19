<div class="card menu menu-card" style="flex: 0 0 20%;">
    <div class="card-body p-3">
        <ul class="menu-list">
            <li class="menu-item <?= $currentPage === 'edit' ? 'active' : '' ?>">
                <i class="fa-solid fa-user"></i>
                <a href="<?= route('settinguser.edit'); ?>" class="text-decoration-none flex-grow-1"
                    style="color: inherit;">Thông tin cá nhân</a>
            </li>
            <li class="menu-item <?= $currentPage === 'change-password' ? 'active' : '' ?>">
                <i class="fa-solid fa-lock"></i>
                <a href="<?= route('settinguser.changePassword'); ?>" class="text-decoration-none flex-grow-1"
                    style="color: inherit;">Đổi mật
                    khẩu</a>
            </li>
            <li class="menu-item <?= $currentPage === 'booking-history' ? 'active' : '' ?>">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <a href="<?= route('settinguser.bookingHistory'); ?>" class="text-decoration-none flex-grow-1"
                    style="color: inherit;">Lịch sử đặt
                    tour</a>
            </li>
            <li class="menu-item <?= $currentPage === 'favorite-tour' ? 'active' : '' ?>">
                <i class="fa-solid fa-heart"></i>
                <a href="<?= route('settinguser.favoriteTour'); ?>" class="text-decoration-none flex-grow-1"
                    style="color: inherit;">Tour yêu
                    thích</a>
            </li>
            <li class="menu-item">
                <i class="fa-solid fa-right-from-bracket"></i>
                <a href="/web_du_lich/public/logout.php" class="text-decoration-none flex-grow-1"
                    style="color: inherit;">Đăng xuất</a>
            </li>
        </ul>
    </div>
</div>