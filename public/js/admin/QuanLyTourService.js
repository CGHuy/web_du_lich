document.addEventListener('DOMContentLoaded', function () {
    
    if (typeof bootstrap === 'undefined') {
        alert('Bootstrap chưa được load!');
        return;
    }

    const serviceModalEl = document.getElementById('serviceModal');
    
    if (serviceModalEl) {
        const serviceModal = new bootstrap.Modal(serviceModalEl);
        const serviceModalLabel = document.getElementById('serviceModalLabel');
        const modalBody = serviceModalEl.querySelector('.modal-body');

        if (serviceModalLabel && modalBody) {
            serviceModalEl.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                if (!button) return;

                const tourId = button.getAttribute('data-tour-id');
                const tourName = button.getAttribute('data-tour-name');
                const actionName = button.getAttribute('data-action-name');
                const formUrl = button.getAttribute('data-form-url');

                serviceModalLabel.textContent = `${actionName} Dịch vụ cho Tour: ${tourName}`;

                modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Đang tải...</span></div><p class="mt-2">Đang tải dữ liệu...</p></div>';

                fetch(formUrl)
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.text();
                    })
                    .then(html => {
                        modalBody.innerHTML = html;
                        // Initialize search after form is loaded
                        initializeServiceSearch();
                    })
                    .catch(error => {
                        modalBody.innerHTML = `
                            <div class="alert alert-danger" role="alert">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Lỗi!</strong> Không thể tải form: ${error.message}
                            </div>
                        `;
                    });
            });

            serviceModalEl.addEventListener('hidden.bs.modal', function () {
                modalBody.innerHTML = '';
            });
        }
    }

    // Search functionality for tour list
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = searchInput.value.toLowerCase();
            const list = document.querySelector('#tour-service-list');
            const items = list.getElementsByClassName('list-group-item');
            
            for (let i = 0; i < items.length; i++) {
                const text = items[i].textContent || items[i].innerText;
                items[i].style.display = text.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
            }
        });
    }

    // Search functionality for services in modal
    function initializeServiceSearch() {
        const serviceSearchInput = document.getElementById('service-search-input');
        if (serviceSearchInput) {
            serviceSearchInput.addEventListener('keyup', function() {
                const filter = serviceSearchInput.value.toLowerCase();
                const serviceItems = document.querySelectorAll('.service-item');
                
                serviceItems.forEach(function(item) {
                    const serviceId = item.getAttribute('data-service-id');
                    const serviceName = item.getAttribute('data-service-name');
                    
                    // Tìm kiếm theo ID hoặc tên
                    if (serviceId.toLowerCase().includes(filter) || serviceName.includes(filter)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    }
});
