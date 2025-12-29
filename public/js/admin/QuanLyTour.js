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

     // Modal thêm
     var addModal = document.getElementById('addTourModal');
     if (addModal) {
          addModal.addEventListener('show.bs.modal', function () {
               var modalBody = addModal.querySelector('.modal-body');
               modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Đang tải form...</p></div>';
               
               fetch('index.php?controller=tour&action=getAddForm')
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
     var editModal = document.getElementById('editTourModal');
     if (editModal) {
          editModal.addEventListener('show.bs.modal', function (event) {
               var button = event.relatedTarget;
               var id = button.getAttribute('data-id');
               var modalBody = editModal.querySelector('.modal-body');
               modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Đang tải form...</p></div>';
               
               fetch('index.php?controller=tour&action=getEditForm&id=' + id)
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

     // Tìm kiếm
     var searchInput = document.querySelector('.search-input');
     if (searchInput) {
          searchInput.addEventListener('keyup', function() {
               var filter = searchInput.value.toLowerCase();
               var list = document.querySelector('.list-group');
               var items = list.getElementsByClassName('list-group-item');

               for (var i = 0; i < items.length; i++) {
                    var nameElement = items[i].querySelector('.find_name');
                    var idElement = items[i].querySelector('.find_id');
                    var locationElement = items[i].querySelector('.find_location');

                    var nameText = nameElement ? nameElement.textContent || nameElement.innerText : '';
                    var idText = idElement ? idElement.textContent || idElement.innerText : '';
                    var locationText = locationElement ? locationElement.textContent || locationElement.innerText : '';

                    if (nameText.toLowerCase().indexOf(filter) > -1 ||
                         idText.toLowerCase().indexOf(filter) > -1 ||
                         locationText.toLowerCase().indexOf(filter) > -1) {
                         items[i].classList.remove('d-none');
                    } else {
                         items[i].classList.add('d-none');
                    }
               }
          });
     }
});