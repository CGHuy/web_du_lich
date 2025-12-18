<?php
include __DIR__ . '/../partials/menu.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Du Lịch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
    <link rel="stylesheet" href="css/SettingAccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>

    <div class="container-fluid my-4">
        <div class="d-flex gap-4 px-5">
            <?php
            $currentPage = 'favorite-tour';
            include __DIR__ . '/../partials/settings-menu.php';
            ?>
            <div style="flex: 0 0 calc(80% - 1rem);">
                <div class="row g-4">
                    <?php if (!empty($favoriteTours)): ?>
                        <?php foreach ($favoriteTours as $tour): ?>
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 favourite-tour-card">
                                    <?php if (!empty($tour['cover_image'])): ?>
                                        <img src="data:image/jpeg;base64,<?= base64_encode($tour['cover_image']) ?>"
                                            class="card-img-top" alt="<?= htmlspecialchars($tour['name']) ?>">
                                    <?php else: ?>
                                        <img src="/web_du_lich/public/images/no-image.png" class="card-img-top" alt="No image">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($tour['name']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($tour['description']) ?></p>
                                        <div class="card-price"><b>Giá:</b> <span
                                                class="hightlight_price"><?= number_format($tour['price_default']) ?> VNĐ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-info text-center">Bạn chưa có tour yêu thích nào.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>



    <?php
    include __DIR__ . '/../partials/footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>