<form action="index.php?controller=itinerary&action=save" method="POST" id="itinerary-form">
     <input type="hidden" name="tour_id" id="form-tour-id" value="<?= htmlspecialchars($tour['id']) ?>">
     <div id="itinerary-days-container">
          <?php if (!empty($itineraries)): ?>
               <?php foreach ($itineraries as $index => $day): ?>
               <div class="itinerary-day-item card mb-3 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center px-3 py-2">
                         <h6 class="day-title mb-0">
                              <i class="fas fa-calendar-day text-primary me-2"></i>Ngày <?= $day['day_number'] ?>
                         </h6>
                         <button type="button" class="btn btn-sm btn-outline-danger remove-day-btn">
                              <i class="fas fa-trash-alt"></i>
                         </button>
                    </div>
                    <div class="card-body p-3">
                         <input type="hidden" class="day-number-input" name="days[<?= $index ?>][day_number]" value="<?= $day['day_number'] ?>">
                         
                         <div class="form-group">
                              <label class="form-label fw-bold">
                                   <i class="fas fa-align-left text-secondary me-1"></i>Mô tả
                              </label>
                              <textarea 
                                   class="form-control day-description-textarea" 
                                   name="days[<?= $index ?>][description]" 
                                   rows="3" 
                                   placeholder="Nhập mô tả chi tiết các hoạt động trong ngày này..."
                                   required><?= htmlspecialchars($day['description']) ?>
                              </textarea>
                         </div>
                    </div>
               </div>
               <?php endforeach; ?>
          <?php else: ?>
               <!-- Nếu chưa có itinerary, thêm 1 ngày trống -->
               <div class="itinerary-day-item card mb-3 shadow-sm">
               <div class="card-header bg-light d-flex justify-content-between align-items-center px-3 py-2">
                    <h6 class="day-title mb-0">
                         <i class="fas fa-calendar-day text-primary me-2"></i>Ngày 1
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-day-btn" title="Xóa ngày này">
                         <i class="fas fa-trash-alt"></i>
                    </button>
               </div>
               <div class="card-body p-3">
                    <input type="hidden" class="day-number-input" name="days[0][day_number]" value="1">
                    
                    <div class="form-group">
                         <label class="form-label fw-bold">
                              <i class="fas fa-align-left text-secondary me-1"></i>Mô tả
                         </label>
                         <textarea 
                              class="form-control day-description-textarea" 
                              name="days[0][description]" 
                              rows="3" 
                              placeholder="Nhập mô tả chi tiết các hoạt động trong ngày này..."
                              required>
                         </textarea>
                    </div>
               </div>
               </div>
          <?php endif; ?>
     </div>

     <div class="d-flex justify-content-between align-items-center my-3">
          <button type="button" class="btn btn-success" id="add-day-btn">
               <i class="fas fa-plus-circle me-1"></i> Thêm Ngày Mới
          </button>
     </div>
     <div class="modal-footer p-3 pb-0">
          <button type="submit" class="btn btn-primary px-4">
               <i class="fas fa-save me-1"></i> Lưu Lịch Trình
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
               <i class="fas fa-times me-1"></i> Hủy
          </button>
     </div>
</form>


<!-- Template ngày -->
<template id="itinerary-day-template">
     <div class="itinerary-day-item card mb-3 shadow-sm">
          <div class="card-header bg-light d-flex justify-content-between align-items-center px-3 py-2">
               <h6 class="day-title mb-0">
                    <i class="fas fa-calendar-day text-primary me-2"></i>Ngày
               </h6>
               <button type="button" class="btn btn-sm btn-outline-danger remove-day-btn" title="Xóa ngày này">
                    <i class="fas fa-trash-alt"></i>
               </button>
          </div>
          <div class="card-body p-3">
               <input type="hidden" class="day-number-input" value="">
               
               <div class="form-group">
                    <label class="form-label fw-bold">
                         <i class="fas fa-align-left text-secondary me-1"></i>Mô tả
                    </label>
                    <textarea 
                         class="form-control day-description-textarea" 
                         rows="3" 
                         placeholder="Nhập mô tả chi tiết các hoạt động trong ngày này..."
                         required>
                    </textarea>
               </div>
          </div>
     </div>
</template>