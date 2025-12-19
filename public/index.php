<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/router.php';

// Nếu có controller/action thì dispatch và dừng, tránh render trang chủ
if (dispatch()) {
    exit;
}

include __DIR__ . '/../src/views/partials/menu.php';
require_once __DIR__ . '/../src/models/Tour.php';
$tourModel = new Tour();
$tours = $tourModel->getAll();
$toursMienBac = $tourModel->getByRegion('Miền Bắc');
$toursMienTrung = $tourModel->getByRegion('Miền Trung');
$toursMienNam = $tourModel->getByRegion('Miền Nam');
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
    <link rel="stylesheet" href="css/TrangChu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>

    <div class="container my-4">
        <div class="search-group mb-4">
            <div class="search-icon">
                <span class="material-symbols-outlined"><i class="fa-solid fa-magnifying-glass fa-sm"></i></span>
            </div>
            <input class="search-input" placeholder="Bạn muốn đi đâu? Tìm kiếm tour theo tên, địa điểm..." value="" />
        </div>

        <h3>Top Tours nổi bật</h3>

        <!-- Slider Card Carousel động từ DB -->
        <div id="carouselTourCards" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php if (!empty($tours)): ?>
                    <?php foreach (array_chunk($tours, 4) as $idx => $tourChunk): ?>
                        <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
                            <div class="row g-3">
                                <?php foreach ($tourChunk as $tour): ?>
                                    <div class="col-12 col-md-6 col-lg-3">
                                        <div class="card h-100">
                                            <img src="data:image/jpeg;base64,<?= base64_encode($tour['cover_image']) ?>"
                                                class="card-img-top" alt="<?= htmlspecialchars($tour['name']) ?>">
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
                <?php else: ?>
                    <div class="carousel-item active">
                        <div class="alert alert-warning">Không có tour nào!</div>
                    </div>
                <?php endif; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselTourCards"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselTourCards"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Hành Trình Xuyên Việt -->
        <div class="region-section mt-5">
            <h3 class="section-main-title mb-4">Hành Trình Xuyên Việt</h3>

            <!-- Miền Bắc -->
            <div class="region-block mb-4">
                <h5 class="region-title"><i class="fa-solid fa-mountain"></i> Miền Bắc - Nét Đẹp Cổ Kính</h5>
                <div id="carouselMienBac" class="carousel slide">
                    <div class="carousel-inner">
                        <?php if (!empty($toursMienBac)): ?>
                            <?php foreach (array_chunk($toursMienBac, 4) as $idx => $tourChunk): ?>
                                <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
                                    <div class="row g-3">
                                        <?php foreach ($tourChunk as $tour): ?>
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card h-100">
                                                    <img src="data:image/jpeg;base64,<?= base64_encode($tour['cover_image']) ?>"
                                                        class="card-img-top" alt="<?= htmlspecialchars($tour['name']) ?>">
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
                        <?php else: ?>
                            <div class="carousel-item active">
                                <div class="alert alert-info">Chưa có tour Miền Bắc nào!</div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMienBac"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMienBac"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- Miền Trung -->
            <div class="region-block mb-4">
                <h5 class="region-title"><i class="fa-solid fa-umbrella-beach"></i> Miền Trung - Di Sản Thế Giới</h5>
                <div id="carouselMienTrung" class="carousel slide">
                    <div class="carousel-inner">
                        <?php if (!empty($toursMienTrung)): ?>
                            <?php foreach (array_chunk($toursMienTrung, 4) as $idx => $tourChunk): ?>
                                <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
                                    <div class="row g-3">
                                        <?php foreach ($tourChunk as $tour): ?>
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card h-100">
                                                    <img src="data:image/jpeg;base64,<?= base64_encode($tour['cover_image']) ?>"
                                                        class="card-img-top" alt="<?= htmlspecialchars($tour['name']) ?>">
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
                        <?php else: ?>
                            <div class="carousel-item active">
                                <div class="alert alert-info">Chưa có tour Miền Trung nào!</div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMienTrung"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMienTrung"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- Miền Nam -->
            <div class="region-block mb-4">
                <h5 class="region-title"><i class="fa-solid fa-city"></i> Miền Nam - Sôi Động & Trù Phú</h5>
                <div id="carouselMienNam" class="carousel slide">
                    <div class="carousel-inner">
                        <?php if (!empty($toursMienNam)): ?>
                            <?php foreach (array_chunk($toursMienNam, 4) as $idx => $tourChunk): ?>
                                <div class="carousel-item <?= $idx === 0 ? 'active' : '' ?>">
                                    <div class="row g-3">
                                        <?php foreach ($tourChunk as $tour): ?>
                                            <div class="col-12 col-md-6 col-lg-3">
                                                <div class="card h-100">
                                                    <img src="data:image/jpeg;base64,<?= base64_encode($tour['cover_image']) ?>"
                                                        class="card-img-top" alt="<?= htmlspecialchars($tour['name']) ?>">
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
                        <?php else: ?>
                            <div class="carousel-item active">
                                <div class="alert alert-info">Chưa có tour Miền Nam nào!</div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselMienNam"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselMienNam"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

    </div>



    <?php
    include __DIR__ . '/../src/views/partials/footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>