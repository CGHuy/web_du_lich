<?php include __DIR__ . '/../partials/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
    <link rel="stylesheet" href="css/manage.css">
</head>

<body>
    <div class="container-fluid my-4">
        <div class="d-flex gap-4 px-5">
            <?php
            $currentPage = $currentPage ?? 'tour';
            ?>
            <div class="card menu menu-card" style="flex: 0 0 20%;">
                <div class="card-body p-3">
                    <h5 class="card-title mb-3">Quản lý</h5>
                    <ul class="menu-list">
                        <li class="menu-item mb-1 <?= $currentPage === 'tour' ? 'active' : '' ?>">
                            <i class="fa-solid fa-map"></i>
                            <a href="<?= route('tour.index'); ?>" class="text-decoration-none flex-grow-1"
                                style="color: inherit;">
                                Quản lý tour</a>
                        </li>
                        <li class="menu-item mb-1 <?= $currentPage === 'itinerary' ? 'active' : '' ?>">
                            <i class="fa-solid fa-route"></i>
                            <a href="<?= route('itinerary.index'); ?>" class="text-decoration-none flex-grow-1"
                                style="color: inherit;">
                                Quản lý lịch trình</a>
                        </li>
                        <li class="menu-item mb-1 <?= $currentPage === 'destination' ? 'active' : '' ?>">
                            <i class="fa-solid fa-location-dot"></i>
                            <a href="<?= route('destination.index'); ?>" class="text-decoration-none flex-grow-1"
                                style="color: inherit;">
                                Quản lý điểm đến</a>
                        </li>
                        <li class="menu-item mb-1 <?= $currentPage === 'booking' ? 'active' : '' ?>">
                            <i class="fa-solid fa-calendar-check"></i>
                            <a href="<?= route('BookingAdmin.index'); ?>" class="text-decoration-none flex-grow-1"
                                style="color: inherit;">
                                Quản lý booking</a>
                        </li>
                        <li class="menu-item mb-1 <?= $currentPage === 'service' ? 'active' : '' ?>">
                            <i class="fa-solid fa-concierge-bell"></i>
                            <a href="<?= route('service.index'); ?>" class="text-decoration-none flex-grow-1"
                                style="color: inherit;">
                                Quản lý dịch vụ</a>
                        </li>
                        <li class="menu-item <?= $currentPage === 'user' ? 'active' : '' ?>">
                            <i class="fa-solid fa-users"></i>
                            <a href="<?= route('user.index'); ?>" class="text-decoration-none flex-grow-1"
                                style="color: inherit;">
                                Quản lý user</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                <div class="card-body">
                    <div id="admin-content">
                        <?php echo $content ?? ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Load Bootstrap trước -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

<?php include __DIR__ . '/../partials/footer.php'; ?>

</html>