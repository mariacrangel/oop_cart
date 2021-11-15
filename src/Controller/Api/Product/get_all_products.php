<?php

namespace Src\Controller\Api\Product;

require "../../../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");


use Src\Controller\Api\Product\AProduct;

$products = new AProduct();

$product_list = $products->getProductList();

if(!empty($product_list))
{
        echo json_encode($product_list);
}else
{
        $status = [
                'code' => 404,
                'message' => 'Not Found'
        ];
        return json_encode($status);
}

