<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h5 class="card-title">Quản lý Dịch vụ</h5>
        <p style="color: #636465ff;">Danh sách các dịch vụ</p>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#serviceModal">Thêm Dịch vụ Mới</button>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã dịch vụ</th>
                    <th>Tên Dịch vụ</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $service): ?>
                        <tr>
                            <td><?= htmlspecialchars($service['id']) ?></td>
                            <td><?= htmlspecialchars($service['service_code'] ?? '') ?></td>
                            <td><?= htmlspecialchars($service['name']) ?></td>
                            <?php
                                $desc = $service['description'] ?? '';
                                $short = mb_substr($desc, 0, 50);
                                ?>
                                <td>
                                <?= htmlspecialchars($short) ?>
                                <?= mb_strlen($desc) > 50 ? '...' : '' ?>
                                </td>

                           <td>
                            <?php if (($service['status'] ?? 0) == 1): ?>
                                <span class="badge bg-success">Hoạt động</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Ngưng</span>
                            <?php endif; ?>
                            </td>
                            <td>
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary btn-edit-service"
                                    data-id="<?= htmlspecialchars($service['id']) ?>"
                                    data-name="<?= htmlspecialchars($service['name']) ?>"
                                    data-slug="<?= htmlspecialchars($service['slug'] ?? '') ?>"
                                    data-service_code="<?= htmlspecialchars($service['service_code'] ?? '') ?>"
                                    data-description="<?= htmlspecialchars($service['description'] ?? '') ?>"
                                    data-icon="<?= htmlspecialchars($service['icon'] ?? '') ?>"
                                    data-status="<?= ($service['status'] ?? 0) ?>"
                                >Sửa</button>
                                <a href="?controller=Service&action=delete&id=<?= htmlspecialchars($service['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Xác nhận xóa dịch vụ này?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có dịch vụ nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Service modal (Add/Edit) -->
<div class="modal fade" id="serviceModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="serviceModalTitle">Thêm Dịch vụ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php
          $action = '?controller=Service&action=store';
          $service = null;
          $errors = [];
          include __DIR__ . '/FormService.php';
        ?>
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const modal = document.getElementById('serviceModal');
  const modalTitle = document.getElementById('serviceModalTitle');
  const form = modal.querySelector('form');

  document.querySelectorAll('.btn-edit-service').forEach(btn => {
    btn.addEventListener('click', function(){
      const id = this.dataset.id;
      const name = this.dataset.name || '';
      const slug = this.dataset.slug || '';
      const description = this.dataset.description || '';
      const serviceCode = this.dataset.service_code || '';
      const status = this.dataset.status == '1';

      modalTitle.textContent = 'Sửa Dịch vụ';
      form.action = '?controller=Service&action=update&id=' + id;

      form.querySelector('[name="name"]').value = name;
      form.querySelector('[name="slug"]').value = slug;
      form.querySelector('[name="description"]').value = description;
      form.querySelector('#service-status').checked = status;

      if (serviceCode) {
        const scField = form.querySelector('.service-code-display');
        if (scField) scField.value = serviceCode;
      }

      new bootstrap.Modal(modal).show();
    });
  });

  modal.addEventListener('hidden.bs.modal', function(){
    modalTitle.textContent = 'Thêm Dịch vụ';
    form.action = '?controller=Service&action=store';
    form.reset();
  });
});
</script>
