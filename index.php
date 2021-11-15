<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="#">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart </title>
    <link rel="stylesheet" href="public/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="app-container">
        <div class="app-bg">
            <div class="left-side"></div>
            <div class="right-side"></div>
        </div>
        <header>
            <nav>
                <ul id="menu">
                    <li class="btn home">
                        <a href="/">
                            <img src="public/icons/home.png" alt=""> Home
                        </a>
                    </li>
                    <li class="btn">
                        <a href="#">
                            <img src="public/icons/filter.png" alt="filter">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            Grocery
                        </a>
                    </li>
                    <li>
                        <span id="balance" class="balance"></span>
                    </li>
                    <li id="llogin">
                        <a onclick="document.getElementById('idlogin').style.display='block'" style="width:auto;">
                            <span id="loginStatus" class="login">LogIn</span>
                        </a>
                    </li>
                    <li>
                        <button id="logout" class="logout"></button>
                    </li>
                </ul>
            </nav>
            <div class="shopping-bag">
                <a href="public/cart.html">
                    <img src="public/icons/bag.png" alt="cart"> Cart
                    <div class="total-items-in-cart">
                        0
                    </div>
                </a>
            </div>
        </header>
        <main>
            <div class="content">
                <div class="products-preview">
                    <div class="products-container">
                        <div class="product">
                            <img src="public/product/images/apple.png" alt="apple">
                        </div>
                        <div class="product">
                            <img src="public/product/images/beer.png" alt="beer">
                        </div>
                        <div class="product">
                            <img src="public/product/images/cheese.png" alt="cheese">
                        </div>
                    </div>
                    <div class="more-details">
                        <div class="see-more-btn">
                            <img src="public/icons/right-arrow.png" alt=""> Details
                        </div>
                        <div class="description">
                            <small>Fresh</small>
                            <h1>Vegetables</h1>
                        </div>
                    </div>
                </div>
                <div class="model">
                    <img class="model-img" src="public/img/model.png" alt="model">
                    <div class="product">
                        <img src="public/product/images/water.png" alt="beer">
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div class="products-list">
        <div class="products">
            <!-- render porducts here -->
        </div>
        <div class="cart">
            <div class="cart-header">
                <div class="column1">Item</div>
                <div class="column2">Unit price</div>
                <div class="column3">Units</div>
            </div>
            <div class="cart-items">
                <!-- render cart items here -->
            </div>
            <div class="cart-footer">
                <label>Shipping UPS
                        <input type="radio" value="ups" name="shipping" id="ups" onclick="noticeShipping();">
                        <span ></span>
                      </label>
                <label>PickUp
                        <input type="radio" value="pickup" name="shipping" id="pickup">
                        <span ></span>
                      </label>
                <div class="subtotal">
                    Subtotal (0 items): $0
                </div>

                <div class="checkout" onclick="checkShipping()">
                    Proceed to checkout
                </div>
            </div>
        </div>
    </div>

    <div id="idlogin" class="modal">
        <form class="modal-content animate" id="login" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('idlogin').style.display='none'" class="close" title="Close Modal">×</span>
                <img src="public/img/logo.png" alt="Logo" class="avatar">
            </div>

            <div class="container">
                <label><b>Username:</b></label>
                <span id="errMessage" class="err" ></span>
                <input id="uemail" type="text" placeholder="Enter email" name="uemail" autocomplete="on" required>

                <label><b>Password:</b></label>
                <input id="upassword" type="password" placeholder="Enter Password" name="upassword" autocomplete="on" required>

                <button type="submit" onclick="JavaScript:login();">LogIn</button>
                <input type=" checkbox " checked="checked "> Remember me
            </div>

            <div class="container " style="background-color:#f1f1f1 ">
                <button type="submit " onclick="document.getElementById( 'idlogin').style.display='none' " class="cancelbtn ">Cancel</button>
                <span class="psw ">Forgot <a href="# ">password?</a></span>
            </div>
        </form>
    </div>

    <script>
        const porductsListEl = document.querySelector(".products-list ");
        const seeMoreBtn = document.querySelector(".see-more-btn ");

        seeMoreBtn.addEventListener('click', () => {
            porductsListEl.scrollIntoView({
                behavior: "smooth"
            })
        })
        const myForm = document.getElementById('idlogin');

        myForm.addEventListener('submit', function(e) {
            e.preventDefault();

            login();

            
        })

        const myLogout = document.querySelector(".logout");
        myLogout.addEventListener('click', function() {
            logout();
        })
    </script>
    <script src="public/app.js "></script>
    <script src="public/products.js "></script>
    <script src="public/login.js "></script>
    <script src="public/balance.js "></script>
</body>

</html>