document.addEventListener("DOMContentLoaded", () => {
	const cursor = document.createElement("div");
	cursor.className = "cb-cursor";
	document.body.appendChild(cursor);

	document.addEventListener("mousemove", (e) => {
		cursor.style.transform = `translate3d(${e.clientX}px, ${e.clientY}px, 0)`;
	});

	document.querySelectorAll("[data-cursor]").forEach((el) => {
		el.addEventListener("mouseenter", () => {
			cursor.classList.add("active");
		});
		el.addEventListener("mouseleave", () => {
			cursor.classList.remove("active");
		});
	});
});

