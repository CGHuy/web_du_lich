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
    <title>Thanh Toán - Web Du Lịch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white d-flex justify-content-center align-items-center position-relative"
                        style="padding: 1.5rem;">
                        <h2 class="card-title text-white mb-0">THANH TOÁN ĐẶT TOUR</h2>
                        <a href="javascript:history.back()" class="btn btn-white btn-sm position-absolute"
                            style="right:20px;top:50%;transform:translateY(-50%);">
                            <i class="fa fa-arrow-left text-white" style="font-size: 1.3rem;"></i>
                        </a>
                    </div>
                    <div class="card-body p-5">
                        <!-- Thông tin tour -->
                        <div style="background-color:#f8f9fa;padding:20px;border-radius:8px;margin-bottom:30px;">
                            <h4 class="mb-3">
                                <strong><?php echo htmlspecialchars($tour['name'] ?? 'Chưa chọn tour'); ?></strong>
                            </h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Mã Tour:</strong>
                                        <?php echo htmlspecialchars($tour['tour_code'] ?? ''); ?></p>
                                    <p><strong>Ngày khởi hành:</strong>
                                        <?php echo htmlspecialchars($departure['departure_date'] ?? ''); ?></p>
                                    <p><strong>Điểm khởi hành:</strong>
                                        <?php echo htmlspecialchars($departure['departure_location'] ?? ''); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Số lượng người:</strong> <span
                                            class="text-danger fw-bold"><?php echo $total_quantity ?? 0; ?></span></p>
                                    <p><strong>Số lượng người lớn:</strong> <?php echo $adults ?? 0; ?></p>
                                    <p><strong>Số lượng trẻ em:</strong> <?php echo $children ?? 0; ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Chi tiết giá -->
                        <div
                            style="background-color:#e7f3ff;padding:20px;border-radius:8px;border-left:4px solid #0d6efd;margin-bottom:30px;">
                            <h5 class="mb-3"><strong>Chi Tiết Giá</strong></h5>

                            <!-- Người lớn -->
                            <div class="mb-3">
                                <h6 class="text-primary mb-2"> <strong>Chi Phí Người Lớn (<?php echo $adults ?? 0; ?>
                                        người)</strong></h6>
                                <div class="row mb-1" style="margin-left: 20px;">
                                    <div class="col-md-7">
                                        <p class="mb-1">Giá tour: <?php echo $adults ?? 0; ?> × <span
                                                class="fw-bold"><?php echo number_format($tour['price_default'] ?? 0, 0, ',', '.'); ?>đ</span>
                                        </p>
                                        <small class="text-muted">=
                                            <?php echo number_format($adults_cost ?? 0, 0, ',', '.'); ?>đ</small>
                                    </div>
                                </div>
                                <div class="row mb-1" style="margin-left: 20px;">
                                    <div class="col-md-7">
                                        <p class="mb-1">Phí di chuyển: <?php echo $adults ?? 0; ?> × <span
                                                class="fw-bold"><?php echo number_format($departure['price_moving'] ?? 0, 0, ',', '.'); ?>đ</span>
                                        </p>
                                        <small class="text-muted">=
                                            <?php echo number_format($moving_adults ?? 0, 0, ',', '.'); ?>đ</small>
                                    </div>
                                </div>
                                <div class="row" style="margin-left: 20px;">
                                    <div class="col-md-7 text-end">
                                        <p><strong>Cộng:
                                                <?php echo number_format(($adults_cost ?? 0) + ($moving_adults ?? 0), 0, ',', '.'); ?>đ</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Trẻ em -->
                            <?php if (($children ?? 0) > 0): ?>
                                <div class="mb-3">
                                    <h6 class="text-success mb-2"> <strong>Chi Phí Trẻ Em (<?php echo $children ?? 0; ?>
                                            người)</strong></h6>
                                    <div class="row mb-1" style="margin-left: 20px;">
                                        <div class="col-md-7">
                                            <p class="mb-1">Giá tour: <?php echo $children ?? 0; ?> × <span
                                                    class="fw-bold"><?php echo number_format($tour['price_child'] ?? 0, 0, ',', '.'); ?>đ</span>
                                            </p>
                                            <small class="text-muted">=
                                                <?php echo number_format($children_cost ?? 0, 0, ',', '.'); ?>đ</small>
                                        </div>
                                    </div>
                                    <div class="row mb-1" style="margin-left: 20px;">
                                        <div class="col-md-7">
                                            <p class="mb-1">Phí di chuyển: <?php echo $children ?? 0; ?> × <span
                                                    class="fw-bold"><?php echo number_format($departure['price_moving_child'] ?? 0, 0, ',', '.'); ?>đ</span>
                                            </p>
                                            <small class="text-muted">=
                                                <?php echo number_format($moving_children ?? 0, 0, ',', '.'); ?>đ</small>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-left: 20px;">
                                        <div class="col-md-7 text-end">
                                            <p><strong>Cộng:
                                                    <?php echo number_format(($children_cost ?? 0) + ($moving_children ?? 0), 0, ',', '.'); ?>đ</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><strong>TỔNG TIỀN:</strong></h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h4 class="text-danger fw-bold">
                                        <?php echo number_format($total_price ?? 0, 0, ',', '.'); ?>đ
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <!-- Mã QR -->
                        <div style="background-color:#fff3cd;padding:20px;border-radius:8px;border:2px dashed #ffc107;margin-bottom:30px;text-align:center;cursor:pointer;"
                            onclick="confirmBooking();">
                            <p class="mb-3"><strong>Click QR để thanh toán</strong></p>
                            <div style="background:white;padding:10px;border-radius:8px;display:inline-block;">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode('Thanh toan tour - ' . ($total_price ?? 0) . ' VND'); ?>"
                                    alt="QR Code" style="width:200px;height:200px;">
                            </div>
                        </div>

                        <!-- Form ẩn để submit khi click QR -->
                        <form method="post" action="<?= route('BookingTour.confirmPayment') ?>" id="payment-form"
                            style="display:none;">
                            <input type="hidden" name="departure_id"
                                value="<?php echo htmlspecialchars($departure_id ?? ''); ?>">
                            <input type="hidden" name="adults" value="<?php echo htmlspecialchars($adults ?? 0); ?>">
                            <input type="hidden" name="children"
                                value="<?php echo htmlspecialchars($children ?? 0); ?>">
                            <input type="hidden" name="contact_name"
                                value="<?php echo htmlspecialchars($contact_name ?? ''); ?>">
                            <input type="hidden" name="contact_phone"
                                value="<?php echo htmlspecialchars($contact_phone ?? ''); ?>">
                            <input type="hidden" name="contact_email"
                                value="<?php echo htmlspecialchars($contact_email ?? ''); ?>">
                            <input type="hidden" name="note" value="<?php echo htmlspecialchars($note ?? ''); ?>">
                            <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour_id ?? 0); ?>">
                        </form>

                        <script>
                            function confirmBooking() {
                                // Hiển thị toast thành công
                                showSuccessToast();

                                // Submit form sau 1 giây
                                setTimeout(() => {
                                    document.getElementById('payment-form').submit();
                                }, 1000);
                            }

                            function showSuccessToast() {
                                // Tạo toast container nếu chưa có
                                let toastContainer = document.getElementById('toast-container');
                                if (!toastContainer) {
                                    toastContainer = document.createElement('div');
                                    toastContainer.id = 'toast-container';
                                    toastContainer.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;';
                                    document.body.appendChild(toastContainer);
                                }

                                // Tạo toast element
                                const toast = document.createElement('div');
                                toast.style.cssText = `
                                    background-color:#28a745;
                                    color:white;
                                    padding:16px 24px;
                                    border-radius:8px;
                                    box-shadow:0 4px 12px rgba(0,0,0,0.15);
                                    font-size:16px;
                                    font-weight:600;
                                    display:flex;
                                    align-items:center;
                                    gap:12px;
                                    animation:slideIn 0.3s ease-out;
                                    margin-bottom:10px;
                                `;
                                toast.innerHTML = `
                                    <i class="fa fa-check-circle" style="font-size:20px;"></i>
                                    <span>Thanh toán thành công! Đang chuyển hướng...</span>
                                `;

                                toastContainer.appendChild(toast);

                                // Xóa toast sau 3 giây
                                setTimeout(() => {
                                    toast.remove();
                                }, 3000);
                            }

                            // Thêm keyframe animation
                            const style = document.createElement('style');
                            style.textContent = `
                                @keyframes slideIn {
                                    from {
                                        transform: translateX(400px);
                                        opacity: 0;
                                    }
                                    to {
                                        transform: translateX(0);
                                        opacity: 1;
                                    }
                                }
                            `;
                            document.head.appendChild(style);
                        </script>

                        <!-- Thông tin liên lạc -->
                        <hr class="my-4">
                        <div
                            style="background-color:#e8f5e9;padding:20px;border-radius:8px;border-left:4px solid #28a745;">
                            <h5 class="mb-3"><strong>Thông Tin Liên Lạc</strong></h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Tên:</strong>
                                        <?php echo htmlspecialchars($contact_name ?? ''); ?></p>
                                    <p class="mb-2"><strong>Điện thoại:</strong>
                                        <?php echo htmlspecialchars($contact_phone ?? ''); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Email:</strong>
                                        <?php echo htmlspecialchars($contact_email ?? ''); ?></p>
                                    <p class="mb-2"><strong>Ghi chú:</strong>
                                        <?php echo htmlspecialchars($note ?? 'Không có'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
include __DIR__ . '/../partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>