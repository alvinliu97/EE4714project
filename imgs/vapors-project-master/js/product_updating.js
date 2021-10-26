function pickColor(e) {
    var elementId = e.getAttribute("id");
    var sepId = elementId.split("_");
    var sepIdLength = sepId.length;
    var color = sepId[sepIdLength - 1];
    var productId = sepId[sepIdLength - 2];
    var imgElement = document.getElementById(sepId[0] + "_img_" + productId);
    imgElement.src = "./images/" + productId + "_" + color + ".jpg";
}

function updateTotal(e) {
    updatePrice(e);
    var sum = 0;
    subtotalElements = document.getElementsByClassName("price-subtotal");
    for (var i = 0; i < subtotalElements.length; i++) {
        sum += parseFloat(subtotalElements[i].innerHTML);
    }
    document.getElementById("total-price").innerHTML = sum.toFixed(2)
}

function updatePriceProduct(e) {
    var regexp = /^\d*$/;
    if (!regexp.test(e.value) || e.value == 0) {
        e.value = 1
    }
    document.getElementById("product-price-subtotal").innerHTML = (e.value * parseFloat(document.getElementById("product-price-single").innerHTML.substr(1))).toFixed(2);
}

function updatePrice(e) {
    var regexp = /^\d*$/;
    if (!regexp.test(e.value) || e.value == 0) {
        e.value = 1
    }
    var elementId = e.getAttribute("id");
    var sepId = elementId.split("_");
    var sepIdLength = sepId.length;
    sepId = sepId.slice(0, sepIdLength - 1);
    document.getElementById(sepId.join("_") + "_price-subtotal").innerHTML = (e.value * parseFloat(document.getElementById(sepId.join("_") + "_price-single").innerHTML.substr(1))).toFixed(2);
}

function initProductImage(button_id) {
    var element = document.getElementById(button_id);
    pickColor(element);
}

function updateStock(e, inputType) {
    if (inputType == "color") {
        selectedColor = e.value;
    } else if (inputType == "size") {
        selectedSize = e.value;
    }

    var stock;
    if (typeof inventory_arr[selectedColor][selectedSize] === 'undefined') {
        stock = 0;
    } else {
        stock = inventory_arr[selectedColor][selectedSize];
    }
    var qtyInputElement = document.getElementById("product-quantity");
    if (stock < 1) {
        document.getElementById("option--quantity").style.display = "none";
        document.getElementById("button--addtocart").style.display = "none";
        document.getElementById("button--outofstock").style.display = "inherit";
    } else {
        document.getElementById("option--quantity").style.display = "flex";
        document.getElementById("button--addtocart").style.display = "inherit";
        document.getElementById("button--outofstock").style.display = "none";
        if (qtyInputElement.value > stock) {
            qtyInputElement.value = stock;
            document.getElementById("product-price-subtotal").innerHTML = (stock * parseFloat(document.getElementById("product-price-single").innerHTML.substr(1))).toFixed(2)
        }
        qtyInputElement.setAttribute("max", stock);
    }
}