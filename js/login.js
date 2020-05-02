var emailInput, emailError, passwordInput, passwordError, passwordToggle, loginBtn;


function onButtonClick(e) {
    var email = emailInput.value;
    var password = passwordInput.value;
    if (!isValidEmail(email) || email.trim() === "" || password.trim() === "") {
        e.preventDefault();
        if (email.trim() == "") {
            showEmailError("This field cannot be empty");
        }
        if (password.trim() == "") {
            showPasswordError("This field cannot be empty");
        }
        if (!isValidEmail(email)) {
            showEmailError("Please enter a valid email address");
        }
    }
}

function checkInitialError() {
    if (emailError.innerHTML != "") {
        showEmailError(emailError.innerHTML);
    }
    if (passwordError.innerHTML != "") {
        showPasswordError(passwordError.innerHTML);
    }
}

window.onload = function () {
    emailInput = document.getElementById("login-email");
    emailError = document.getElementById("email-error");
    passwordInput = document.getElementById("login-password");
    passwordError = document.getElementById("password-error");
    passwordToggle = document.getElementById("login-password-toggle");
    loginBtn = document.getElementById("login-button");

    loginBtn.addEventListener('click', onButtonClick.bind(this));
    emailInput.addEventListener('focus', hideEmailError);
    passwordInput.addEventListener('focus', hidePasswordError);
    passwordToggle.addEventListener('click', togglePasswordVisiblity);
    checkInitialError();
}

function isValidEmail(email) {
    var expression = /\S+@\S+/;
    return expression.test(email.toLowerCase())
}

function showEmailError(errorMessage) {
    emailInput.style.borderColor = "rgb(204, 78, 78)";
    emailError.innerHTML = errorMessage;
}

function hideEmailError() {
    if (emailError.innerHTML !== "") {
        emailInput.style.borderColor = "#AAAAAA";
        emailError.innerHTML = "";
    }
}

function showPasswordError(errorMessage) {
    passwordInput.style.borderColor = "rgb(204, 78, 78)";
    passwordError.innerHTML = errorMessage;
}

function hidePasswordError() {
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

// Routing code

// List of supported routes. Any url other than these routes will throw a 404 error

function openLoginPage() {
    document.getElementsByClassName("top-nav")[0].classList.add("login-nav");
    document.getElementById("home-page").style.display = "none";
    document.getElementById("login-page").style.display = "flex";
}

function openHomePage() {
    if (document.getElementsByClassName("top-nav")[0].classList.contains("login-nav")) {
        document.getElementsByClassName("top-nav")[0].classList.remove("login-nav");
        document.getElementById("home-page").style.display = "block";
        document.getElementById("login-page").style.display = "none";
    }
}

const routes = {
    '/': openHomePage
    , '/login': openLoginPage
};

function router() {
    let request = parseRequestURL()
    let parsedURL = (request.resource ? '/' + request.resource : '/')
    let page = routes[parsedURL] ? routes[parsedURL] : openHomePage
    page();
}

function parseRequestURL() {
    let url = location.hash.slice(1).toLowerCase() || '/';
    let r = url.split("/")
    let request = {
        resource: null,
    }
    request.resource = r[1]

    return request
}

// Listen on hash change:
window.addEventListener('hashchange', router);

// Listen on page load:
window.addEventListener('load', router);

