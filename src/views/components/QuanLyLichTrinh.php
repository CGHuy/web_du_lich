<?php include __DIR__ . '/../partials/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
</head>
<body>
     <div class="container-fluid my-4">
          <div class="d-flex gap-4 px-5">
               <?php
               $currentPage = 'itinerary';
               include __DIR__ . '/../partials/admin-menu.php';
               ?>

               <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                    <div class="card-header">
                         <h5 class="card-title">Lịch trình</h5>
                    </div>
                    <div class="card-body">
                         <a href="#" class="btn btn-primary mb-3">Thêm Lịch Trình Mới</a>
                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th>ID</th>
                                        <th>Tên Lịch Trình</th>
                                        <th>Mô tả</th>
                                        <th>Hành động</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php if (!empty($itineraries)): ?>
                                        <?php foreach ($itineraries as $itinerary): ?>
                                             <tr>
                                                  <td><?= htmlspecialchars($itinerary['id']) ?></td>
                                                  <td><?= htmlspecialchars($itinerary['name']) ?></td>
                                                  <td><?= htmlspecialchars($itinerary['description']) ?></td>
                                                  <td>
                                                       <a href="#" class="btn btn-sm btn-warning">Sửa</a>
                                                       <a href="#" class="btn btn-sm btn-danger">Xóa</a>
                                                  </td>
                                             </tr>
                                        <?php endforeach; ?>
                                   <?php else: ?>
                                        <tr>
                                             <td colspan="4">Không có lịch trình nào.</td>
                                        </tr>
                                   <?php endif; ?>
                              </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</body>

<?php include __DIR__ . '/../partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>