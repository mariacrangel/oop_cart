<?php

namespace api\product;

require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");

header("Access-Control-Allow-Methods: GET");

header("Access-Control-Allow-Credentials: true");

header("Access-Control-Allow-Headers: access");


use Src\Controller\Product\AProduct;

$id = isset($_GET['id']) ? $_GET['id']: die;

$product = new AProduct();

$prd = $product->getProductById([$id]);

if(!empty($prd))
{
        echo json_encode($prd);
}else
{
        $status = [
                'code' => 404,
                'message' => 'Not Found'
        ];
        echo json_encode($status);
}

