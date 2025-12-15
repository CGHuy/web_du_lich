<div class="card menu menu-card" style="flex: 0 0 20%;">
    <div class="card-body p-3">
        <ul class="menu-list">
            <li class="menu-item <?= $currentPage === 'edit' ? 'active' : '' ?>">
                <i class="fa-solid fa-user"></i>
                <a href="<?= route('admin.tour'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý tour</a>
            </li>
            <li class="menu-item <?= $currentPage === 'change-password' ? 'active' : '' ?>">
                <i class="fa-solid fa-lock"></i>
                <a href="<?= route('admin.itinerary'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý lịch trình</a>
            </li>
            <li class="menu-item">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <a href="<?= route('admin.booking'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý booking</a>
            </li>
            <li class="menu-item">
                <i class="fa-solid fa-heart"></i>
                <a href="<?= route('admin.service'); ?>" class="text-decoration-none flex-grow-1" style="color: inherit;">
                    Quản lý dịch vụ</a>
            </li>
        </ul>
    </div>
</div>