function getBalance() {
    fetch('http://104.248.68.28:8082/api/balance/get_balance.php').then(function(response) {
        if (response.ok) {
            return response.json();
        } else {
            return Promise.reject(response);
        }
    }).then(function(data) {
        data.forEach((balance) => {
            total = balance.btotal;
            symbol = balance.symbol;
        });

        document.getElementById('balance').textContent = "Balance:  " + symbol + total;

    }).catch(function(error) {
        console.warn('Something went wrong.', error);
    });;
}