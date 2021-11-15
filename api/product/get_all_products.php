<?php

namespace api\product;

require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset:UTF-8");


use Src\Controller\Product\AProduct;

$products = new AProduct();

$product_list = $products->getProductList();

if(!empty($product_list))
{
        echo json_encode($product_list,JSON_PRETTY_PRINT);
}else
{
        $status = [
                'code' => 404,
                'message' => 'Not Found'
        ];
        echo json_encode($status);
}

