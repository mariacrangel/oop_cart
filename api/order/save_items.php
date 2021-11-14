<?php

namespace api\order;

session_start();

require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: PUT");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use Src\Controller\Orders\AOrders;

$order = new AOrders();

$data = json_decode(file_get_contents("php://input"));

if(empty($_SESSION['user']))
{
        $status = [
                'code' => 401,
                'message' => 'Login Required'
        ];

        echo json_encode($status);

}else
{
        $orderid = $order->getLastId();

        foreach($data as $item)
        {
                $saved = $order->storeItem([
                        (int)$orderid, 
                        (int)$item->pid, 
                        (int)$item->numberOfUnits, 
                        date( "Y-m-d H:i:s", strtotime($item->created))
                ]);
        }
        if($saved)
        {
                $status = [
                        'code' => 200,
                        'message' => 'order Saved Susccesfuly'
                        ];
                        
                echo json_encode($status);

        }else
        {
                $status = [
                        'code' => 400,
                        'message' => 'Bad Request'
                        ];
                        
                echo json_encode($status);
        }
        

       
}
