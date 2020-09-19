// User profile
document.querySelector(
	'body > header a[href="#profil"]'
).onclick = function () {
	let user_profile = document.querySelector(".user-profile");
	let styles = window.getComputedStyle(user_profile);
	if (styles.getPropertyValue("display") === "none") {
		user_profile.style.display = "block";
	} else {
		user_profile.style.display = "none";
	}
};
