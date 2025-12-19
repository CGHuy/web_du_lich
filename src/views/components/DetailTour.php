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
    <link rel="stylesheet" href="css/DetailTourStyle.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

</head>

<body>
    <main class="container my-4 d-flex gap-4">
        <div class="content card p-4">
            <h3><?php echo htmlspecialchars($tour['name']); ?></h3>
            <div class="d-flex gap-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-location-dot" style="color: #0d6efd;"></i>
                    <span style="color: #0d6efd;"><?php echo htmlspecialchars($tour['region']); ?></span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-clock" style="color: #0d6efd;"></i>
                    <span style="color: #0d6efd;"><?php echo htmlspecialchars($tour['duration']); ?></span>
                </div>
            </div>
            <div id="carouselExample" class="carousel slide mx-auto my-3 custom-carousel">
                <div class="carousel-inner h-100">
                    <?php if (!empty($tourImages) && is_array($tourImages)): ?>
                        <?php foreach ($tourImages as $idx => $img): ?>
                            <?php
                            if (!empty($img['image'])) {
                                $finfo = new finfo(FILEINFO_MIME_TYPE);
                                $mime = $finfo->buffer($img['image']);
                                if (strpos($mime, 'image/') === 0) {
                                    $imgData = base64_encode($img['image']);
                                    $src = 'data:' . $mime . ';base64,' . $imgData;
                                } else {
                                    $src = '';
                                }
                            } else {
                                $src = '';
                            }
                            ?>
                            <div class="carousel-item<?php echo $idx === 0 ? ' active' : ''; ?>">
                                <?php if ($src): ?>
                                    <img src="<?php echo $src; ?>" class="d-block w-100 h-100 custom-carousel-img" alt="Tour Image">
                                <?php else: ?>
                                    <div class="text-center text-danger">Không có ảnh hợp lệ</div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active">
                            <div class="text-center text-warning">Chưa có ảnh cho tour này.</div>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Navigation as anchor links -->
            <nav class="mb-3">
                <ul class="nav nav-tabs" style="cursor:pointer;">
                    <li class="nav-item">
                        <a class="nav-link" href="#overview-section">Tổng quan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#itinerary-section">Lịch trình</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#service-section">Dịch vụ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#review-section">Đánh giá</a>
                    </li>
                </ul>
            </nav>

            <!-- All sections always visible -->
            <div class="mt-3">
                <section id="overview-section" class="mb-5">
                    <h5>Tổng quan</h5>
                    <p><?php echo htmlspecialchars($tour['description']); ?></p>
                </section>
                <section id="itinerary-section" class="mb-5">
                    <h5 class="fw-bold mb-4" style="font-size:1.5rem;">Lịch trình chi tiết</h5>
                    <div class="position-relative ps-4 ps-md-5" style="max-width:700px;">
                        <div class="position-absolute top-0 start-0 bottom-0" style="width:3px; background:#e2e8f0;">
                        </div>
                        <?php if (!empty($tourItineraries)): ?>
                            <?php foreach ($tourItineraries as $idx => $item): ?>
                                <div class="position-relative mb-4">
                                    <!-- Circle with day number -->
                                    <div class="position-absolute translate-middle-y" style="left:-28px; top:24px;">
                                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold"
                                            style="width:40px; height:40px; background:#fff; color:#1080f2; border:4px solid #1080f2; font-size:1.15rem; box-shadow:0 2px 8px 0 rgba(16,128,242,0.10);">
                                            <?php echo str_pad($item['day_number'], 2, '0', STR_PAD_LEFT); ?>
                                        </div>
                                    </div>
                                    <!-- Card -->
                                    <div class="ms-4 ms-md-5 p-3 rounded-3 border bg-white shadow-sm">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div class="" style="font-size:1.1em;">
                                                <?php echo nl2br(htmlspecialchars($item['title'] ?? $item['description'])); ?>
                                            </div>
                                            <span
                                                class="badge bg-light text-secondary d-flex align-items-center gap-1 px-3 py-2 rounded-pill"
                                                style="font-size:0.95em;">
                                                <i class="fa-regular fa-clock"></i> Ngày <?php echo $item['day_number']; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Chưa có lịch trình cho tour này.</p>
                        <?php endif; ?>
                    </div>

                </section>
                <section id="service-section" class="mb-5">
                    <h5>Dịch vụ</h5>
                    <div class="px-3">
                        <?php if (!empty($tourServices)): ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($tourServices as $service): ?>
                                    <li class="list-group-item">
                                        <strong><?php echo htmlspecialchars($service['name']); ?></strong>
                                        <?php if (!empty($service['description'])): ?>
                                            <br><span><?php echo htmlspecialchars($service['description']); ?></span>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Chưa có dịch vụ cho tour này.</p>
                        <?php endif; ?>
                    </div>
                </section>
                <section id="review-section" class="mb-5">
                    <h5 class="mb-4">Đánh giá từ khách hàng</h5>
                    <div class="d-flex flex-column gap-3" id="reviews">
                        <?php if (!empty($tourReviews)): ?>
                            <?php foreach ($tourReviews as $review): ?>
                                <div class="d-flex align-items-start gap-3 p-3 bg-white rounded shadow-sm">
                                    <img alt="Avatar of user review" class="rounded-circle"
                                        style="width:40px;height:40px;object-fit:cover;" src="images/image.png">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <p class="fw-semibold mb-1" style="color:#222;font-size:1.05rem;">
                                                <?php echo htmlspecialchars($review['user_name'] ?? 'Ẩn danh'); ?>
                                            </p>
                                            <div class="d-flex align-items-center gap-1">
                                                <?php
                                                $rating = isset($review['rating']) ? (int) $review['rating'] : 0;
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $rating) {
                                                        echo '<i class="fa-solid fa-star" style="color:#ffc107;font-size:1rem;"></i>';
                                                    } else {
                                                        echo '<i class="fa-regular fa-star" style="color:#e4e4e4;font-size:1rem;"></i>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <p class="mt-1 mb-0 text-secondary" style="font-size:0.98rem;">
                                            <?php echo nl2br(htmlspecialchars($review['comment'] ?? '')); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-muted">Chưa có đánh giá cho tour này.</div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </div>

        <div class="book-info w-100 d-flex flex-column align-items-center">
            <div class="card p-3 w-100 mb-2 d-flex">
                <p class="mb-0">Giá chỉ từ</p>
                <span class="d-flex align-items-baseline" style="gap: 4px;">
                    <span class="fw-bold text-primary self-align-center" style="font-size: 1.4rem;">
                        <?php echo number_format($tour['price_default'], 0, ',', '.') . 'đ'; ?>
                    </span>
                    <span style="color: #888; font-size: 1rem; opacity: 0.8;">/Người</span>
                </span>
                <div class="d-flex gap-2">
                    <a href="<?php echo route('BookingTour.index', ['tour_id' => $tour['id']]); ?>"
                        class="btn btn-primary">Đặt
                        Tour</a>
                    <button class="btn btn-secondary"><i class="fa-solid fa-heart"
                            style="color: #f40808ff;"></i></button>
                </div>
            </div>

            <div class="card p-3 w-100 text-center">
                <h6>Cần hỗ trợ?</h6>
                <p class="mb-0">Gọi ngay cho chúng tôi để được tư vấn miễn phí</p>
                <p class="fw-bold text-primary self-align-center m-0" style="font-size: 1.4rem;">1900 1234</p>
            </div>
        </div>
    </main>


</body>

<?php
include __DIR__ . '/../partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/DetailTour.js"></script>

</html>