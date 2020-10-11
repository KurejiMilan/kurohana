var nameInput, nameError,
    emailInput, emailError,
    usernameInput, usernameError,
    passwordInput, passwordError, passwordToggle,
    confirmPasswordInput, confirmPasswordError, confirmPasswordToggle,
    termsCheckbox, checkboxError,
    signupBtn;

// new line of code
function signup_XMLHTTP_request(){
  axios({
    method: 'post',
    url: '',
    baseurl: 'http://127.0.0.1/kurohana/',
    timeout: 1000,
    data: {
      name: name,
      email: email,
      username: username,
      password: password,
      confirmPassword: confirmPassword
    }
  }).then(function(reponse){
      
  }).catch(function(error){

  });
}

function onButtonClick(e) {
    var name = nameInput.value
    var email = emailInput.value;
    var username = usernameInput.value;
    var password = passwordInput.value;
    var confirmPassword = confirmPasswordInput.value;
    if (!termsCheckbox.checked
        || name.trim() === ""
        || email.trim() === ""
        || username.trim() === ""
        || password.trim() === ""
        || confirmPassword.trim() === ""
        || !isValidEmail(email)
        || containsWhitespaces(username)
        || !checkPassword(password, confirmPassword)
    ) {
        e.preventDefault();
        if (name.trim() === "") {
            toggleError(0, true, "This field cannot be empty");
        }
        if (email.trim() === "") {
            toggleError(1, true, "This field cannot be empty");
        } else if (!isValidEmail(email)) {
            toggleError(1, true, "Please enter a valid email address");
        }
        if (username.trim() === "") {
            toggleError(2, true, "This field cannot be empty");
        } else if (containsWhitespaces(username)) {
            toggleError(2, true, "Username cannot contain whitespaces");
        }
        if (password.trim() === "") {
            toggleError(3, true, "This field cannot be empty");
        } else if (password.trim().length < 8 || password.trim().length > 20) {
            toggleError(3, true, "Password length has to be between 8 to 20 characters");
        }
        if (confirmPassword.trim() === "") {
            toggleError(4, true, "This field cannot be empty");
        } else if (password.trim() !== confirmPassword.trim()) {
            toggleError(4, true, "Passwords don’t match");
        }
        if (!termsCheckbox.checked) {
            toggleError(5, true);
        }
    }
}

function checkInitialError() {
    if (nameError.innerHTML != "") {
        showError(nameInput, nameError, nameError.innerHTML);
    }
    if (emailError.innerHTML != "") {
        showError(emailInput, emailError, emailError.innerHTML);
    }
    if (usernameError.innerHTML != "") {
        showError(usernameInput, usernameError, usernameError.innerHTML);
    }
    if (passwordError.innerHTML != "") {
        showError(passwordInput, passwordError, passwordError.innerHTML);
    }
    if (confirmPasswordError.innerHTML != "") {
        showError(confirmPasswordInput, confirmPasswordError, confirmPasswordError.innerHTML);
    }
}

window.onload = function () {
    nameInput = document.getElementById("signup-name");
    nameError = document.getElementById("name-error");
    emailInput = document.getElementById("signup-email");
    emailError = document.getElementById("email-error");
    usernameInput = document.getElementById("signup-username");
    usernameError = document.getElementById("username-error");
    passwordInput = document.getElementById("signup-password");
    passwordError = document.getElementById("password-error");
    passwordToggle = document.getElementById("signup-password-toggle");
    confirmPasswordInput = document.getElementById("signup-confirmPassword");
    confirmPasswordError = document.getElementById("confirmPassword-error");
    confirmPasswordToggle = document.getElementById("signup-confirmPassword-toggle");
    termsCheckbox = document.getElementById("terms-checkbox");
    checkboxError = document.getElementById("checkBox-error");
    signupBtn = document.getElementById("signup-button");

    signupBtn.addEventListener('click', onButtonClick.bind(this));
    nameInput.addEventListener('focus', toggleError.bind(this, 0, false));
    emailInput.addEventListener('focus', toggleError.bind(this, 1, false));
    usernameInput.addEventListener('focus', toggleError.bind(this, 2, false));
    passwordInput.addEventListener('focus', toggleError.bind(this, 3, false));
    confirmPasswordInput.addEventListener('focus', toggleError.bind(this, 4, false));
    termsCheckbox.addEventListener('change', toggleError.bind(this, 5, false));
    passwordToggle.addEventListener('click', togglePasswordVisiblity);
    confirmPasswordToggle.addEventListener('click', toggleConfirmPasswordVisiblity);
    checkInitialError();
}

function isValidEmail(email) {
    var expression = /\S+@\S+/;
    return expression.test(email.toLowerCase());
}

function containsWhitespaces(username) {
    var expression = /\s/;
    return expression.test(username);
}

function checkPassword(password, confirmPassword) {
    if (password.length >= 8 && password.length <= 20) {
        return password === confirmPassword;
    }
    else {
        return false;
    }

}

function toggleError(index, isError, errorMessage) {
    switch (index) {
        case 0: isError ? showError(nameInput, nameError, errorMessage) : hideError(nameInput, nameError);
            break;
        case 1: isError ? showError(emailInput, emailError, errorMessage) : hideError(emailInput, emailError);
            break;
        case 2: isError ? showError(usernameInput, usernameError, errorMessage) : hideError(usernameInput, usernameError);
            break;
        case 3: isError ? showError(passwordInput, passwordError, errorMessage) : hideError(passwordInput, passwordError);
            break;
        case 4: isError ? showError(confirmPasswordInput, confirmPasswordError, errorMessage) : hideError(confirmPasswordInput, confirmPasswordError);
            break;
        case 5: checkboxError.innerHTML = isError ? "Checkbox is unchecked" : "";
    }
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

function toggleConfirmPasswordVisiblity() {
    if (confirmPasswordInput.type == "password") {
        confirmPasswordInput.type = "text";
        confirmPasswordToggle.style.fill = "rgb(204, 78, 78)";
    } else {
        confirmPasswordInput.type = "password";
        confirmPasswordToggle.style.fill = "#969696";
    }
}
