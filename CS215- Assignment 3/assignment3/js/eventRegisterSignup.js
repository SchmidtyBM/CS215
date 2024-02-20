let email = document.getElementById("email");
email.addEventListener("blur", emailHandler);

let username = document.getElementById("username");
username.addEventListener("blur", usernameHandler);

let avatar = document.getElementById("avatar");
avatar.addEventListener("blur", avatarHandler);

let password = document.getElementById("password");
password.addEventListener("blur", passwordHandler);

let confirmPassword = document.getElementById("confirmPassword");
confirmPassword.addEventListener("blur", confirmPasswordHandler);

let form = document.getElementById("signup-form");
form.addEventListener("submit", validateSignup);