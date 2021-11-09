<?php

require 'vendor/autoload.php';

use Src\System\DotEnv;

use Src\Model\User;

use Src\Model\Product;

use Src\Model\Currency;

use Src\Model\Shipping;
use Src\Model\Balance;
use Src\Model\Photo;
use Src\Model\Rate;
use Src\Model\Orders;
use Src\Model\Item;

$loader = new DotEnv(__DIR__ . '/.env');

$loader->load();

$user = new User();

$parameters = [
        filter_var('vjurbina@gmail.com', FILTER_VALIDATE_EMAIL), 
        'Vic', 
        'Urb', 
        password_hash('mypass', PASSWORD_DEFAULT), 
        true, 
        date('Y-m-d H:i:s')
        ];
//$user->save($parameters);
//var_dump($user->getAll());
//var_dump($user->getById(['vjurbina@gmail.com']));

$product = new Product();

/*an apple is 0.3$, a beer is 2$, water is 1$ each bottle and cheese is 3.74$ each kg

        pid int(11) NOT NULL AUTO_INCREMENT,
        pname varchar(250) NOT NULL,
        pdescription text NOT NULL,
        punit varchar(30) NOT NULL,
        psellprice decimal(10,2) NOT NULL,
        created datetime NOT NULL DEFAULT current_timestamp(),
*/

$prparameters = [
        'Cheese',
        'Cheddar Cheese',
        'Kg',
         3.74,
        date('Y-m-d H:i:s')
];

//$product->save($prparameters); 

//var_dump($product->getAll());
//var_dump($product->getById([3]));

$currency = new Currency();

$cparameters = [
        'usd',
        'Dollar USA',
        '$',
        date('Y-m-d H:i:s')
];

//$currency->save($cparameters);

//var_dump($currency->getAll());

//var_dump($currency->getById(['usd']));

$shipping = new Shipping();

$shparameters = [
        filter_var('vjurbina@gmail.com', FILTER_VALIDATE_EMAIL),
        'My house',
        'UPS',
        date('Y-m-d H:i:s')
];

//$shipping->save($shparameters);

//var_dump($shipping->getAll());

$bl = new Balance();

$bparameters = [
        'usd',
        filter_var('vjurbina@gmail.com', FILTER_VALIDATE_EMAIL),
        100.00,
        date('Y-m-d H:i:s')
];

$bupdateparam = [
        100.00,
        filter_var('vjurbina@gmail.com', FILTER_VALIDATE_EMAIL)
];

//$bl->save($bparameters);

//var_dump($bl->updateBalance($bupdateparam));
//var_dump($bl->getAll());

//var_dump($bl->getById(['vjurbina@gmail.com']));

$ph = new Photo();

$phparameters = [
        3,
        'http://cart.local/public/product/images/apple.jpg',
        'apple1',
        'jpg',
        date('Y-m-d H:i:s')
];

//$ph->save($phparameters);
//var_dump($ph->getAll());
//var_dump($ph->getById([3]));

$rating = new Rate();

$rparameters = [
        13,
        5,
        'Excellent beer',
        date('Y-m-d H:i:s')
];

//$rating->save($rparameters);

//var_dump($rating->getAll());

//var_dump($rating->getById([3]));


$order =  new Orders();

$oparameters = [
        filter_var('vjurbina@gmail.com', FILTER_VALIDATE_EMAIL),
        12.00,
        true,
        5.00,
        date('Y-m-d H:i:s')
];

//$order->save($oparameters);
//var_dump($order->getAll());
//var_dump($order->getById([1]));
//var_dump($order->getGroupByIndex(['vjurbina@gmail.com']));

$item = new Item();

$iparameters = [
        1,
        3,
        10,
        date('Y-m-d H:i:s')
];

//$item->save($iparameters);
//var_dump($item->getAll());
//var_dump($item->getById([1]));


