<?php include __DIR__ . '/../partials/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tour</title>
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
                $currentPage = 'tour';
                include __DIR__ . '/../partials/admin-menu.php';
            ?>

            <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                <div class="card-body">
                    <div id="admin-content">
                        <h2>Quản Lý Tour</h2>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTourModal">Thêm Tour Mới</button>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Tour</th>
                                    <th>Mô tả</th>
                                    <th>Giá</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($tours)): ?>
                                    <?php foreach ($tours as $tour): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($tour['id']) ?></td>
                                            <td><?= htmlspecialchars($tour['name']) ?></td>
                                            <td><?= htmlspecialchars($tour['description']) ?></td>
                                            <td><?= number_format($tour['price_default']) ?> VNĐ</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="editTour(<?= $tour['id'] ?>)">Sửa</button>
                                                <button class="btn btn-sm btn-danger" onclick="deleteTour(<?= $tour['id'] ?>)">Xóa</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">Không có tour nào.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Thêm Tour -->
                    <div class="modal fade" id="addTourModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Thêm Tour Mới</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="post" action="?controller=AdminController&action=storeTour" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Tên Tour</label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Slug</label>
                                                <input type="text" name="slug" class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Mô tả</label>
                                                <textarea name="description" class="form-control" rows="3" required></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Địa điểm</label>
                                                <input type="text" name="location" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Khu vực</label>
                                                <input type="text" name="region" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Thời gian (ngày)</label>
                                                <input type="number" name="duration" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Giá mặc định</label>
                                                <input type="number" name="price_default" class="form-control" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Ảnh bìa</label>
                                                <input type="file" name="cover_image" class="form-control" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Sửa Tour -->
                    <div class="modal fade" id="editTourModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Sửa Tour</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="post" action="?controller=AdminController&action=updateTour" enctype="multipart/form-data">
                                    <input type="hidden" name="id" id="editTourId">
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Tên Tour</label>
                                                <input type="text" name="name" id="editName" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Slug</label>
                                                <input type="text" name="slug" id="editSlug" class="form-control">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Mô tả</label>
                                                <textarea name="description" id="editDescription" class="form-control" rows="3" required></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Địa điểm</label>
                                                <input type="text" name="location" id="editLocation" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Khu vực</label>
                                                <input type="text" name="region" id="editRegion" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Thời gian (ngày)</label>
                                                <input type="number" name="duration" id="editDuration" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Giá mặc định</label>
                                                <input type="number" name="price_default" id="editPrice" class="form-control" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Ảnh bìa (để trống nếu không đổi)</label>
                                                <input type="file" name="cover_image" class="form-control" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

<?php include __DIR__ . '/../partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuLinks = document.querySelectorAll('.menu-list a');
    const contentDiv = document.getElementById('admin-content');

    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            // Remove active from all
            document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
            // Add active to parent
            this.closest('.menu-item').classList.add('active');
            const href = this.getAttribute('href');
            fetch(href)
                .then(response => response.text())
                .then(html => {
                    contentDiv.innerHTML = html;
                })
                .catch(error => {
                    contentDiv.innerHTML = '<p>Lỗi khi tải nội dung.</p>';
                });
        });
    });
});

function editTour(id) {
    // Fetch dữ liệu tour từ server
    fetch(`?controller=AdminController&action=getTour&id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editTourId').value = data.id;
            document.getElementById('editName').value = data.name;
            document.getElementById('editSlug').value = data.slug || '';
            document.getElementById('editDescription').value = data.description;
            document.getElementById('editLocation').value = data.location || '';
            document.getElementById('editRegion').value = data.region || '';
            document.getElementById('editDuration').value = data.duration || '';
            document.getElementById('editPrice').value = data.price_default;
            new bootstrap.Modal(document.getElementById('editTourModal')).show();
        })
        .catch(error => alert('Lỗi tải dữ liệu tour'));
}

function deleteTour(id) {
    if (confirm('Bạn có chắc muốn xóa tour này?')) {
        window.location.href = `?controller=AdminController&action=deleteTour&id=${id}`;
    }
}
</script>
</html>