window.addEventListener('mousedown', function (evt) {
    var eles = evt.target;
    var outside = true;
    flyoutElement = document.getElementsByClassName('cart');
    while (eles){
            eles = eles.parentElement
            if(eles==null){break;}
            if(eles.classList.contains('cart')){  outside=false;  break;}
            else if(eles.classList.contains('login')){  outside=false;  break;}
            else if(eles.classList.contains('reg')){  outside=false;  break;}
    }
    if(outside)
    {
        document.getElementsByClassName('cart')[0].style.display = 'none';
        document.getElementsByClassName('user_form shadow')[0].style.display = 'none';
       
    }
   
    })

function setSize(s) {
    document.getElementsByClassName('size')[0].value = s;
}


function addressCheck() {
    var strAddress = document.getElementById("address").value;
    if (strAddress.length > 10) {
        return true;
    } else {
        alert("Address Length must be greater than 10");
        return false;
    }
};


function postCodeCheck() {
    var strPostal = document.getElementById("Postal").value;
    var postcodeReg = /\b\d{6}\b/;
    if (postcodeReg.test(strPostal)) {
        alert("Postal code must be 6 digits");
        return false;
    } else {
        return true;
    }
};

function checkForm() {
    var strEmail = document.getElementById("email").value;
    var flag = checkEmail(strEmail) && addressCheck() && postCodeCheck();
    return flag;
}


function showLogin() {
    var item = document.getElementsByClassName('user_form')[0].style.display = 'block';
    var item = document.getElementsByClassName('login')[0].style.display = 'block';
    var item = document.getElementsByClassName('reg')[0].style.display = 'none';
    var item = document.getElementsByClassName('cart')[0].style.display = 'none';
}

function showRegister() {
    var item = document.getElementsByClassName('login')[0].style.display = 'none';
    var item = document.getElementsByClassName('cart')[0].style.display = 'none';
    var item = document.getElementsByClassName('reg')[0].style.display = 'block';
}

function showCart() {
    var item = document.getElementsByClassName('cart')[0].style.display = 'block';
    var item = document.getElementsByClassName('login')[0].style.display = 'none';
    var item = document.getElementsByClassName('reg')[0].style.display = 'none';
}

function checkStock(elem)
{ var value=elem.value;
    var max=elem.max;
    if (value>max)
    { alert("Not enough Stock")
    elem.value=1;
            }
}

function checkEmail(strEmail) {
    var emailReg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/;
    if (emailReg.test(strEmail)) {
        return true;
    } else {
        alert("Please input a valid email");
        return false;
    }
};

function firstNameCheck() {
    var strfirstName = document.getElementById("firstName").value;
    if (strfirstName.length > 2) {
        return true;
    } else {
        alert("firstName Length must be greater than 2");
        return false;
    }
};


function lastNameCheck() {
    var strlastName = document.getElementById("lastName").value;
    if (strlastName.length > 2) {
        return true;
    } else {
        alert("lastName Length must be greater than 2");
        return false;
    }
};

function checkLoginForm() {
    var strEmail = document.getElementsByClassName("email")[0].value;
    var flag = checkEmail(strEmail);
    return flag;
}

function checkRegForm() {
    var strEmail = document.getElementsByClassName("email")[1].value;
    var flag = checkEmail(strEmail) && firstNameCheck() && lastNameCheck();
    return flag;
}
