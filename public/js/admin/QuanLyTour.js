// js/tour-management.js
document.addEventListener('DOMContentLoaded', function() {

     // Modal xem
     var viewModal = document.getElementById('viewTourModal');
     if (viewModal) {
          viewModal.addEventListener('show.bs.modal', function (event) {
               var button = event.relatedTarget;
               var id = button.getAttribute('data-id');
               var modalBody = viewModal.querySelector('.modal-body');
               modalBody.innerHTML = '<p>Đang tải chi tiết tour...</p>';
               // Có thể dùng AJAX để lấy dữ liệu tour và hiển thị
          });
     }

     // Modal sửa
     var editModal = document.getElementById('editTourModal');

     if (editModal) {
          editModal.addEventListener('show.bs.modal', function (event) {
               var button = event.relatedTarget; // nút Sửa được bấm

               document.getElementById('edit_id').value = button.getAttribute('data-id');
               document.getElementById('edit_name').value = button.getAttribute('data-name');
               document.getElementById('edit_slug').value = button.getAttribute('data-slug');
               document.getElementById('edit_description').value = button.getAttribute('data-description');
               document.getElementById('edit_location').value = button.getAttribute('data-location');
               document.getElementById('edit_region').value = button.getAttribute('data-region');
               document.getElementById('edit_duration').value = button.getAttribute('data-duration');
               document.getElementById('edit_price_default').value = button.getAttribute('data-price_default');
               var tourCoverImage = button.getAttribute('data-cover_image');
               if (tourCoverImage) {
                   document.getElementById('edit_preview').src = `data:image/jpeg;base64,${tourCoverImage}`;
               } else {
                   document.getElementById('edit_preview').style.display = 'none';
               }
          });
     }

     // Modal xóa
     var deleteModal = document.getElementById('deleteTourModal');
     if (deleteModal) {
          deleteModal.addEventListener('show.bs.modal', function (event) {
               var button = event.relatedTarget;
               var id = button.getAttribute('data-id');
               var name = button.getAttribute('data-name');

               document.getElementById('delete_id').value = id;
               document.getElementById('delete_name').innerText = name;
          });
     }
});