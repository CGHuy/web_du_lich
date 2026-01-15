function validateBookingForm() {
	const name = document.getElementById("contact_name");
	const phone = document.getElementById("contact_phone");
	const email = document.getElementById("contact_email");
	const departure = document.getElementById("departure_id");
	const adults = document.getElementById("adults");
	const children = document.getElementById("children");
	const bookBtn = document.querySelector('button[form="booking-form"]');

	const hasName = name && name.value.trim();
	const hasPhone = phone && phone.value.trim();
	const hasEmail = email && email.value.trim();
	const hasDeparture = departure && departure.value;
	const adultsCount = parseInt(adults?.value || 0);
	const childrenCount = parseInt(children?.value || 0);
	const totalQuantity = adultsCount + childrenCount;
	const hasQuantity = totalQuantity >= 1;

	const warningAlert = document.getElementById("quantity-warning");
	const hasWarning = warningAlert && warningAlert.style.display !== "none";

	const valid =
		hasName &&
		hasPhone &&
		hasEmail &&
		hasDeparture &&
		hasQuantity &&
		!hasWarning;

	if (bookBtn) {
		bookBtn.disabled = !valid;
		if (valid) {
			bookBtn.classList.remove("disabled");
			bookBtn.style.opacity = "1";
		} else {
			bookBtn.classList.add("disabled");
			bookBtn.style.opacity = "0.6";
		}
	}
}

function formatCurrency(num) {
	return Number(num).toLocaleString("vi-VN") + "đ";
}

