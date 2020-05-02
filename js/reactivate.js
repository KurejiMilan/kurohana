var passwordInput, passwordError, passwordToggle, reactivateButton;

function onButtonClick(e) {
    var password = passwordInput.value;
    if (password.trim() === "") {
        e.preventDefault();
        if (password.trim() === "") {
            showError("This field cannot be empty.");
        }
    }
}

function checkInitialError() {
    if (passwordError.innerHTML != "") {
        showError(passwordError.innerHTML);
    }
}

window.onload = function () {
    passwordInput = document.getElementById("reactivate-password");
    passwordError = document.getElementById("error-text");
    passwordToggle = document.getElementById("reactivate-password-toggle");
    reactivateButton = document.getElementById("reactivate-button");

    reactivateButton.addEventListener('click', onButtonClick.bind(this));
    passwordToggle.addEventListener('click', togglePasswordVisiblity);
    passwordInput.addEventListener('focus', hideError);
    checkInitialError();
}

function showError(errorMessage) {
    passwordInput.style.borderColor = "rgb(204, 78, 78)";
    passwordError.innerHTML = errorMessage;
}

function hideError() {
    if (passwordError.innerHTML !== "") {
        passwordInput.style.borderColor = "#AAAAAA";
        passwordError.innerHTML = "";
    }
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