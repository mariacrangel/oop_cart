function renderProducts() {
    fetch('http://104.248.68.28:8082/api/product/get_all_products.php').then(function(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(response);
        }
    }).then(function(data) {
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
                        <div class="add-rating">
                            <img src="public/icons/star2.png" alt="Rate this product" onclick="addRating(${product.pid})">
                        </div>
                        <div class="add-to-cart" onclick="addToCart(${product.pid})">
                            <img src="public/icons/bag-plus.png" alt="add to cart">
                        </div>
                    </div>
                </div>
            `;
        });

    }).catch(function(err) {
        console.warn('Something went wrong.', err);
    });
}

renderProducts();