function checkQuantityWarning() {
	const departureSelect = document.getElementById("departure_id");
	const adultsInput = document.getElementById("adults");
	const childrenInput = document.getElementById("children");

	if (!departureSelect || !adultsInput || !childrenInput) return;

	const selected = departureSelect.options[departureSelect.selectedIndex];
	const maxSeats = parseInt(selected?.dataset.max || 0);
	const currentTotal =
		(parseInt(adultsInput.value) || 1) + (parseInt(childrenInput.value) || 0);

	let warningAlert = document.getElementById("quantity-warning");
	const hasOverflow = currentTotal > maxSeats && maxSeats > 0;

	if (!warningAlert && hasOverflow) {
		warningAlert = document.createElement("div");
		warningAlert.id = "quantity-warning";
		warningAlert.className =
			"alert alert-warning alert-dismissible fade show mt-3";
		warningAlert.setAttribute("role", "alert");
		warningAlert.innerHTML = `<strong>Cảnh báo!</strong> <span id="warning-text"></span><button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
		const lastCol = document.querySelector(".col-md-6:last-of-type");
		lastCol?.parentElement?.parentElement?.insertAdjacentElement(
			"afterend",
			warningAlert
		);
		warningAlert = document.getElementById("quantity-warning");
	}

	if (warningAlert) {
		if (hasOverflow) {
			document.getElementById(
				"warning-text"
			).textContent = `Số lượng người (${currentTotal}) vượt quá số chỗ còn (${maxSeats}). Vui lòng giảm số lượng.`;
			warningAlert.style.display = "block";
		} else {
			warningAlert.style.display = "none";
		}
	}

	validateBookingForm();
}

function updateMovingPrice() {
	const departureSelect = document.getElementById("departure_id");
	const adultsInput = document.getElementById("adults");
	const childrenInput = document.getElementById("children");
	const adults = parseInt(adultsInput?.value) || 1;
	const children = parseInt(childrenInput?.value) || 0;

	const selected = departureSelect?.options[departureSelect.selectedIndex];
	const priceAdult = parseInt(selected?.dataset.price || 0);
	const priceChild = parseInt(selected?.dataset.priceChild || 0);

	// Cập nhật đơn giá di chuyển
	const movingPriceAdultElement = document.getElementById(
		"moving-price-adult-value"
	);
	const movingPriceChildElement = document.getElementById(
		"moving-price-child-value"
	);

	if (movingPriceAdultElement) {
		movingPriceAdultElement.textContent =
			priceAdult > 0 ? formatCurrency(priceAdult) : "0đ";
	}
	if (movingPriceChildElement) {
		movingPriceChildElement.textContent =
			priceChild > 0 ? formatCurrency(priceChild) : "0đ";
	}

	// Tính tổng phí
	const totalPriceAdult = priceAdult * adults;
	const totalPriceChild = priceChild * children;
	const totalPrice = totalPriceAdult + totalPriceChild;

	// Cập nhật tổng phí riêng lẻ
	const movingTotalAdultElement = document.getElementById(
		"moving-total-adult-value"
	);
	const movingTotalChildElement = document.getElementById(
		"moving-total-child-value"
	);

	if (movingTotalAdultElement) {
		movingTotalAdultElement.textContent =
			priceAdult > 0 ? formatCurrency(totalPriceAdult) : "0đ";
	}
	if (movingTotalChildElement) {
		movingTotalChildElement.textContent =
			priceChild > 0 ? formatCurrency(totalPriceChild) : "0đ";
	}

	// Cập nhật tổng phí chung
	const movingTotalElement = document.getElementById("moving-total-value");
	if (movingTotalElement) {
		movingTotalElement.textContent =
			priceAdult > 0 || priceChild > 0
				? formatCurrency(totalPrice)
				: "Chưa chọn điểm khởi hành";
	}

	// Cập nhật card bên phải
	const cardMovingPriceAdult = document.getElementById(
		"card-moving-price-adult"
	);
	const cardMovingPriceChild = document.getElementById(
		"card-moving-price-child"
	);
	const cardMovingTotalAdult = document.getElementById(
		"card-moving-total-adult"
	);
	const cardMovingTotalChild = document.getElementById(
		"card-moving-total-child"
	);

	if (cardMovingPriceAdult) {
		cardMovingPriceAdult.textContent =
			priceAdult > 0 ? formatCurrency(priceAdult) : "0đ";
	}
	if (cardMovingPriceChild) {
		cardMovingPriceChild.textContent =
			priceChild > 0 ? formatCurrency(priceChild) : "0đ";
	}
	if (cardMovingTotalAdult) {
		cardMovingTotalAdult.textContent =
			priceAdult > 0 ? formatCurrency(totalPriceAdult) : "0đ";
	}
	if (cardMovingTotalChild) {
		cardMovingTotalChild.textContent =
			priceChild > 0 ? formatCurrency(totalPriceChild) : "0đ";
	}
}

function updateTourCost() {
	const adults = parseInt(document.getElementById("adults")?.value) || 1;
	const children = parseInt(document.getElementById("children")?.value) || 0;
	const totalQuantity = adults + children;

	const tourCard = document.querySelector(".tour-info");
	const priceAdult = parseInt(
		tourCard?.getAttribute("data-price-per-person") || 0
	);
	const priceChild = parseInt(tourCard?.getAttribute("data-price-child") || 0);

	// Cập nhật số lượng
	const tourQuantityElement = document.getElementById("tour-quantity");
	const adultsCountElement = document.getElementById("adults-count");
	const childrenCountElement = document.getElementById("children-count");

	if (tourQuantityElement) tourQuantityElement.textContent = totalQuantity;
	if (adultsCountElement) adultsCountElement.textContent = adults;
	if (childrenCountElement) childrenCountElement.textContent = children;

	// Tính chi phí tour
	const adultsCost = adults * priceAdult;
	const childrenCost = children * priceChild;

	const adultsCostElement = document.getElementById("adults-cost");
	const childrenCostElement = document.getElementById("children-cost");
	const tourCostElement = document.getElementById("tour-cost");

	if (adultsCostElement) {
		adultsCostElement.textContent = formatCurrency(adultsCost);
	}
	if (childrenCostElement) {
		childrenCostElement.textContent = formatCurrency(childrenCost);
	}
	if (tourCostElement) {
		tourCostElement.textContent = formatCurrency(adultsCost + childrenCost);
	}

	// Tính tổng tiền
	const departureSelect = document.getElementById("departure_id");
	const tourTotalElement = document.getElementById("tour-total-amount");

	if (!departureSelect?.value) {
		if (tourTotalElement) {
			tourTotalElement.textContent = "Chưa chọn đủ thông tin";
		}
	} else {
		// Lấy phí di chuyển từ các phần tử card
		const movingAdultElement = document.getElementById(
			"card-moving-total-adult"
		);
		const movingChildElement = document.getElementById(
			"card-moving-total-child"
		);

		const movingAdultText =
			movingAdultElement?.textContent.replace(/\D/g, "") || "0";
		const movingChildText =
			movingChildElement?.textContent.replace(/\D/g, "") || "0";

		const movingTotalAdult = parseInt(movingAdultText);
		const movingTotalChild = parseInt(movingChildText);
		const movingTotal = movingTotalAdult + movingTotalChild;

		const total = adultsCost + childrenCost + movingTotal;

		if (tourTotalElement) {
			tourTotalElement.textContent = formatCurrency(total);
		}
	}
}

document.addEventListener("DOMContentLoaded", function () {
	const departureSelect = document.getElementById("departure_id");
	const adultsInput = document.getElementById("adults");
	const childrenInput = document.getElementById("children");

	if (!departureSelect) return;

	departureSelect.addEventListener("change", function () {
		checkQuantityWarning();
		updateMovingPrice();
		updateTourCost();
	});

	if (adultsInput) {
		adultsInput.addEventListener("input", function () {
			checkQuantityWarning();
			updateMovingPrice();
			updateTourCost();
		});
	}

	if (childrenInput) {
		childrenInput.addEventListener("input", function () {
			checkQuantityWarning();
			updateMovingPrice();
			updateTourCost();
		});
	}

	["contact_name", "contact_phone", "contact_email"].forEach((id) => {
		const element = document.getElementById(id);
		if (element) {
			element.addEventListener("input", validateBookingForm);
		}
	});

	// Khởi tạo giá trị ban đầu
	updateMovingPrice();
	updateTourCost();
	validateBookingForm();
});
