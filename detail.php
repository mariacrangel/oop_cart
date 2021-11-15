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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<div class="container bootdey">
<div class="row invoice row-printable">
    <div class="col-md-10">

        <div class="panel panel-default plain" id="">

            <div class="panel-body p30">
                <div class="row">

                    <div class="col-lg-6">

                        <div class="invoice-from">
                            <ul class="list-unstyled text-right">
                                <li>SHOPING CART</li>
                                <li>2500 Ridgepoint Dr, Suite 105-C</li>
                                <li>Austin TX 78754</li>
                                <li>VAT Number EU826113958</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-12">

                        <div class="invoice-details mt25">
                            <div class="well" id="well">
                                
                            </div>
                        </div>
                        <div class="invoice-to mt25" id="invoice-to">
                            
                        </div>
                        <div class="invoice-items">
                            <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="per70 text-center">Description</th>
                                            <th class="per5 text-center">Qty</th>
                                            <th class="per25 text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items">
                                        
                                    </tbody>
                                    <tfoot id="total">
                                        
                                        
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-footer mt25">
                        
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
        <form>
        <input type="button" value="  OK  " onclick="back();" style="background-color:royalblue";>
        </form>

</div>
</div>  

<script>
        localStorage.removeItem("BASKET");
        const myOrder = document.getElementById("well");
        const myClient = document.getElementById("invoice-to");
        const myItems = document.getElementById("items");
        const myFooter = document.getElementById("total");
        var shipping = '';
        var cost = 0.0;
        var previousBalance = 0.0;
        var currentBalance = 0.0;
        var total = 0.0;

    fetch('http://104.248.68.28:8082/api/order/get_order.php').then(function(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(response);
        }
    }).then(function(data) {
        var i=0;
        data.forEach((order) => {
                console.log(order);
                if(i==0){
                        if(parseInt(order.odelivery) == 1 ){
                                shipping = 'Delivery UPS';
                                cost = 5.00;
                        }else{
                                shipping = 'Pickup';
                                cost = 0.0;
                        }
                        previousBalance = parseFloat(order.btotal) + parseFloat(order.ototal);

                        currentBalance = parseFloat(order.btotal);

                        total = parseFloat(order.ototal)

                        myOrder.innerHTML = `        
                                <ul class="list-unstyled mb0">
                                    <li><strong>Invoice</strong> #${order.id}</li>
                                    <li><strong>Invoice Date:</strong> ${order.created}</li>
                                    <li><strong>Status:</strong> <span class="label label-danger">PAID</span></li>
                                </ul>
                        `;

                         myClient.innerHTML = `
                            <ul class="list-unstyled">
                                <li><strong>Invoiced To</strong></li>
                                <li>${order.uname} ${order.ulastname}</li>
                            </ul>
                        `;
                        
                }

                myItems.innerHTML += `
                        <tr>
                                <td>${order.pname}</td>
                                <td class="text-center">${order.iquantity}</td>
                                <td class="text-center">$${parseFloat(order.psellprice) * parseFloat(order.iquantity)} USD</td>
                        </tr>
                `;


                i = i+1;
        });
                myItems.innerHTML += `
                        <tr>
                                <td>${shipping}</td>
                                <td class="text-center"> - </td>
                                <td class="text-center">$${ cost } USD</td>
                        </tr>
                `;
                myFooter.innerHTML = `
                                        <tr>
                                            <th colspan="2" class="text-right">Total:</th>
                                            <th class="text-center">$${total} USD</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-right">Previous Balance:</th>
                                            <th class="text-center">$${previousBalance} USD</th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-right">Current Balance:</th>
                                            <th class="text-center">$${currentBalance} USD</th>
                                        </tr>
                `;

    }).catch(function(err) {
        console.warn('Something went wrong.', err);
    });

    function back(){
        window.location.href = 'http://104.248.68.28:8082/';
    }

</script>
</body>
