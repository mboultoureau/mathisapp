// User profile

const user_profile = document.querySelector(".user-profile");

function toggleProfileMenu(user_profile) {
	let styles = window.getComputedStyle(user_profile);
	user_profile.style.display =
		styles.getPropertyValue("display") === "none" ? "block" : "none";
}

document.querySelector("body").addEventListener("click", function () {
	user_profile.style.display = "none";
});

document
	.querySelector('body > header a[href="#profil"]')
	.addEventListener("click", function (e) {
		e.preventDefault();
		toggleProfileMenu(user_profile);
		e.stopPropagation();
	});

// Showcase
/*
const showcase = document.querySelector(".showcase .content");
const showcase_previous = document.querySelector(
	'.showcase a[href="#previous"]'
);

function updateShowcaseScroll(showcase, showcase_previous) {
	showcase_previous.style.display =
		showcase.scrollLeft > 0 && showcase.scrollWidth >= showcase.offsetWidth
			? "none"
			: "flex";
}

if (showcase) {
	showcase.addEventListener("scroll", function () {
		updateShowcaseScroll(showcase, showcase_previous);
	});
	updateShowcaseScroll(showcase, showcase_previous);
}

window.addEventListener("resize", function () {
	updateShowcaseScroll(showcase, showcase_previous);
});
*/
