// BookingTour.js - Xử lý logic giao diện đặt tour (chọn ngày khởi hành, số lượng người, giá di chuyển)
document.addEventListener("DOMContentLoaded", function () {
	const departureSelect = document.getElementById("departure_id");
	const priceMovingInfo = document.getElementById("price-moving-info");
	const quantityInput = document.getElementById("quantity");
	if (!departureSelect) return;

	// Hiển thị giá di chuyển khi chọn lịch khởi hành
	if (priceMovingInfo) {
		departureSelect.addEventListener("change", function () {
			const selected = departureSelect.options[departureSelect.selectedIndex];
			const price =
				selected && selected.dataset.price
					? Number(selected.dataset.price)
					: null;
			if (price) {
				priceMovingInfo.innerHTML =
					'<span class="badge bg-success fs-5 mt-3"><i class="fa fa-truck me-1"></i> Giá di chuyển: ' +
					price.toLocaleString("vi-VN") +
					"đ</span>";
			} else {
				priceMovingInfo.textContent = "";
			}
		});
	}

	// Giới hạn số lượng người theo số chỗ còn lại
	if (quantityInput) {
		departureSelect.addEventListener("change", function () {
			const selected = departureSelect.options[departureSelect.selectedIndex];
			const max =
				selected && selected.dataset.max
					? parseInt(selected.dataset.max)
					: null;
			if (max) {
				quantityInput.max = max;
				if (parseInt(quantityInput.value) > max) quantityInput.value = max;
			} else {
				quantityInput.max = "";
			}
		});
		quantityInput.addEventListener("input", function () {
			if (
				quantityInput.max &&
				parseInt(quantityInput.value) > parseInt(quantityInput.max)
			) {
				quantityInput.value = quantityInput.max;
			}
		});
	}
});
