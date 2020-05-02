var passwordInput, passwordError, passwordToggle;

window.onload = function () {
    passwordInput = document.getElementById("deactivate-password");
    passwordError = document.getElementById("error-text");
    passwordToggle = document.getElementById("deactivate-password-toggle");

    passwordToggle.addEventListener('click', togglePasswordVisiblity);
}


function togglePasswordVisiblity() {
    if (passwordInput.type == "password") {
        passwordInput.type = "text";
        passwordToggle.style.fill = "rgb(204, 78, 78)";
    } else {
        passwordInput.type = "password";
        passwordToggle.style.fill = "#969696";
    }
}