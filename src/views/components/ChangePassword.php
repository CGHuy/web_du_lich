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
            $currentPage = 'change-password';
            include __DIR__ . '/../partials/settings-menu.php';
            ?>

            <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                <div class="card-header">
                    <h5 class="card-title">Đổi mật khẩu</h5>
                    <p style="color: #636465ff ;">Cập nhật mật khẩu của bạn để bảo vệ tài khoản</p>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= route('settinguser.updatePassword'); ?>">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu hiện tại</label>
                                    <input name="current_password" type="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input name="new_password" type="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Xác nhận mật khẩu</label>
                                    <input name="confirm_password" type="password" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm px-3">Cập nhật mật khẩu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
<?php include __DIR__ . '/../partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>