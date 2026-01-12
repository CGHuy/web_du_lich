document.addEventListener('DOMContentLoaded', function() {

     // Modal thêm
     var addModal = document.getElementById('addServiceModal');
     if (addModal) {
          addModal.addEventListener('show.bs.modal', function () {
               var modalBody = addModal.querySelector('.modal-body');
               modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Đang tải form...</p></div>';

               fetch('index.php?controller=Service&action=getAddForm')
                    .then(response => response.text())
                    .then(html => {
                         modalBody.innerHTML = html;
                    })
                    .catch(error => {
                         modalBody.innerHTML = '<div class="alert alert-danger">Lỗi tải form: ' + error.message + '</div>';
                    });
          });
     }

     // Modal sửa
     var editModal = document.getElementById('editServiceModal');
     if (editModal) {
          editModal.addEventListener('show.bs.modal', function (event) {
               var button = event.relatedTarget;
               var id = button.getAttribute('data-id');
               var modalBody = editModal.querySelector('.modal-body');
               modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Đang tải form...</p></div>';

               fetch('index.php?controller=Service&action=getEditForm&id=' + id)
                    .then(response => response.text())
                    .then(html => {
                         modalBody.innerHTML = html;
                    })
                    .catch(error => {
                         modalBody.innerHTML = '<div class="alert alert-danger">Lỗi tải form: ' + error.message + '</div>';
                    });
          });
     }

     // Modal xóa
     var deleteModal = document.getElementById('deleteServiceModal');
     if (deleteModal) {
          deleteModal.addEventListener('show.bs.modal', function (event) {
               var button = event.relatedTarget;
               var id = button.getAttribute('data-id');
               var name = button.getAttribute('data-name');

               document.getElementById('delete_service_id').value = id;
               document.getElementById('delete_service_name').innerText = name;
          });
     }

     // Tìm kiếm
     var searchInput = document.querySelector('.search-input');
     if (searchInput) {
          searchInput.addEventListener('keyup', function() {
               var filter = searchInput.value.toLowerCase();
               var rows = document.querySelectorAll('tbody tr');

               for (var i = 0; i < rows.length; i++) {
                    var idText = rows[i].cells[0].textContent.toLowerCase();
                    var nameText = rows[i].cells[1].textContent.toLowerCase();
                    
                    if (idText.indexOf(filter) > -1 || nameText.indexOf(filter) > -1) {
                         rows[i].style.display = '';
                    } else {
                         rows[i].style.display = 'none';
                    }
               }
          });
     }

});