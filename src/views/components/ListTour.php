
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
    <link rel="stylesheet" href="css/ListTourStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

</head>

<body>
    <main class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h1 class="text-slate-900 dark:text-slate-50 fw-bold mb-3" style="font-size:2rem;">Khám Phá Các Tour Du Lịch
            </h1>
            <div class="d-flex align-items-center gap-2 flex-nowrap">
                <label class="form-label mb-0 text-sm font-medium text-slate-600 dark:text-slate-300" for="sort">Sắp xếp:</label>
                <form method="get" action="<?= route('ListTour.index') ?>" id="sortForm">
                    <?php
                    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                    // Giữ lại các filter khác khi sort
                    $filterFields = ['controller','action','region','duration_range','services','search','min_price','max_price','page'];
                    foreach ($filterFields as $field) {
                        if ($field === 'services' && isset($_GET['services']) && is_array($_GET['services'])) {
                            foreach ($_GET['services'] as $serviceId) {
                                echo '<input type="hidden" name="services[]" value="'.htmlspecialchars($serviceId).'">';
                            }
                        } elseif (isset($_GET[$field]) && $field !== 'services') {
                            echo '<input type="hidden" name="'.$field.'" value="'.htmlspecialchars($_GET[$field]).'">';
                        }
                    }
                    ?>
                    <select name="sort" class="form-select rounded-lg border-slate-300 bg-background-light dark:bg-slate-800 dark:border-slate-700 dark:text-slate-200 h-10 ps-3 pe-4 text-sm focus:border-primary focus:ring-primary" id="sort" onchange="document.getElementById('sortForm').submit()">
                        <option value="" <?php echo ($sort === '') ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="price_asc" <?php echo ($sort === 'price_asc') ? 'selected' : ''; ?>>Giá: Thấp đến cao</option>
                        <option value="price_desc" <?php echo ($sort === 'price_desc') ? 'selected' : ''; ?>>Giá: Cao đến thấp</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="main-body d-flex gap-4">
            <div class="card p-4" style="flex: 0 0 20%; min-height: 65vh; align-self: flex-start;">
                <h5>Bộ lọc</h5>
                <!-- Bộ lọc bên trái -->
                <form method="get" action="<?= route('ListTour.index') ?>">
                    <input type="hidden" name="controller" value="ListTour">
                    <input type="hidden" name="action" value="index">
                    <?php if (isset($_GET['page'])): ?>
                        <input type="hidden" name="page" value="<?php echo htmlspecialchars($_GET['page']); ?>">
                    <?php endif; ?>
                    <div class="mb-4">
                        <label for="priceRange" class="form-label fw-bold">Giá</label>
                        <?php
                        $minPrice = isset($_GET['min_price']) ? (int)$_GET['min_price'] : 500000;
                        $maxPrice = isset($_GET['max_price']) ? (int)$_GET['max_price'] : 10000000;
                        ?>
                        <input type="range" class="form-range" min="500000" max="10000000" step="500000"
                            id="priceRange" name="min_price" value="<?php echo $minPrice; ?>" oninput="document.getElementById('minPriceValue').innerText = this.value.toLocaleString('vi-VN') + 'đ';" onchange="this.form.submit()">
                        <div class="d-flex justify-content-between align-items-center">
                            <span id="minPriceValue"><?php echo number_format($minPrice, 0, ',', '.'); ?>đ</span>
                            <span>10.000.000đ+</span>
                        </div>
                        <input type="hidden" name="max_price" value="<?php echo $maxPrice; ?>">
                    </div>
                    <div class="mb-4">
                        <label for="areaSelect" class="form-label fw-bold">Khu vực</label>
                        <select class="form-select" id="areaSelect" name="region" onchange="this.form.submit()">
                            <option value="" <?php echo (!isset($_GET['region']) || $_GET['region'] === '') ? 'selected' : ''; ?>>Tất cả</option>
                            <option value="Miền Bắc" <?php echo (isset($_GET['region']) && $_GET['region'] === 'Miền Bắc') ? 'selected' : ''; ?>>Miền Bắc</option>
                            <option value="Miền Trung" <?php echo (isset($_GET['region']) && $_GET['region'] === 'Miền Trung') ? 'selected' : ''; ?>>Miền Trung</option>
                            <option value="Miền Nam" <?php echo (isset($_GET['region']) && $_GET['region'] === 'Miền Nam') ? 'selected' : ''; ?>>Miền Nam</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Thời lượng</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="duration_range" id="duration_all" value="" autocomplete="off" onchange="this.form.submit()"
                                <?php echo (!isset($_GET['duration_range']) || $_GET['duration_range'] === '') ? 'checked' : ''; ?> >
                            <label class="btn btn-outline-primary" for="duration_all">Tất cả</label>
                            <input type="radio" class="btn-check" name="duration_range" id="duration1" value="1-3" autocomplete="off" onchange="this.form.submit()"
                                <?php echo (isset($_GET['duration_range']) && $_GET['duration_range'] === '1-3') ? 'checked' : ''; ?> >
                            <label class="btn btn-outline-primary" for="duration1">1–3 ngày</label>
                            <input type="radio" class="btn-check" name="duration_range" id="duration2" value="4+" autocomplete="off" onchange="this.form.submit()"
                                <?php echo (isset($_GET['duration_range']) && $_GET['duration_range'] === '4+') ? 'checked' : ''; ?> >
                            <label class="btn btn-outline-primary" for="duration2">4+ ngày</label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold">Dịch vụ</label>
                        <?php if (isset($allServices) && is_array($allServices)): ?>
                            <?php foreach ($allServices as $service): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="services[]" value="<?php echo $service['id']; ?>" id="service<?php echo $service['id']; ?>"
                                        <?php echo (isset($_GET['services']) && is_array($_GET['services']) && in_array($service['id'], array_map('intval', $_GET['services']))) ? 'checked' : ''; ?>
                                        onchange="this.form.submit()">
                                    <label class="form-check-label" for="service<?php echo $service['id']; ?>">
                                        <?php echo htmlspecialchars($service['name']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
            <div class="list-tour" style="flex: 0 0 calc(80% - 1rem);">
                <div class="p-3">
                    <form method="get" action="<?= route('ListTour.index') ?>" class="search-group" style="margin-bottom: 1rem;">
                        <input type="hidden" name="controller" value="ListTour">
                        <input type="hidden" name="action" value="index">
                        <?php if (isset($_GET['region'])): ?>
                            <input type="hidden" name="region" value="<?= htmlspecialchars($_GET['region']) ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['duration_range'])): ?>
                            <input type="hidden" name="duration_range" value="<?= htmlspecialchars($_GET['duration_range']) ?>">
                        <?php endif; ?>
                        <?php if (isset($_GET['services']) && is_array($_GET['services'])): ?>
                            <?php foreach ($_GET['services'] as $serviceId): ?>
                                <input type="hidden" name="services[]" value="<?= htmlspecialchars($serviceId) ?>">
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (isset($_GET['page'])): ?>
                            <input type="hidden" name="page" value="<?= htmlspecialchars($_GET['page']) ?>">
                        <?php endif; ?>
                        <div class="search-icon">
                            <span class="material-symbols-outlined">
                                <i class="fa-solid fa-magnifying-glass fa-sm"></i>
                            </span>
                        </div>
                        <input class="search-input" name="search" placeholder="Tìm kiếm tour theo tên, địa điểm..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                    </form>
                </div>
                <!-- Danh sách tour: 2 hàng 3 cột, Bootstrap, có phân trang -->
                <div class="container">
                    <div class="row g-3">
                        <?php if (!empty($tours)): ?>
                            <?php foreach ($tours as $tour): ?>
                                <div class="col-4">
                                    <div class="card h-100">
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mime = $finfo->buffer($tour['cover_image']);
                                        $imgData = base64_encode($tour['cover_image']);
                                        ?>
                                        <img src="data:<?php echo $mime; ?>;base64,<?php echo $imgData; ?>"
                                            class="card-img-top p-3" alt="<?php echo htmlspecialchars($tour['name']); ?>">
                                        <div class="card-body py-0 text-center">
                                            <div class="d-flex flex-column h-100">
                                                <div class="mb-2 d-flex justify-content-center gap-2">
                                                    <span class="badge bg-primary">
                                                        <?php echo htmlspecialchars($tour['duration']); ?>
                                                    </span>
                                                    <span class="badge bg-primary">
                                                        <?php echo htmlspecialchars($tour['region']); ?>
                                                    </span>
                                                </div>
                                                <h5 class="card-title"><?php echo htmlspecialchars($tour['name']); ?></h5>
                                                <p class="card-text"><?php echo htmlspecialchars($tour['description']); ?></p>
                                                <div class="d-flex justify-content-between align-items-center mt-1">
                                                    <p class="fw-bold text-primary self-align-center mb-0"
                                                        style="font-size: 1.4rem;">
                                                        <?php echo number_format($tour['price_default'], 0, ',', '.') . 'đ'; ?>
                                                    </p>
                                                    <a href="<?= route('ListTour.details', ['id' => $tour['id']]) ?>" class="btn btn-primary">Xem chi tiết</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p>Không có tour nào để hiển thị.</p>
                            </div>
                        <?php endif; ?>

                        <!-- Pagination -->
                        <?php if (isset($totalPages) && $totalPages > 1): ?>
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php
                                    $currentPage = isset($page) ? $page : 1;
                                    $prevDisabled = $currentPage <= 1 ? 'disabled' : '';
                                    $nextDisabled = $currentPage >= $totalPages ? 'disabled' : '';
                                    $queryStr = $_GET;
                                    ?>
                                    <li class="page-item <?php echo $prevDisabled; ?>">
                                        <a class="page-link" href="?<?php $queryStr['page'] = $currentPage - 1;
                                        echo http_build_query($queryStr); ?>" tabindex="-1">Trước</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                            <a class="page-link" href="?<?php $queryStr['page'] = $i;
                                            echo http_build_query($queryStr); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo $nextDisabled; ?>">
                                        <a class="page-link" href="?<?php $queryStr['page'] = $currentPage + 1;
                                        echo http_build_query($queryStr); ?>">Sau</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
    </main>

</body>
<?php
include __DIR__ . '/../partials/footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>