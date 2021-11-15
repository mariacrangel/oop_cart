<?php

namespace Src\Controller\Api\Product;

require "../../../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: GET");

header("Access-Control-Allow-Credentials: true");

header("Access-Control-Allow-Headers: access");


use Src\Controller\Api\Product\AProduct;

$id = isset($_GET['id']) ? $_GET['id']: die;

$product = new AProduct();

$prd = $product->getProductById([$id]);

if(!empty($prd))
{
        return json_encode($prd);
}else
{
        $status = [
                'code' => 404,
                'message' => 'Not Found'
        ];
        return json_encode($status);
}

