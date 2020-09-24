// User profile

const user_profile = document.querySelector(".user-profile");


function showProfileMenu(user_profile) {
	user_profile.style.display = "block";
}

function hideProfileMenu(user_profile) {
	user_profile.style.display = "none";
}

function toggleProfileMenu(user_profile) {
	let styles = window.getComputedStyle(user_profile);
	(styles.getPropertyValue("display") === "none") ? showProfileMenu(user_profile) : hideProfileMenu(user_profile);
}

document.querySelector('body').addEventListener("click", function(e) {
	hideProfileMenu(user_profile);
});

document.querySelector('body > header a[href="#profil"]').addEventListener("click",  function (e) {
	e.preventDefault();
	toggleProfileMenu(user_profile);
	e.stopPropagation();
});