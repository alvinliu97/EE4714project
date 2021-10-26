// The email format requirement: must include @, and only alphabetical and digit characters, or -/_/.
function validateEmail() {
    var email = document.getElementById("email").value.trim();
    var regExp = /^[\w-_\.]+@[\w-_\.]+$/;
    if (regExp.test(email) == false) {
        showErrorWithMessage($('#email'), "Invalid input");
        return false;
    } else {
        hideErrorWithMessage($('#email'));
        return true;
    }
}

// Vaditdate that the old password must be more than 6 characters in length.
function validateOldPassword() {
    var passwordElement = document.getElementById("oldpassword");
    if (passwordElement.value.length < 6) {
        showErrorWithMessage($('#oldpassword'), "Old password should be > 6 characters");
        return false;
    }

    hideErrorWithMessage($('#oldpassword'));
    return true;
}

// Validate the new password (retyped password) to match with the password that was typed.
function validatePassword() {
    var passwordElement = document.getElementById("password");
    if (passwordElement.value.length < 6) {
        showErrorWithMessage($('#password'), "Password < 6 characters");
        return false;
    }

    hideErrorWithMessage($('#password'));

    if (document.getElementById("password--verify").value) {
        verifyPassword();
    }
    return true;
}

// Verify that the two passwords that were inserted are matching with each other.
function verifyPassword() {
    var passwordElement = document.getElementById("password");
    var passwordVerifyElement = document.getElementById("password--verify");
    if (!passwordElement.value) {
        showErrorWithMessage($('#password'), "Enter your password");
        return false;
    } else if (passwordElement.value != passwordVerifyElement.value) {
        showErrorWithMessage($('#password--verify'), "Password mismatch");
        return false;
    }

    hideErrorWithMessage($('#password--verify'));
    return true;
}

// Authentication wrapper.
function validateAccount() {
    return validateEmail() && validatePassword() && verifyPassword();
}

// Validate the requirement of the names: must only include alphabets or spaces.
function validateName() {
    var regexp = /^[a-zA-Z ]{2,30}$/;
    if (!regexp.test(document.getElementById("name").value.trim())) {
        showErrorWithMessage($('#name'), "Name should contain only alphabets or spaces");
        return false;
    }
    hideErrorWithMessage($('#name'));
    return true;
}


// Authentication wrapper.
function validateRegistration() {
    return validateAccount() && validateName();
}

// Validate account update.
function validateAccountUpdate() {
    var validation = validatePhone() && validateBirthday();
    if (document.getElementById("password").required) {
        validation = validation && validateOldPassword() && validatePassword() && verifyPassword();
    }
}

function validatePhone(){
    var email = document.getElementById("phone").value.trim();
    var regExp = /^[0-9]{8,12}$/;
    if (regExp.test(email) == false) {
        showErrorWithMessage($('#phone'), "phone should be in 8-12 digits");
        return false;
    } else {
        hideErrorWithMessage($('#phone'));
        return true;
    }
}


// Validate birthday: must be split by dashes.
function validateBirthday() {
    var birthday = document.getElementById("birthday").value.trim();
    var regex = /^\d{4,4}-\d{1,2}-\d{1,2}$/;
    if (birthday && birthday.length !== 0) {

        if (!regex.test(birthday)) {
            showErrorWithMessage($('#birthday'), "Please format in YYYY-MM-DD");
            return false;
        }

        var currTime = (new Date()).getTime();
        var birthdayTime = Date.parse(birthday);
        if (isNaN(birthdayTime) || birthdayTime >= currTime) {
            showErrorWithMessage($('#birthday'), "Invalid birthday");
            return false;
        }


    }
    hideErrorWithMessage($('#birthday'));
    return true;

}

// Validate name when checkout.
function validateCheckout() {
    return validateName();
}

// Change password.
function toggleAccountProfile() {
    var buttonElement = document.getElementById("profile-change-password");
    var oldpasswordElement = document.getElementById("profile-oldpassword");
    var passwordElement = document.getElementById("profile-password");
    var verifyPasswordElement = document.getElementById("profile-verifypassword");
    buttonElement.setAttribute("class", buttonElement.getAttribute("class") + " u-is-hidden");
    oldpasswordElement.setAttribute("class", oldpasswordElement.getAttribute("class").substr(0, oldpasswordElement.getAttribute("class").length - 12))
    passwordElement.setAttribute("class", passwordElement.getAttribute("class").substr(0, passwordElement.getAttribute("class").length - 12))
    verifyPasswordElement.setAttribute("class", verifyPasswordElement.getAttribute("class").substr(0, verifyPasswordElement.getAttribute("class").length - 12))
    document.getElementsByName("password--old")[0].required = true;
    document.getElementsByName("password")[0].required = true;
    document.getElementsByName("password--verify")[0].required = true;
}