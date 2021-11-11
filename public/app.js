var products = [];
const productsEl = document.querySelector(".products");
const cartItemsEl = document.querySelector(".cart-items");
const subtotalEl = document.querySelector(".subtotal");
const totalItemsInCartEl = document.querySelector(".total-items-in-cart");

function renderProducts() {
    fetch('http://cart.local/api/product/get_all_products.php').then(function(response) {
        // The API call was successful!
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

    }).catch(function(err) {
        // There was an error
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

// render cart items
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

// remove item from cart
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