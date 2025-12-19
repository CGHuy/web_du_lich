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
    <link rel="stylesheet" href="css/TrangChu.css">
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
                <?php if (!empty($favoriteTours)): ?>
                    <div id="carouselFavoriteTours" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach (array_chunk($favoriteTours, 4) as $idx => $chunk): ?>
                                <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
                                    <div class="row g-4">
                                        <?php foreach ($chunk as $tour): ?>
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card h-100 position-relative">
                                                    <form method="post" action="<?= route('settinguser.updateFavoriteTour') ?>"
                                                        style="position:absolute;top:10px;right:10px;z-index:2;">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="wishlist_id" value="<?= $tour['wishlist_id'] ?>">
                                                        <button type="submit" class="btn p-0 border-0 bg-transparent"
                                                            title="Xóa khỏi yêu thích"
                                                            onclick="return confirm('Bạn có chắc muốn xóa tour này khỏi yêu thích?')">
                                                            <i class="fa-solid fa-heart"
                                                                style="color: #ce1c40; font-size: 1.4rem;"></i>
                                                        </button>
                                                    </form>

                                                    <?php if (!empty($tour['cover_image'])): ?>
                                                        <img src="data:image/jpeg;base64,<?= base64_encode($tour['cover_image']) ?>"
                                                            class="card-img-top" alt="<?= htmlspecialchars($tour['name']) ?>">
                                                    <?php else: ?>
                                                        <img src="/web_du_lich/public/images/no-image.png" class="card-img-top"
                                                            alt="No image">
                                                    <?php endif; ?>
                                                    <div class="card-badges">
                                                        <span class="badge bg-info"><i class="fa-solid fa-map-location-dot"></i>
                                                            <?= htmlspecialchars($tour['location']) ?></span>
                                                        <span class="badge bg-primary"><i class="fa-solid fa-calendar-days"></i>
                                                            <?= htmlspecialchars($tour['duration']) ?></span>
                                                    </div>
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?= htmlspecialchars($tour['name']) ?></h5>
                                                        <p class="card-text"><?= htmlspecialchars($tour['description']) ?></p>
                                                        <div class="card-price"><b>Giá:</b><span class="hightlight_price">
                                                                <?= number_format($tour['price_default']) ?> VNĐ</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselFavoriteTours"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselFavoriteTours"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                <?php else: ?>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="alert alert-info text-center">Bạn chưa có tour yêu thích nào.</div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>



    <?php
    include __DIR__ . '/../partials/footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>