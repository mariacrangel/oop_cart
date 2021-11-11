/*var products = [];
fetch('http://cart.local/api/product/get_all_products.php').then(function(response) {
    // The API call was successful!
    if (response.ok) {
        return response.json();
    } else {
        return Promise.reject(response);
    }
}).then(function(data) {
    // This is the JSON from our response
    for (var i in data) {
        let object = {};
        object = {
            'pid': data[i].pid,
            'pname': data[i].pname,
            'pdescription': data[i].pdescription,
            'punit': data[i].piece,
            'psellprice': data[i].psellprice,
            'created': data[i].created,
            'phid': data[i].phid,
            'phname': data[i].phname,
            'phslug': data[i].phslug,
            'phtype': data[i].phtype
        };
        products[i] = object;
    }
}).catch(function(err) {
    // There was an error
    console.warn('Something went wrong.', err);
});
/*
const products = [{
        "pid": "3",
        "pname": "apple",
        "pdescription": "Premium Apple",
        "punit": "piece",
        "psellprice": "0.35",
        "created": "2021-11-07 20:07:20",
        "phid": "1",
        "phname": "http:\/\/cart.local\/public\/product\/images\/apple.jpg",
        "phslug": "apple1",
        "phtype": "jpg"
    },
    {
        "pid": null,
        "pname": "beer",
        "pdescription": "Premium Beer",
        "punit": "bottle",
        "psellprice": "2.00",
        "created": null,
        "phid": null,
        "phname": null,
        "phslug": null,
        "phtype": null
    },
    {
        "pid": null,
        "pname": "Water",
        "pdescription": "Premium Water",
        "punit": "bottle",
        "psellprice": "1.00",
        "created": null,
        "phid": null,
        "phname": null,
        "phslug": null,
        "phtype": null
    },
    {
        "pid": null,
        "pname": "Cheese",
        "pdescription": "Cheddar Cheese",
        "punit": "Kg",
        "psellprice": "3.74",
        "created": null,
        "phid": null,
        "phname": null,
        "phslug": null,
        "phtype": null
    }
];*/