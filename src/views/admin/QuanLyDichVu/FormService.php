<?php
// expects: $action (form action URL), $method ('post'), $service (assoc array or null), $errors (array)
$name = $service['name'] ?? '';
$slug = $service['slug'] ?? '';
$service_code = $service['service_code'] ?? '';
$description = $service['description'] ?? '';
$icon = $service['icon'] ?? '';
$status = isset($service['status']) ? (int)$service['status'] : 1;
?>
<form action="<?= $action ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
  <div class="mb-3">
    <label class="form-label">Tên Dịch vụ <span class="text-danger">*</span></label>
    <input type="text" name="name" id="service-name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
    <?php if (!empty($errors['name'])): ?><div class="text-danger"><?= $errors['name'] ?></div><?php endif; ?>
  </div>

  <div class="mb-3">
    <label class="form-label">Slug</label>
    <input type="text" name="slug" id="service-slug" class="form-control" value="<?= htmlspecialchars($slug) ?>">
    <div class="form-text">Tự sinh từ tên hoặc chỉnh tay.</div>
  </div>

  <?php if (!empty($service_code)): ?>
  <div class="mb-3">
    <label class="form-label">Mã dịch vụ</label>
    <input type="text" class="form-control service-code-display" value="<?= htmlspecialchars($service_code) ?>" readonly>
  </div>
  <?php endif; ?>

  <div class="mb-3">
    <label class="form-label">Mô tả</label>
    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($description) ?></textarea>
  </div>

  
  <div class="mb-3 form-check">
    <input type="hidden" name="status" value="0">
    <input type="checkbox" name="status" id="service-status" class="form-check-input" value="1" <?= $status ? 'checked' : '' ?>>
    <label class="form-check-label" for="service-status">Hoạt động</label>
  </div>

  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="?controller=Service&action=index" class="btn btn-secondary">Hủy</a>
  </div>
</form>
