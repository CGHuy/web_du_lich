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

function getTotalQuantity() {
	const adults = parseInt(document.getElementById("adults")?.value || 1) || 1;
	const children =
		parseInt(document.getElementById("children")?.value || 0) || 0;
	return adults + children;
}

function checkQuantityWarning() {
	const departureSelect = document.getElementById("departure_id");
	const adultsInput = document.getElementById("adults");
	const childrenInput = document.getElementById("children");

	if (!departureSelect || !adultsInput || !childrenInput) return;

	const selected = departureSelect.options[departureSelect.selectedIndex];
	const maxSeats = parseInt(selected?.dataset.max || 0);
	const currentTotal =
		parseInt(adultsInput.value || 1) + parseInt(childrenInput.value || 0);

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
	const totalQuantity = getTotalQuantity();
	const price = parseInt(
		departureSelect?.options[departureSelect.selectedIndex]?.dataset.price || 0
	);

	document.getElementById("moving-price-value").textContent =
		price > 0 ? formatCurrency(price) : "0đ";

	const totalPrice = price * totalQuantity;
	document.getElementById("moving-total-value").textContent =
		price > 0 ? formatCurrency(totalPrice) : "0đ";

	const tourMovingTotal = document.getElementById("tour-moving-total");
	if (tourMovingTotal) {
		tourMovingTotal.textContent =
			price > 0 ? formatCurrency(totalPrice) : "Chưa chọn điểm khởi hành";
	}
}

function updateTourCost() {
	const adults = parseInt(document.getElementById("adults")?.value || 1) || 1;
	const children =
		parseInt(document.getElementById("children")?.value || 0) || 0;
	const totalQuantity = adults + children;

	const tourCard = document.querySelector(".tour-info");
	const priceAdult = parseInt(
		tourCard?.getAttribute("data-price-per-person") || 0
	);
	const priceChild = parseInt(tourCard?.getAttribute("data-price-child") || 0);

	document.getElementById("tour-quantity").textContent = totalQuantity;
	document.getElementById("adults-count").textContent = adults;
	document.getElementById("children-count").textContent = children;

	const adultsCost = adults * priceAdult;
	const childrenCost = children * priceChild;

	document.getElementById("adults-cost").textContent =
		formatCurrency(adultsCost);
	document.getElementById("children-cost").textContent =
		formatCurrency(childrenCost);
	document.getElementById("tour-cost").textContent = formatCurrency(
		adultsCost + childrenCost
	);

	const departureSelect = document.getElementById("departure_id");
	if (!departureSelect?.value) {
		document.getElementById("tour-total-amount").textContent =
			"Chưa chọn đủ thông tin";
	} else {
		const movingText = document
			.getElementById("moving-total-value")
			?.textContent.replace(/\D/g, "");
		const movingTotal = parseInt(movingText || 0);
		const total = adultsCost + childrenCost + movingTotal;
		document.getElementById("tour-total-amount").textContent =
			formatCurrency(total);
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

	adultsInput?.addEventListener("input", function () {
		checkQuantityWarning();
		updateMovingPrice();
		updateTourCost();
	});

	childrenInput?.addEventListener("input", function () {
		checkQuantityWarning();
		updateMovingPrice();
		updateTourCost();
	});

	["contact_name", "contact_phone", "contact_email"].forEach((id) => {
		document.getElementById(id)?.addEventListener("input", validateBookingForm);
	});

	updateMovingPrice();
	updateTourCost();
	validateBookingForm();
});
