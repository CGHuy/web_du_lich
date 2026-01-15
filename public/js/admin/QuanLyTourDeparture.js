document.addEventListener('DOMContentLoaded', function() {
    // Hàm load form thêm/sửa vào modal
    function loadForm(tourDepartureId = null) {
        const url = tourDepartureId 
            ? `?controller=TourDeparture&action=getEditForm&id=${tourDepartureId}` 
            : '?controller=TourDeparture&action=getAddForm';
        
        const modalBody = document.querySelector('#tourDepartureModal .modal-body');
        modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2">Đang tải form...</p></div>';
        
        fetch(url)
            .then(response => response.text())
            .then(data => {
                modalBody.innerHTML = data;
            })
            .catch(error => {
                modalBody.innerHTML = '<div class="alert alert-danger">Lỗi tải form. Vui lòng thử lại.</div>';
                console.error('Error loading form:', error);
            });
    }

    // Sự kiện mở modal thêm
    const addBtn = document.getElementById('addTourDepartureBtn');
    if (addBtn) {
        addBtn.addEventListener('click', function() {
            const modalLabel = document.getElementById('tourDepartureModalLabel');
            if (modalLabel) modalLabel.textContent = 'Thêm Điểm Khởi Hành';
            loadForm();
            const modal = new bootstrap.Modal(document.getElementById('tourDepartureModal'));
            modal.show();
        });
    }

    // Sự kiện mở modal sửa
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-tour-departure-btn')) {
            const btn = e.target.closest('.edit-tour-departure-btn');
            const id = btn.getAttribute('data-id');
            const modalLabel = document.getElementById('tourDepartureModalLabel');
            if (modalLabel) modalLabel.textContent = 'Sửa Điểm Khởi Hành';
            loadForm(id);
            const modal = new bootstrap.Modal(document.getElementById('tourDepartureModal'));
            modal.show();
        }
    });

    // Sự kiện submit form trong modal
    document.addEventListener('submit', function(e) {
        if (e.target.id === 'tourDepartureForm') {
            // Không preventDefault - để form submit bình thường
            // Form sẽ redirect về trang index với session message
        }
    });

    // Sự kiện xóa
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-tour-departure-btn')) {
            const btn = e.target.closest('.delete-tour-departure-btn');
            const id = btn.getAttribute('data-id');
            const name = btn.getAttribute('data-name');
            
            if (confirm(`Bạn có chắc muốn xóa điểm khởi hành "${name}"?`)) {
                // Tạo form ẩn để submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '?controller=TourDeparture&action=delete';
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id';
                input.value = id;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    });

    // Sự kiện tìm kiếm real-time
    const searchInput = document.getElementById('searchTourDeparture');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            const items = document.querySelectorAll('.tour-departure-item');
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
});