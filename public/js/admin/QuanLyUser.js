document.addEventListener('DOMContentLoaded', function() {

     // Modal thêm
     var addModal = document.getElementById('addUserModal');
     if (addModal) {
          addModal.addEventListener('show.bs.modal', function () {
               var modalBody = addModal.querySelector('.modal-body');
               modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Đang tải form...</p></div>';
               
               fetch('index.php?controller=user&action=getAddForm')
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
     var editModal = document.getElementById('editUserModal');
     if (editModal) {
          editModal.addEventListener('show.bs.modal', function (event) {
               var button = event.relatedTarget;
               var id = button.getAttribute('data-id');
               var modalBody = editModal.querySelector('.modal-body');
               modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Đang tải form...</p></div>';
               
               fetch('index.php?controller=user&action=getEditForm&id=' + id)
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
     var deleteModal = document.getElementById('deleteUserModal');
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
               var table = document.querySelector('.table');
               var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

               for (var i = 0; i < rows.length; i++) {
                    var idElement = rows[i].querySelector('.find_id');
                    var nameElement = rows[i].querySelector('.find_name');
                    var emailElement = rows[i].querySelector('.find_email');
                    var phoneElement = rows[i].querySelector('.find_phone');
                    var roleElement = rows[i].querySelector('.find_role');

                    var idText = idElement ? idElement.textContent || idElement.innerText : '';
                    var nameText = nameElement ? nameElement.textContent || nameElement.innerText : '';
                    var emailText = emailElement ? emailElement.textContent || emailElement.innerText : '';
                    var phoneText = phoneElement ? phoneElement.textContent || phoneElement.innerText : '';
                    var roleText = roleElement ? roleElement.textContent || roleElement.innerText : '';

                    if (idText.toLowerCase().indexOf(filter) > -1 ||
                         nameText.toLowerCase().indexOf(filter) > -1 ||
                         emailText.toLowerCase().indexOf(filter) > -1 ||
                         phoneText.toLowerCase().indexOf(filter) > -1 ||
                         roleText.toLowerCase().indexOf(filter) > -1) {
                         rows[i].classList.remove('d-none');
                    } else {
                         rows[i].classList.add('d-none');
                    }
               }
          });
     }
});
