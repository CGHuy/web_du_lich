// Tự động set scroll-margin-top cho các section dựa trên chiều cao menu + 2rem
window.addEventListener("DOMContentLoaded", function () {
	// Tìm menu (có thể là nav, header, hoặc .menu tuỳ dự án)
	var menu = document.querySelector("nav, .menu, header");
	var menuHeight = menu ? menu.offsetHeight : 0;
	var margin = 32; // 2rem ~ 32px
	var scrollMargin = menuHeight + margin;
	document
		.querySelectorAll("section[id$='-section']")
		.forEach(function (section) {
			section.style.scrollMarginTop = scrollMargin + "px";
		});
});
