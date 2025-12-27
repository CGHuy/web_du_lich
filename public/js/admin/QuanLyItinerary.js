document.addEventListener('DOMContentLoaded', function () {
    // Check if Bootstrap is loaded
    if (typeof bootstrap === 'undefined') {
        alert('Bootstrap chưa được load! Kiểm tra lại file bootstrap.js');
        return;
    }

    const itineraryModalEl = document.getElementById('itineraryModal');
    
    if (itineraryModalEl) {
        const itineraryModal = new bootstrap.Modal(itineraryModalEl);
        const itineraryModalLabel = document.getElementById('itineraryModalLabel');
        const modalBody = itineraryModalEl.querySelector('.modal-body');

        if (itineraryModalLabel && modalBody) {
            // Open modal and load form
            document.querySelectorAll('.open-itinerary-modal').forEach(button => {
                button.addEventListener('click', function () {
                    const tourId = this.dataset.tourId;
                    const tourName = this.dataset.tourName;
                    const actionName = this.dataset.actionName;

                    itineraryModalLabel.textContent = `${actionName} Lịch Trình cho Tour: ${tourName}`;
                    
                    // Show loading
                    modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Đang tải...</span></div><p class="mt-2">Đang tải dữ liệu...</p></div>';
                    
                    itineraryModal.show();

                    // Load form HTML
                    const formUrl = `index.php?controller=itinerary&action=getForm&tour_id=${tourId}`;
                    
                    fetch(formUrl)
                        .then(response => {
                            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                            return response.text();
                        })
                        .then(html => {
                            modalBody.innerHTML = html;
                            initializeItineraryForm();
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
            });

            // Clear modal on close
            itineraryModalEl.addEventListener('hidden.bs.modal', function () {
                modalBody.innerHTML = '';
            });
        }
    }

    // Initialize form functionality
    function initializeItineraryForm() {
        const daysContainer = document.getElementById('itinerary-days-container');
        if (!daysContainer) return;

        const addDayBtn = document.getElementById('add-day-btn');
        const itineraryForm = document.getElementById('itinerary-form');
        const dayTemplate = document.getElementById('itinerary-day-template');

        // Update day numbers and input names
        function updateDayInputs() {
            const dayItems = daysContainer.querySelectorAll('.itinerary-day-item');
            
            dayItems.forEach((item, index) => {
                const dayNumber = index + 1;
                
                const dayTitle = item.querySelector('.day-title');
                if (dayTitle) {
                    dayTitle.innerHTML = `<i class="fas fa-calendar-day text-primary me-2"></i>Ngày ${dayNumber}`;
                }

                const dayNumberInput = item.querySelector('.day-number-input');
                if (dayNumberInput) {
                    dayNumberInput.setAttribute('name', `days[${index}][day_number]`);
                    dayNumberInput.value = dayNumber;
                }
                
                const descriptionTextarea = item.querySelector('.day-description-textarea');
                if (descriptionTextarea) {
                    descriptionTextarea.setAttribute('name', `days[${index}][description]`);
                }
            });
        }

        // Add new day
        function addDay() {
            if (!dayTemplate) return;

            const dayNode = dayTemplate.content.cloneNode(true);
            daysContainer.appendChild(dayNode);
            updateDayInputs();
        }

        // Remove day handler
        daysContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-day-btn')) {
                const dayItems = daysContainer.querySelectorAll('.itinerary-day-item');
                
                if (dayItems.length > 1) {
                    e.target.closest('.itinerary-day-item').remove();
                    updateDayInputs();
                } else {
                    alert('Phải có ít nhất một ngày trong lịch trình!');
                }
            }
        });

        // Add day button
        if (addDayBtn) {
            addDayBtn.addEventListener('click', addDay);
        }

        // Form submit handler
        if (itineraryForm) {
            itineraryForm.addEventListener('submit', function() {
                updateDayInputs();
            });
        }

        // Initial update
        updateDayInputs();

        // Add first day if empty
        if (daysContainer.children.length === 0 && dayTemplate) {
            addDay();
        }
    }
});