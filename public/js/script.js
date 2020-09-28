// User profile
window.addEventListener("load", function(event) {
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
		.querySelector('body > header .right a:first-of-type')
		.addEventListener("click", function (e) {
			e.preventDefault();
			toggleProfileMenu(user_profile);
			e.stopPropagation();
		});
});