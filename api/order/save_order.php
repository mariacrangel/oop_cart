<?php

namespace api\order;

session_start();

require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use Src\Controller\Orders\AOrders;

use Src\Controller\Balance\ABalance;
use Src\Model\Balance as ModelBalance;

$order = new AOrders();

$balance = new ABalance();

$data = file_get_contents("php://input");

$arr_data = explode(',',$data);

$params = [
        $arr_data[0],
        (double)$arr_data[1],
        filter_var($arr_data[2], FILTER_VALIDATE_BOOLEAN),
        (double)$arr_data[3],
        date( "Y-m-d H:i:s", strtotime($arr_data[4]))

];

$bl = $balance->getUserBalance();

$prev_balance = (double)$bl[0]['btotal'];

$total = (double)$arr_data[1];

$new_balance = $prev_balance - $total;

if(empty($_SESSION['user']))
{
        $status = [
                'code' => 401,
                'message' => 'Login Required'
        ];

        echo json_encode($status);

}else
{
        $storeOrder = $order->store($params);

        $updateBalance = $balance->updateUserBalance($new_balance);
       
        if($storeOrder)
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


