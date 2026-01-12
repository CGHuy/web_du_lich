(function(){
    console.log('QuanLyHinhAnh.js loaded');

    function start() {
        // Open images modal and load form
        var imagesModalEl = document.getElementById('imagesModal');
        if (!imagesModalEl) return;

        // Wait/retry until bootstrap is available
        if (typeof bootstrap === 'undefined') {
            console.warn('Bootstrap chưa được load, sẽ thử lại...');
            setTimeout(start, 100);
            return;
        }

        var imagesModal = new bootstrap.Modal(imagesModalEl);
        var modalBody = imagesModalEl.querySelector('.modal-body');

        imagesModalEl.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            if (!button) return;
            var formUrl = button.getAttribute('data-form-url') || ('index.php?controller=TourImage&action=getForm&tour_id=' + encodeURIComponent(button.getAttribute('data-tour-id')));

            console.log('Opening images modal, fetching', formUrl);
            modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Đang tải...</p></div>';

            fetch(formUrl)
                .then(function(res){ if (!res.ok) throw new Error('HTTP ' + res.status); return res.text(); })
                .then(function(html){
                    modalBody.innerHTML = html;
                    try { initImageForm(modalBody); } catch (e) { console.error(e); }
                })
                .catch(function(err){
                    console.error('Lỗi fetch form:', err);
                    modalBody.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Lỗi tải form: ' + err.message + '</div>';
                });
        });

        imagesModalEl.addEventListener('hidden.bs.modal', function(){
            if (modalBody) modalBody.innerHTML = '';
            // Ensure any leftover backdrop is removed and body state restored
            try {
                document.querySelectorAll('.modal-backdrop').forEach(function(el){ el.parentNode && el.parentNode.removeChild(el); });
                document.body.classList.remove('modal-open');
                // remove inline padding if set by Bootstrap
                document.body.style.paddingRight = '';
            } catch (e) {
                console.warn('Cleanup modal backdrop failed', e);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', start);
    } else {
        start();
    }
})();

    // Fallback: delegated click handler for buttons with class .open-images-modal
    // This helps if Bootstrap's data-bs handlers are not firing for some reason.
    document.addEventListener('click', function(e){
        var btn = e.target.closest && e.target.closest('.open-images-modal');
        if (!btn) return;
        // prevent bootstrap default handler to avoid double actions
        try { e.preventDefault(); e.stopImmediatePropagation(); } catch (err) {}

        var formUrl = btn.getAttribute('data-form-url') || ('index.php?controller=TourImage&action=getForm&tour_id=' + encodeURIComponent(btn.getAttribute('data-tour-id')));
        var modalEl = document.getElementById('imagesModal');
        if (!modalEl) return;
        var modalBody = modalEl.querySelector('.modal-body');
        modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Đang tải...</p></div>';

        fetch(formUrl)
            .then(function(res){ if (!res.ok) throw new Error('HTTP ' + res.status); return res.text(); })
            .then(function(html){
                modalBody.innerHTML = html;
                try { initImageForm(modalBody); } catch (e) { console.error(e); }
                if (typeof bootstrap !== 'undefined') {
                    var m = new bootstrap.Modal(modalEl);
                    m.show();
                }
            })
            .catch(function(err){
                modalBody.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> Lỗi tải form: ' + err.message + '</div>';
            });
    }, true);

    // Simple search same as others
    var searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            var filter = searchInput.value.toLowerCase();
            var table = document.querySelector('.list-group');
            var items = table.getElementsByTagName('li');

            for (var i = 0; i < items.length; i++) {
                var text = items[i].textContent || items[i].innerText;
                if (text.toLowerCase().indexOf(filter) > -1) {
                    items[i].classList.remove('d-none');
                } else {
                    items[i].classList.add('d-none');
                }
            }
        });
    }

    // Initialize image form: wire delete buttons and optional AJAX upload
    function initImageForm(container){
        if (!container) return;
        var deleteButtons = container.querySelectorAll('.btn-delete-image');
        deleteButtons.forEach(function(btn){
            btn.addEventListener('click', function(){
                var imgId = this.getAttribute('data-image-id');
                if (!confirm('Bạn có chắc muốn xóa hình ảnh này?')) return;

                // send POST to delete endpoint; expects JSON { success: true }
                fetch('index.php?controller=TourImage&action=delete', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + encodeURIComponent(imgId)
                }).then(function(res){ return res.json(); })
                  .then(function(data){
                      if (data && data.success) {
                          // remove image block
                          var col = container.querySelector('[data-image-id="' + imgId + '"]');
                          if (col) col.remove();
                      } else {
                          alert('Xóa ảnh thất bại.');
                      }
                  }).catch(function(err){
                      alert('Lỗi: ' + err.message);
                  });
            });
        });

        // Optional: intercept upload form to show spinner (let server handle upload normally)
        var form = container.querySelector('#image-form');
        if (form) {
            form.addEventListener('submit', function(){
                var btn = form.querySelector('button[type=submit]');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang tải...';
                }
            });
        }
    }


