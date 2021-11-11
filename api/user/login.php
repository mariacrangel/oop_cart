<?php

namespace Src\Controller\Api\User;

require "../../bootstrap.php";

use Src\Controller\Api\User\Auth;

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

$authentication = new Auth($data->email, $data->password);

if($authentication->login())
{
        $status = [
                'code' => 200,
                'message' => 'Login Successfuly'
        ];
        
        return json_encode($status);
}else
{
        $status = [
                "code" => 401,
                'message' => 'Wrong Email or password, please try Again'
        ];
        return json_encode($status);
}

