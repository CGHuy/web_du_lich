// Year selector handler
(function () {
	const yearSelect = document.getElementById("yearSelector");
	if (yearSelect) {
		yearSelect.addEventListener("change", function () {
			const currentUrl = new URL(window.location.href);
			currentUrl.searchParams.set("year", this.value);
			window.location.href = currentUrl.toString();
		});
	}
})();

// Revenue Chart (Bar Chart)
function initRevenueChart(monthlyData) {
	if (!monthlyData || !Array.isArray(monthlyData)) {
		console.warn("Monthly data not available for revenue chart");
		return;
	}

	const revenueCtx = document.getElementById("revenueChart");
	if (!revenueCtx) {
		console.warn("Revenue chart canvas not found");
		return;
	}

	const months = [
		"T1",
		"T2",
		"T3",
		"T4",
		"T5",
		"T6",
		"T7",
		"T8",
		"T9",
		"T10",
		"T11",
		"T12",
	];
	const revenues = monthlyData.map((d) => d.value);

	new Chart(revenueCtx.getContext("2d"), {
		type: "bar",
		data: {
			labels: months,
			datasets: [
				{
					label: "Doanh thu (VNĐ)",
					data: revenues,
					backgroundColor: "#1976d2",
					borderColor: "#1565c0",
					borderWidth: 2,
					borderRadius: 8,
					hoverBackgroundColor: "#1565c0",
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					display: true,
					position: "top",
					labels: {
						padding: 4,
						margin: 0,
						boxHeight: 10,
						font: {
							size: 10,
						},
					},
				},
				filler: true,
			},
			scales: {
				x: {
					ticks: {
						maxRotation: 0,
						minRotation: 0,
					},
				},
				y: {
					beginAtZero: true,
					ticks: {
						callback: function (value) {
							return (value / 1000000).toFixed(0) + "M";
						},
					},
				},
			},
			layout: {
				padding: {
					top: 5,
					bottom: 5,
					left: 5,
					right: 5,
				},
			},
		},
	});
}

// Status Chart (Doughnut Chart)
function initStatusChart(statusData) {
	if (!statusData || typeof statusData !== "object") {
		console.warn("Status data not available for status chart");
		return;
	}

	const statusCtx = document.getElementById("statusChart");
	if (!statusCtx) {
		console.warn("Status chart canvas not found");
		return;
	}

	const confirmed = statusData.confirmed?.count || 0;
	const pendingCancellation = statusData.pending_cancellation?.count || 0;
	const cancelled = statusData.cancelled?.count || 0;

	new Chart(statusCtx.getContext("2d"), {
		type: "doughnut",
		data: {
			labels: ["Đã xác nhận", "Chờ hủy", "Đã hủy"],
			datasets: [
				{
					data: [confirmed, pendingCancellation, cancelled],
					backgroundColor: ["#10b981", "#f59e0b", "#ef4444"],
					borderColor: ["#059669", "#d97706", "#dc2626"],
					borderWidth: 2,
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: {
				legend: {
					position: "bottom",
					labels: {
						padding: 4,
						margin: 0,
						boxHeight: 10,
						font: {
							size: 10,
						},
					},
				},
				tooltip: {
					callbacks: {
						label: function (context) {
							return context.label + ": " + context.parsed + " đơn";
						},
					},
				},
			},
			layout: {
				padding: {
					top: 5,
					bottom: 5,
					left: 5,
					right: 5,
				},
			},
		},
	});
}

// Initialize all charts on page load
document.addEventListener("DOMContentLoaded", function () {
	console.log("Initializing Statistics charts...");

	// Check if Chart.js is loaded
	if (typeof Chart === "undefined") {
		console.error("Chart.js library not loaded");
		return;
	}

	// Initialize revenue chart if data exists
	if (typeof window.monthlyData !== "undefined" && window.monthlyData) {
		console.log("Initializing revenue chart");
		initRevenueChart(window.monthlyData);
	} else {
		console.warn("Monthly data not found in window object");
	}

	// Initialize status chart if data exists
	if (typeof window.statusData !== "undefined" && window.statusData) {
		console.log("Initializing status chart");
		initStatusChart(window.statusData);
	} else {
		console.warn("Status data not found in window object");
	}
});
