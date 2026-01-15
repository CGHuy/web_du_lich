<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$currentUser = $_SESSION['user_id'] ?? null;
if (!$currentUser) {
    $redirectUrl = $_SERVER['REQUEST_URI'];
    header('Location: /web_du_lich/public/login.php?redirect=' . urlencode($redirectUrl));
    exit;
}
include __DIR__ . '/../partials/header.php';
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
    <div class="container my-4">
        <div class="row g-4">
            <main class="col-7">
                <form method="post" action="<?= route('BookingTour.payment') ?>" id="booking-form">
                    <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour['id'] ?? ''); ?>">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2 class="card-title">THÔNG TIN LIÊN LẠC</h2>
                        </div>
                        <div class="card-body w-100">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="contact_name" class="form-label">Tên người liên hệ</label>
                                    <input type="text" class="form-control" id="contact_name" name="contact_name" required
                                        value="<?php echo isset($userInfo['fullname']) ? htmlspecialchars($userInfo['fullname']) : ''; ?>">
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="contact_phone" class="form-label">Số điện thoại liên hệ</label>
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" required
                                        value="<?php echo isset($userInfo['phone']) ? htmlspecialchars($userInfo['phone']) : ''; ?>">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="contact_email" class="form-label">Email liên hệ</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email" required
                                        value="<?php echo isset($userInfo['email']) ? htmlspecialchars($userInfo['email']) : ''; ?>">
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
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label for="departure_id" class="form-label fw-bold">Chọn lịch khởi hành</label>
                                        <?php
                                        $hasAvailable = count(array_filter($departures, function ($dep) {
                                            return $dep['seats_available'] > 0;
                                        })) > 0;
                                        ?>
                                        <span class="badge <?php echo $hasAvailable ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $hasAvailable ? '✓ Còn lịch' : '✗ Hết lịch'; ?>
                                        </span>
                                    </div>
                                    <select class="form-select" id="departure_id" name="departure_id" required>
                                        <option value="">-- Chọn ngày khởi hành --</option>
                                        <?php foreach ($departures as $dep): ?>
                                            <?php if ($dep['status'] === 'open'): ?>
                                                <option value="<?php echo $dep['id']; ?>"
                                                    data-max="<?php echo $dep['seats_available']; ?>"
                                                    data-price="<?php echo $dep['price_moving']; ?>"
                                                    data-price-child="<?php echo $dep['price_moving_child']; ?>"
                                                    <?php echo ($dep['seats_available'] == 0 ? 'disabled style=\'color:#ccc;\'' : ''); ?>>
                                                    <?php echo htmlspecialchars($dep['departure_date']) . " - " . htmlspecialchars($dep['departure_location']) . " (Còn " . $dep['seats_available'] . " chỗ)"; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="adults" class="form-label fw-bold">Số lượng người lớn</label>
                                    <input type="number" class="form-control" id="adults" name="adults" min="1" value="1" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="children" class="form-label fw-bold">Số lượng trẻ em</label>
                                    <input type="number" class="form-control" id="children" name="children" min="0" value="0" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Đơn giá di chuyển - Người lớn</label>
                                    <div id="price-moving-adult-info" class="form-control bg-success text-white fw-bold d-flex align-items-center" style="height:44px;padding:0 12px;">
                                        <i class="fa fa-truck me-2"></i> <span id="moving-price-adult-value">0đ</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Đơn giá di chuyển - Trẻ em</label>
                                    <div id="price-moving-child-info" class="form-control bg-success text-white fw-bold d-flex align-items-center" style="height:44px;padding:0 12px;">
                                        <i class="fa fa-truck me-2"></i> <span id="moving-price-child-value">0đ</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tổng phí di chuyển - Người lớn</label>
                                    <div id="total-moving-adult-fee" class="form-control bg-primary text-white fw-bold d-flex align-items-center" style="height:44px;padding:0 12px;">
                                        <i class="fa fa-calculator me-2"></i> <span id="moving-total-adult-value">0đ</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Tổng phí di chuyển - Trẻ em</label>
                                    <div id="total-moving-child-fee" class="form-control bg-primary text-white fw-bold d-flex align-items-center" style="height:44px;padding:0 12px;">
                                        <i class="fa fa-calculator me-2"></i> <span id="moving-total-child-value">0đ</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Tổng phí di chuyển</label>
                                    <div id="total-moving-all-fee" class="form-control bg-warning text-dark fw-bold d-flex align-items-center" style="height:44px;padding:0 12px;">
                                        <i class="fa fa-money-bill me-2"></i> <span id="moving-total-value">Chưa chọn điểm khởi hành</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </main>
            <div class="col-5">
                <div class="card p-4 tour-info" style="align-self: start; border: none; box-shadow: none;font-family: 'Lexend Deca', sans-serif;" data-price-per-person="<?php echo htmlspecialchars($tour['price_default'] ?? 0); ?>" data-price-child="<?php echo htmlspecialchars($tour['price_child'] ?? 0); ?>">
                    <?php if (!empty($tour)): ?>
                        <div class="w-100 d-flex flex-column align-items-center" style="margin:auto;">
                            <div style="width:75%;height:25vh;overflow:hidden;border-radius:12px;margin-left:auto;margin-right:auto;">
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
                            <div class="mt-3 text-start" style="width:75%;margin-left:auto;margin-right:auto;">
                                <div class="fw-bold my-1" style="font-size:1.4rem;line-height:1.3;"><?php echo htmlspecialchars($tour['name']); ?></div>
                                <div><strong>Mã Tour:</strong> <?php echo htmlspecialchars($tour['tour_code']); ?></div>
                                <div><strong>Thời lượng:</strong> <?php echo htmlspecialchars($tour['duration']); ?></div>
                                <div>
                                    <strong>Đơn giá:</strong>
                                    <div style="font-size: 1.25rem;">
                                        <div class="text-primary fw-bold"><?php echo number_format($tour['price_default'], 0, ',', '.'); ?>đ/Người Lớn</div>
                                        <div class="text-primary fw-bold"><?php echo number_format($tour['price_child'], 0, ',', '.'); ?>đ/Trẻ Em</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-start" style="width:75%;margin-left:auto;margin-right:auto;">
                            <!-- Phần Số lượng -->
                            <div style="background-color:#f8f9fa;padding:12px;border-radius:8px;margin-bottom:15px;">
                                <div class="my-2"><strong>Số lượng người:</strong> <span id="tour-quantity" class="text-danger fw-bold" style="font-size:1.1rem;">1</span></div>
                                <div class="my-2"><strong>Số lượng người lớn:</strong> <span id="adults-count" class="text-primary fw-bold" style="font-size:1rem;">1</span></div>
                                <div class="my-2"><strong>Số lượng trẻ em:</strong> <span id="children-count" class="text-primary fw-bold" style="font-size:1rem;">0</span></div>
                            </div>
                            <!-- Phần Chi phí -->
                            <div style="background-color:#e7f3ff;padding:12px;border-radius:8px;margin-bottom:15px;border-left:4px solid #0d6efd;">
                                <div class="my-2"><strong>Chi phí người lớn:</strong> <span id="adults-cost" class="text-primary fw-bold">0đ</span></div>
                                <div class="my-2"><strong>Chi phí trẻ em:</strong> <span id="children-cost" class="text-primary fw-bold">0đ</span></div>
                                <div class="my-2"><strong>Chi phí tour:</strong> <span id="tour-cost" class="text-primary fw-bold"><?php echo number_format($tour['price_default'], 0, ',', '.'); ?>đ</span></div>
                                <div class="my-2"><strong>Đơn giá di chuyển - Người lớn:</strong> <span id="card-moving-price-adult" class="text-primary fw-bold">0đ</span></div>
                                <div class="my-2"><strong>Đơn giá di chuyển - Trẻ em:</strong> <span id="card-moving-price-child" class="text-primary fw-bold">0đ</span></div>
                                <div class="my-2"><strong>Tổng phí - Người lớn:</strong> <span id="card-moving-total-adult" class="text-primary fw-bold">0đ</span></div>
                                <div><strong>Tổng phí - Trẻ em:</strong> <span id="card-moving-total-child" class="text-primary fw-bold">0đ</span></div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-start" style="width:75%;margin-left:auto;margin-right:auto;">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold" style="font-size:1.1rem;">Tổng tiền:</span>
                                        <span id="tour-total-amount" class="fw-bold text-danger" style="font-size:1.3rem;">0đ</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" form="booking-form" class="btn btn-primary w-100 fw-bold" style="font-size:1.1rem;">
                                        <i class="fa fa-check-circle me-2"></i>Đặt tour ngay
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Các thông tin khác sẽ hiển thị dọc phía dưới -->
                    <?php else: ?>
                        <div class="text-danger text-start">Không tìm thấy thông tin tour.</div>
                    <?php endif; ?>
                </div>
            </div>
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