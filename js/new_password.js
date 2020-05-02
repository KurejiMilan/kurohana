var passwordInput, passwordError, passwordToggle, codeInput, codeError, confirmBtn;


function onButtonClick(e) {
    var password = passwordInput.value;
    var code = codeInput.value;
    if (password.trim() === "" && code.trim() === "") {
        e.preventDefault();
        if (password.trim() === "") {
            showError(passwordInput, passwordError, "This field cannot be empty");
        }
        if (code.trim() === "") {
            showError(codeInput, codeError, "This field cannot be empty");
        }
    }
}

function checkInitialError() {
    if (passwordError.innerHTML != "") {
        showError(passwordInput, passwordError, passwordError.innerHTML);
    }
    if (codeError.innerHTML != "") {
        showError(codeInput, codeError, codeError.innerHTML);
    }
}

window.onload = function () {
    passwordInput = document.getElementById("new-password");
    passwordError = document.getElementById("password-error-text");
    passwordToggle = document.getElementById("new-password-toggle");
    codeInput = document.getElementById("new-password-code");
    codeError = document.getElementById("code-error-text");
    confirmBtn = document.getElementById("new-password-button");

    confirmBtn.addEventListener('click', onButtonClick.bind(this));
    passwordToggle.addEventListener('click', togglePasswordVisiblity);
    passwordInput.addEventListener('focus', hideError.bind(this, passwordInput, passwordError));
    codeInput.addEventListener('focus', hideError.bind(this, codeInput, codeError));
    checkInitialError();
}

function showError(input, error, errorMessage) {
    input.style.borderColor = "rgb(204, 78, 78)";
    error.innerHTML = errorMessage;
}

function hideError(input, error) {
    if (error.innerHTML !== "") {
        input.style.borderColor = "#AAAAAA";
        error.innerHTML = "";
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