<?php

namespace Src\Controller\Api\User;

require "../../../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

use Src\Controller\Api\User\Auth;

$data = json_decode(file_get_contents("php://input"));

$authentication = new Auth($data->email, $data->password);

if($authentication->isLoggedIn())
{
        $status = [
                'code' => 200,
                'message' => 'Already Logged'
        ];

        return json_encode($status);
}else
{
        $status = [
                'code' => 401,
                'message' => 'Login Required'
        ];
        return json_encode($status);
}

