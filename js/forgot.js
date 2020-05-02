var label, input, errorText, confirmBtn;

function onButtonClick(e) {
    var detail = input.value;
    if (detail.trim() === "" || !isValidEmail(detail)) {
        e.preventDefault();
        if (detail.trim() === "") {
            showInputError("This field cannot be empty");
        } else if (!isValidEmail(detail)) {
            showInputError("Please enter a valid email address");
        }
    }
}

function checkInitialError() {
    if (errorText.innerHTML != "") {
        showInputError(errorText.innerHTML);
    }
}

window.onload = function () {
    input = document.getElementById("input");
    errorText = document.getElementById("error-text");
    confirmBtn = document.getElementById("confirm-button");

    confirmBtn.addEventListener('click', onButtonClick.bind(this));
    input.addEventListener('focus', hideInputError);
    checkInitialError();
}

function isValidEmail(email) {
    var expression = /\S+@\S+/;
    return expression.test(email.toLowerCase());
}

function showInputError(errorMessage) {
    input.style.borderColor = "rgb(204, 78, 78)";
    errorText.innerHTML = errorMessage;
}

function hideInputError() {
    input.style.borderColor = "#AAAAAA";
    errorText.innerHTML = "";
}