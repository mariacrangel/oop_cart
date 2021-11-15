<?php

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: GET");

header("Access-Control-Allow-Credentials: true");

header("Access-Control-Allow-Headers: access");

namespace Src\Controller\Api\Balance;

use Src\Controller\Api\Balance\ABalance;

$balance = new ABalance();

if(empty($_SESSION['user']))
{
        $status = [
                'code' => 401,
                'message' => 'Login Required'
        ];

        return json_encode($status);

}else
{
        $balance_user = $balance->getUserBalance($_SESSION['user']);

        return json_encode($balance_user);
       
}
                