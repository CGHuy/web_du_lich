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

               document.getElementById('id').value = button.getAttribute('data-id');
               document.getElementById('edit_name').value = button.getAttribute('data-name');
               document.getElementById('edit_slug').value = button.getAttribute('data-slug');
               document.getElementById('edit_description').value = button.getAttribute('data-description');
               document.getElementById('edit_location').value = button.getAttribute('data-location');
               document.getElementById('edit_region').value = button.getAttribute('data-region');
               document.getElementById('edit_duration').value = button.getAttribute('data-duration');
               document.getElementById('edit_price_default').value = button.getAttribute('data-price_default');
               var tourCoverImage = button.getAttribute('data-cover_image');
               var previewImg = document.getElementById('edit_preview');

               if (tourCoverImage && tourCoverImage.trim() !== "") {
                    previewImg.src = `data:image/jpeg;base64,${tourCoverImage}`;
                    previewImg.style.display = 'block'; 
               } else {
                    previewImg.src = '';
                    previewImg.style.display = 'none';
               }
          });
     }

     // Modal xóa
     var deleteModal = document.getElementById('deleteTourModal');
     if (deleteModal) {
          deleteModal.addEventListener('show.bs.modal', function (event) {
               var button = event.relatedTarget;
               var id = button.getAttribute('data-id');

               document.getElementById('delete_id').value = id;
               document.getElementById('delete_name').innerText = name;
          });
     }

     // Tìm kiếm
     var searchInput = document.querySelector('.search-input');
     if (searchInput) {
          searchInput.addEventListener('keyup', function() {
               var filter = searchInput.value.toLowerCase();
               var table = document.querySelector('.table-responsive table');
               var tr = table.getElementsByTagName('tr');

               for (var i = 1; i < tr.length; i++) {
                    var tdCode = tr[i].getElementsByTagName('td')[0];
                    var tdName = tr[i].getElementsByTagName('td')[1];
                    var tdLocation = tr[i].getElementsByTagName('td')[2];

                    if (tdCode || tdName || tdLocation) {
                         var tourCodeText = tdCode.textContent || tdCode.innerText;
                         var nameText = tdName.textContent || tdName.innerText;
                         var locationText = tdLocation.textContent || tdLocation.innerText;

                         if (tourCodeText.toLowerCase().indexOf(filter) > -1 || nameText.toLowerCase().indexOf(filter) > -1 || locationText.toLowerCase().indexOf(filter) > -1) {
                              tr[i].style.display = "";
                         } else {
                              tr[i].style.display = "none";
                         }
                    }
               }
          });
     }
});