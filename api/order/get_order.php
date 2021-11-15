<?php

namespace api\order;

session_start();

require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

use Src\Controller\Orders\AOrders;

$order = new AOrders();

$last_order = $order->getLastOrder();

if(empty($_SESSION['user']))
{
        $status = [
                'code' => 401,
                'message' => 'Login Required'
        ];

        echo json_encode($status);

}else
{
        if(!empty($last_order))
        {
                echo json_encode($last_order,JSON_PRETTY_PRINT);
        }
}