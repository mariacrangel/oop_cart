<?php

namespace api\balance;

require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use Exception;

use Src\Controller\Balance\ABalance;

$data = json_decode(file_get_contents("php://input"));

$total = $data->total;

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
        try
        {
                if($balance->updateUserBalance($total))
                {
                        $status = [
                                'code' => 200,
                                'message' => 'Balance Updated'
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
        }catch(Exception $e)
        {
                echo $e->getMessage();
        }
}