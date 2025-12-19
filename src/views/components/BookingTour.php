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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

</head>

<body>
    <div class="container my-4 d-flex gap-4">
        <main>
            <form method="post" action="">
                <div class="card mb-4">
                    <div class="card-header">
                        <h2 class="card-title">THÔNG TIN LIÊN LẠC</h2>
                    </div>
                    <div class="card-body w-100">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="contact_name" class="form-label">Tên người liên hệ</label>
                                <input type="text" class="form-control" id="contact_name" name="contact_name" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="contact_phone" class="form-label">Số điện thoại liên hệ</label>
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                                    required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="contact_email" class="form-label">Email liên hệ</label>
                                <input type="email" class="form-control" id="contact_email" name="contact_email"
                                    required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="note" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="note" name="note" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">CHI TIẾT BOOKING</h2>
                    </div>
                    <div class="card-body card-grid">
                        <div class="mb-1">
                            <div class="d-flex align-items-end justify-content-between gap-2 flex-wrap">
                                <div style="flex:1 1 300px;min-width:220px;">
                                    <label for="departure_id" class="form-label">Chọn lịch khởi hành</label>
                                    <select class="form-select" id="departure_id" name="departure_id" required>
                                        <option value="">-- Chọn ngày khởi hành --</option>
                                        <?php foreach ($departures as $dep): ?>
                                            <?php if ($dep['status'] === 'open'): ?>
                                                <option value="<?php echo $dep['id']; ?>"
                                                    data-max="<?php echo $dep['seats_available']; ?>"
                                                    data-price="<?php echo $dep['price_moving']; ?>"
                                                    <?php echo ($dep['seats_available'] == 0 ? 'disabled style=\'color:#ccc;\'' : ''); ?>
                                                >
                                                    <?php echo htmlspecialchars($dep['departure_date']) . " - " . htmlspecialchars($dep['departure_location']) . " (Còn " . $dep['seats_available'] . " chỗ)"; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="text-end" style="min-width:180px;">
                                    <div id="price-moving-info" class="form-text"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Số lượng người</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Đặt tour</button>
                    </div>
                </div>
            </form>
        </main>
        <div class="card p-4" style="align-self: start;">
            <?php if (!empty($tour)): ?>
                <div class="d-flex align-items-center bg-light rounded-3 shadow-sm p-3 mb-3" style="max-width:480px;">
                    <div style="width:70px;height:70px;flex-shrink:0;overflow:hidden;border-radius:12px;">
                        <?php
                        if (!empty($tour['cover_image'])) {
                            $finfo = new finfo(FILEINFO_MIME_TYPE);
                            $mime = $finfo->buffer($tour['cover_image']);
                            if (strpos($mime, 'image/') === 0) {
                                $imgData = base64_encode($tour['cover_image']);
                                echo '<img src="data:' . $mime . ';base64,' . $imgData . '" style="width:100%;height:100%;object-fit:cover;border-radius:12px;" alt="' . htmlspecialchars($tour['name']) . '">';
                            } else {
                                echo "<div class='text-danger'>Dữ liệu ảnh không hợp lệ!</div>";
                            }
                        } else {
                            echo "<div class='text-warning'>Chưa có ảnh cho tour này.</div>";
                        }
                        ?>
                    </div>
                    <div class="ms-3 flex-grow-1">
                        <div class="fw-bold" style="font-size:1.1rem;line-height:1.3;"><?php echo htmlspecialchars($tour['name']); ?></div>
                        <div class="text-secondary" style="font-size:0.95rem;line-height:1.2;"><?php echo htmlspecialchars($tour['region']); ?><?php if (!empty($tour['departure_location'])) echo ' - ' . htmlspecialchars($tour['departure_location']); ?></div>
                        <div class="mt-2"><strong>Mã Tour:</strong> <?php echo htmlspecialchars($tour['tour_code']); ?></div>
                        <div><strong>Thời lượng:</strong> <?php echo htmlspecialchars($tour['duration']); ?></div>
                        <div><strong>Đơn giá:</strong> <span class="text-success fw-bold"><?php echo number_format($tour['price_default'], 0, ',', '.'); ?>đ/Người</span></div>
                    </div>
                </div>
                <hr>
                <!-- Các thông tin khác sẽ hiển thị dọc phía dưới -->
            <?php else: ?>
                <div class="text-danger">Không tìm thấy thông tin tour.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
<?php
include __DIR__ . '/../partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/DetailTour.js"></script>
<script src="js/BookingTour.js"></script>

</html>