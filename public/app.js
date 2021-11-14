var products = [];
var total = '';
var symbol = '';
const productsEl = document.querySelector(".products");
const cartItemsEl = document.querySelector(".cart-items");
const subtotalEl = document.querySelector(".subtotal");
const totalItemsInCartEl = document.querySelector(".total-items-in-cart");

function renderProducts() {
    fetch('http://cart.local/api/product/get_all_products.php').then(function(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(response);
        }
    }).then(function(data) {
        // This is the JSON from our response
        products.push(...data);
        data.forEach((product) => {
            productsEl.innerHTML += `
            <div class="item">
                <div class="item-container">
                    <div class="item-img">
                        <img src="${product.phslug}" alt="${product.pname}">
                    </div>
                    <div class="desc">
                        <h2>${product.pname}</h2>
                        <h2><small>$</small>${product.psellprice}</h2>
                        <p>
                            ${product.pdescription}
                        </p>
                    </div>
                    <div class="add-to-wishlist">
                        <img src="public/icons/heart.png" alt="add to wish list">
                    </div>
                    <div class="add-to-cart" onclick="addToCart(${product.pid})">
                        <img src="public/icons/bag-plus.png" alt="add to cart">
                    </div>
                </div>
            </div>
        `;
        });

        if (checkLogIn()) {
            changeStatus();
        }

    }).catch(function(err) {
        console.warn('Something went wrong.', err);
    });
}

renderProducts();

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
                changeStatus();
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

function login() {
    let strJson = document.getElementById("uemail").value + ',' + document.getElementById("upassword").value;
    console.log(strJson);
    fetch('http://cart.local/api/user/login.php', {
        method: 'POST',
        body: strJson,
        headers: {
            'Content-type': 'application/json; charset=UTF-8'
        }
    }).then(function(response) {
        if (response.ok) {
            return response.json();
        }
        return Promise.reject(response);
    }).then(function(data) {
        if (data.code == 200) {
            document.cookie = 'user=' + document.getElementById("uemail").value;
            closeModal();
            changeStatus();
            getBalance();
        } else {
            let err = document.getElementById('errMessage');
            err.textContent = data.message;
            return;

        }

    }).catch(function(error) {
        console.warn('Something went wrong.', error);
    });

}

function closeModal() {
    document.querySelector(".modal").style.display = "none";
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

function getBalance() {
    fetch('http://cart.local/api/balance/get_balance.php').then(function(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(response);
        }
    }).then(function(data) {
        // This is the JSON from our response
        data.forEach((balance) => {
            total = balance.btotal;
            symbol = balance.symbol;
        });

        document.getElementById('balance').textContent = "Balance:  " + symbol + total;

    }).catch(function(error) {
        console.warn('Something went wrong.', error);
    });;
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

    fetch('http://cart.local/api/order/save_order.php', {
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
        sendItem();
        getBalance();
        window.localStorage.clear();

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
            break;
        }
    }
    return selectedValue;
}

function sendItem() {
    console.log(cart);
    fetch('http://cart.local/api/order/save_items.php', {
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