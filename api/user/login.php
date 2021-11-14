<?php

namespace api\user;

require "../../bootstrap.php";

use Src\Controller\User\Auth;

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$creden = file_get_contents("php://input");

$data = explode(',',$creden);

$authentication = new Auth($data[0], $data[1]);

if($authentication->login())
{
        session_start();

        $_SESSION['user'] = $data[0];

        setcookie("user", $data[0]);

        $status = [
                'code' => 200,
                'message' => 'Login Successfuly'
        ];
        
        echo json_encode($status);
}else
{
        $status = [
                "code" => 401,
                'message' => 'Wrong Email or password, please try Again'
        ];
        echo json_encode($status);
}

