<?php

namespace api\user;

require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: POST");

header("Access-Control-Max-Age: 3600");

header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$data = json_decode(file_get_contents("php://input"));

if($data->action === 'logout')
{
        if(session_destroy())
        {
                $status = [
                        'code' => 200,
                        'message' => 'Session Finished'
                ];
        
                echo json_encode($status);
        }
}