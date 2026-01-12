<?php
// $tour and $images variables are expected
?>

<form id="image-form" action="<?= route('TourImage.upload') ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tour_id" value="<?= htmlspecialchars($tour['id']) ?>">
    <div class="mb-3">
        <label for="images" class="form-label">Tải lên hình ảnh</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
        <div class="form-text">Bạn có thể chọn nhiều ảnh cùng lúc.</div>
    </div>

    <div class="mb-3">
        <label class="form-label">Ảnh hiện có</label>
        <div class="row g-2" id="existing-images">
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $img): ?>
                    <div class="col-6 col-md-4" data-image-id="<?= $img['id'] ?>">
                        <div class="card">
                            <img src="<?= htmlspecialchars($img['image']) ?>" class="card-img-top" style="height:140px; object-fit:cover;">
                            <div class="card-body p-2 text-center">
                                <button type="button" class="btn btn-sm btn-danger btn-delete-image" data-image-id="<?= $img['id'] ?>">Xóa</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">Chưa có ảnh cho tour này.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal-footer p-3 pb-0">
        <button type="submit" class="btn btn-primary px-4">
            <i class="fas fa-upload me-1"></i> Tải lên
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Đóng
        </button>
    </div>
</form>

<script>
// Note: inline script removed in favor of external initializer. Left minimal for compatibility if loaded directly.
</script>
