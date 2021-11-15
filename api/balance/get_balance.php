<?php

namespace api\balance;

session_start();

require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: GET");

header("Access-Control-Allow-Credentials: true");

header("Access-Control-Allow-Headers: access");

use Src\Controller\Balance\ABalance;

$balance = new ABalance();

if(empty($_SESSION['user']))
{
        $status = [
                'code' => 401,
                'message' => 'Login Required'
        ];

        echo json_encode($status);

}else
{
        $balance_user = $balance->getUserBalance([$_SESSION['user']]);

        echo json_encode($balance_user);
       
}
                