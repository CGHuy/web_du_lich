document.addEventListener('DOMContentLoaded', function() {

     function initUserForm(modalBody){
          if (!modalBody) return;
          var emailInput = modalBody.querySelector('#email');
          var phoneInput = modalBody.querySelector('#phone');
          var emailErr = modalBody.querySelector('#email_error');
          var phoneErr = modalBody.querySelector('#phone_error');
          var submitBtn = modalBody.querySelector('#add_submit_btn') || modalBody.querySelector('#edit_submit_btn');
          var idInput = modalBody.querySelector('input[name="id"]');
          var excludeId = idInput ? idInput.value : null;

          function debounce(fn, delay){
               var t;
               return function(){
                    clearTimeout(t);
                    var args = arguments;
                    t = setTimeout(function(){ fn.apply(null, args); }, delay);
               }
          }

          function check(field, value, cb){
               var url = 'index.php?controller=user&action=checkDuplicate&field=' + encodeURIComponent(field) + '&value=' + encodeURIComponent(value);
               if (excludeId) url += '&excludeId=' + encodeURIComponent(excludeId);
               fetch(url).then(function(res){ return res.json(); }).then(function(data){ cb(null, data.exists); }).catch(function(err){ cb(err); });
          }

          function updateState(){
               if (!emailInput || !phoneInput || !submitBtn) return;
               var emailVal = emailInput.value.trim();
               var phoneVal = phoneInput.value.trim();
               var emailDup = false, phoneDup = false;
               var pending = 0;

               function finalize(){
                    if (emailDup) { emailInput.classList.add('is-invalid'); emailErr.textContent = 'Email này đã được đăng ký.'; }
                    else { emailInput.classList.remove('is-invalid'); emailErr.textContent = ''; }
                    if (phoneDup) { phoneInput.classList.add('is-invalid'); phoneErr.textContent = 'Số điện thoại này đã được đăng ký.'; }
                    else { phoneInput.classList.remove('is-invalid'); phoneErr.textContent = ''; }
                    submitBtn.disabled = emailDup || phoneDup;
               }

               if (emailVal) { pending++; check('email', emailVal, function(err, exists){ pending--; if (!err) emailDup = exists; if (pending===0) finalize(); }); }
               if (phoneVal) { pending++; check('phone', phoneVal, function(err, exists){ pending--; if (!err) phoneDup = exists; if (pending===0) finalize(); }); }
               if (pending===0) finalize();
          }

          var deb = debounce(updateState, 400);
          if (emailInput) emailInput.addEventListener('input', deb);
          if (phoneInput) phoneInput.addEventListener('input', deb);

          // Run initial check in case form pre-filled
          setTimeout(updateState, 200);
     }

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
                         initUserForm(modalBody);
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
                         initUserForm(modalBody);
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

               var infoEl = document.getElementById('delete_booking_info');
               var confirmBtn = document.getElementById('confirm_delete_btn');
               if (infoEl) infoEl.textContent = 'Đang kiểm tra lịch đặt...';
               if (confirmBtn) confirmBtn.disabled = true;

               fetch('index.php?controller=user&action=checkBookings&id=' + encodeURIComponent(id))
                    .then(function(res){ return res.json(); })
                    .then(function(data){
                         if (data.success) {
                              if (data.count > 0) {
                                   if (infoEl) infoEl.innerHTML = '<span class="text-danger">Người dùng hiện có ' + data.count + ' booking. Không thể xóa.</span>';
                                   if (confirmBtn) confirmBtn.disabled = true;
                              } else {
                                   if (infoEl) infoEl.innerHTML = '<span class="text-success">Người dùng không có booking. Có thể xóa.</span>';
                                   if (confirmBtn) confirmBtn.disabled = false;
                              }
                         } else {
                              if (infoEl) infoEl.innerHTML = '<span class="text-warning">Không xác định trạng thái đặt chỗ.</span>';
                              if (confirmBtn) confirmBtn.disabled = false;
                         }
                    })
                    .catch(function(err){
                         if (infoEl) infoEl.innerHTML = '<span class="text-warning">Lỗi kiểm tra: ' + err.message + '</span>';
                         if (confirmBtn) confirmBtn.disabled = false;
                    });
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
