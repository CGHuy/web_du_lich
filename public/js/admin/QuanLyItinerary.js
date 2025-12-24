document.addEventListener('DOMContentLoaded', function () {
    console.log('🔵 Script loaded');

    // Check if Bootstrap is loaded
    if (typeof bootstrap === 'undefined') {
        console.error('❌ Bootstrap is not loaded!');
        alert('Bootstrap chưa được load! Kiểm tra lại file bootstrap.js');
        return;
    }

    const itineraryModalEl = document.getElementById('itineraryModal');
    
    if (itineraryModalEl) {
        const itineraryModal = new bootstrap.Modal(itineraryModalEl);
        const itineraryModalLabel = document.getElementById('itineraryModalLabel');
        const modalBody = itineraryModalEl.querySelector('.modal-body');

        if (itineraryModalLabel && modalBody) {
            document.querySelectorAll('.open-itinerary-modal').forEach(button => {
                button.addEventListener('click', function () {
                    const tourId = this.dataset.tourId;
                    const tourName = this.dataset.tourName;
                    const actionName = this.dataset.actionName;

                    console.log('🎯 Opening modal for tour:', tourId, tourName);

                    itineraryModalLabel.textContent = `${actionName} Lịch Trình cho Tour: ${tourName}`;
                    
                    // Show loading
                    modalBody.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Đang tải...</span></div><p class="mt-2">Đang tải dữ liệu...</p></div>';
                    
                    // Open modal immediately
                    itineraryModal.show();

                    // Load HTML content directly - CHANGED: getData -> getForm
                    const formUrl = `index.php?controller=itinerary&action=getForm&tour_id=${tourId}`;
                    
                    console.log('🌐 Loading form from:', formUrl);

                    fetch(formUrl)
                        .then(response => {
                            console.log('📥 Response status:', response.status);
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.text(); // CHANGED: json() -> text()
                        })
                        .then(html => {
                            console.log('✅ Form loaded successfully');
                            modalBody.innerHTML = html;
                            
                            // Initialize form functionality after HTML is loaded
                            initializeItineraryForm();
                        })
                        .catch(error => {
                            console.error('❌ Load error:', error);
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
                console.log('🔒 Modal closed');
                modalBody.innerHTML = '';
            });
        }
    }

    // Initialize form functionality (for dynamically loaded content)
    function initializeItineraryForm() {
        console.log('🔄 Initializing itinerary form');

        const daysContainer = document.getElementById('itinerary-days-container');
        if (!daysContainer) {
            console.warn('⚠️ Days container not found');
            return;
        }

        const addDayBtn = document.getElementById('add-day-btn');
        const itineraryForm = document.getElementById('itinerary-form');
        const dayTemplate = document.getElementById('itinerary-day-template');

        // Function to update day numbers and names
        function updateDayInputs() {
            const dayItems = daysContainer.querySelectorAll('.itinerary-day-item');
            
            dayItems.forEach((item, index) => {
                const dayNumber = index + 1;
                
                // Update visible title
                const dayTitle = item.querySelector('.day-title');
                if (dayTitle) {
                    dayTitle.textContent = `Ngày ${dayNumber}`;
                }

                // Update hidden input
                const dayNumberInput = item.querySelector('.day-number-input');
                if (dayNumberInput) {
                    dayNumberInput.setAttribute('name', `days[${index}][day_number]`);
                    dayNumberInput.value = dayNumber;
                }

                // Update title input
                const titleInput = item.querySelector('.day-title-input');
                if (titleInput) {
                    titleInput.setAttribute('name', `days[${index}][title]`);
                }

                // Update description textarea
                const descriptionTextarea = item.querySelector('.day-description-textarea');
                if (descriptionTextarea) {
                    descriptionTextarea.setAttribute('name', `days[${index}][description]`);
                }
            });

            console.log(`📊 Updated ${dayItems.length} day items`);
        }

        // Function to add new day
        function addDay() {
            if (!dayTemplate) {
                console.error('❌ Day template not found');
                return;
            }

            const dayNode = dayTemplate.content.cloneNode(true);
            daysContainer.appendChild(dayNode);
            updateDayInputs();
            
            console.log('➕ Added new day');
        }

        // Remove day button handler
        daysContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-day-btn')) {
                const dayItems = daysContainer.querySelectorAll('.itinerary-day-item');
                
                if (dayItems.length > 1) {
                    e.target.closest('.itinerary-day-item').remove();
                    updateDayInputs();
                    console.log('🗑️ Removed day');
                } else {
                    alert('Phải có ít nhất một ngày trong lịch trình!');
                }
            }
        });

        // Add day button
        if (addDayBtn) {
            addDayBtn.addEventListener('click', addDay);
            console.log('✅ Add day button initialized');
        }

        // Form submit handler
        if (itineraryForm) {
            itineraryForm.addEventListener('submit', function(e) {
                console.log('📤 Form submitting');
                updateDayInputs(); // Final update before submit
            });
        }

        // Initial update
        updateDayInputs();

        // If no days exist, add one
        if (daysContainer.children.length === 0 && dayTemplate) {
            console.log('➕ No days found, adding first day');
            addDay();
        }

        console.log('✅ Form initialized successfully');
    }

    console.log('✅ Script initialization complete');
});