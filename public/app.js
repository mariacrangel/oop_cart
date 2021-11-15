var products = [];
var total = '';
var symbol = '';
const cartItemsEl = document.querySelector(".cart-items");
const subtotalEl = document.querySelector(".subtotal");
const totalItemsInCartEl = document.querySelector(".total-items-in-cart");
const productsEl = document.querySelector(".products");

window.onload = function() {
    if (checkLogIn()) {
        getBalance();
        document.getElementById("loginStatus").style.display = "none";
        document.getElementById("llogin").style.display = "none";
        addLogout();
    }

};
let cart = JSON.parse(localStorage.getItem("BASKET")) || [];

updateCart();

function addToCart(id) {

    if (cart.some((item) => item.pid == id)) {

        changeNumberOfUnits("plus", id);

    } else {
        const item = products.find((product) => product.pid == id);

        cart.push({
            ...item,
            numberOfUnits: 1,
            instock: 200
        });
        updateCart();
    }
}

function search(id, Array) {
    for (var i = 0; i < Array.length; i++) {
        if (Array[i].pid == id) {
            return Array[i];
        }
    }
}

function updateCart() {
    renderCartItems();
    renderSubtotal();

    localStorage.setItem("BASKET", JSON.stringify(cart));
}

// calculate and render subtotal
function renderSubtotal() {
    let totalPrice = 0,
        totalItems = 0;

    cart.forEach((item) => {
        totalPrice += item.psellprice * item.numberOfUnits;
        totalItems += item.numberOfUnits;
    });

    subtotalEl.innerHTML = `Subtotal (${totalItems} items): $${totalPrice.toFixed(2)}`;
    totalItemsInCartEl.innerHTML = totalItems;
}

function renderCartItems() {
    cartItemsEl.innerHTML = ""; // clear cart element
    cart.forEach((item) => {
        cartItemsEl.innerHTML += `
        <div class="cart-item">
            <div class="item-info" onclick="removeItemFromCart(${item.pid})">
                <img src="${item.phslug}" alt="${item.pname}">
                <h4>${item.pname}</h4>
            </div>
            <div class="unit-price">
                <small>$</small>${item.psellprice}
            </div>
            <div class="units">
                <div class="btn minus" onclick="changeNumberOfUnits('minus', ${item.pid})">-</div>
                <div class="number">${item.numberOfUnits}</div>
                <div class="btn plus" onclick="changeNumberOfUnits('plus', ${item.pid})">+</div>           
            </div>
        </div>
      `;
    });
}

function removeItemFromCart(id) {

    cart = cart.filter((item) => item.pid != id);

    updateCart();
}

// change number of units for an item
function changeNumberOfUnits(action, id) {
    cart = cart.map((item) => {

        let numberOfUnits = item.numberOfUnits;

        if (item.pid == id) {
            if (action === "minus" && numberOfUnits > 1) {
                numberOfUnits--;
            } else if (action === "plus" && numberOfUnits < item.instock) {
                numberOfUnits++;
            }
        }

        return {
            ...item,
            numberOfUnits,
        };
    });

    updateCart();
}

function checkShipping() {
    if (!cart.length == 0) {
        if (!document.getElementById('pickup').checked && !document.getElementById('ups').checked) {
            alert("you must to select one of pickup Method before continue");
            return;
        } else {
            if (checkLogIn()) {
                sendOrder();
            }
        }
    } else {
        alert("You don't have any products in your cart");
        return;
    }



}

function checkLogIn() {
    console.log(getCookie('user'));

    if (getCookie('user') == null) {
        alert("Please Login Before make a Buy");
        return;
    } else {
        return true;
    }

}

function getCookie(name) {
    name = name + '=';

    const decodedCookie = decodeURIComponent(document.cookie);

    const cookies = decodedCookie.split(';');

    console.log(cookies);

    for (let i = 0; i < cookies.length; i++) {

        const cookie = cookies[i].trim();

        if (cookie.indexOf(name) == 0) {

            return cookie.substring(name.length, cookie.length);
        }
    }
}

function changeStatus() {
    document.getElementById("loginStatus").style.display = "none";
    document.getElementById("llogin").style.display = "none";
    addLogout();

}

function addLogout() {
    var button = document.getElementById("logout");
    button.appendChild(document.createTextNode("Logout"));
}

function logout() {
    document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.getElementById("logout").style.display = "none";
    window.localStorage.clear();
    location.reload();
}

function noticeShipping() {
    alert("It will charge $5 to you Bill");
}

function sendOrder() {

    let email = getCookie('user');
    let subtotalOrder = 0;
    let totalOrder = 0;
    let delivery = false;
    let shippCost = 5.00;

    cart.forEach((item) => {
        subtotalOrder += item.psellprice * item.numberOfUnits;
    });
    if (whichShipping() == "ups") {
        totalOrder = subtotalOrder + 5.00;
        delivery = true;
        shippCost = 5.00;
    } else {
        totalOrder = subtotalOrder;
        shippCost = 0.00;
    }
    var created = new Date();
    var created_string = created.toISOString();

    const order = email + ',' + totalOrder + ',' + delivery + ',' + shippCost + ',' + created_string;

    fetch('http://104.248.68.28:8082/api/order/save_order.php', {
        method: 'POST',
        body: order,
        headers: {
            'Content-type': 'application/json; charset=UTF-8'
        }
    }).then(function(response) {
        if (response.ok) {
            return response.json();
        }
        return Promise.reject(response);
    }).then(function(data) {
        console.log(data);
        if (data.code == 200) {
            sendItem();
            getBalance();
            window.location.href = 'http://104.248.68.28:8082/detail.php';
        }
    }).catch(function(error) {
        console.warn('Something went wrong.', error);
    });

}

function whichShipping() {
    const shps = document.querySelectorAll('input[name="shipping"]');
    let selectedValue;
    for (const shp of shps) {
        if (shp.checked) {
            selectedValue = shp.value;
            console.log(shp.value);
            break;
        }
    }
    return selectedValue;
}

function sendItem() {
    console.log(cart);
    fetch('http://104.248.68.28:8082/api/order/save_items.php', {
        method: 'PUT',
        body: JSON.stringify(cart),
        headers: {
            'Content-type': 'application/json; charset=UTF-8'
        }
    }).then(function(response) {
        if (response.ok) {
            return response.json();
        }
        return Promise.reject(response);
    }).then(function(data) {
        console.log(data);
    }).catch(function(error) {
        console.warn('Something went wrong.', error);
    });

}