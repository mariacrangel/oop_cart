<?php

/**
 * The name of the class is Aproduct being a reference that is the controller for
 * APIs related with product.
 */

namespace Src\Controller\Api\Product;

use Exception;
use Src\Model\Product;

class AProduct 
{
        private $product;

        public function __construct()
        {
                $this->product = new Product();
                
        }

        public function getProductList()
        {
                try
                {
                        $list = $this->product->getAll();

                        return $list;

                }catch(Exception $e)
                {
                        echo $e->getMessage();
                }
                
        }

        public function getProductById($id)
        {
                $arr_id = explode(' ', $id);

                try
                {
                        $prd = $this->product->getById($id);

                        return $prd;
                }catch(Exception $e)
                {
                        echo $e->getMessage();
                }

                return false;
                
        }

        public function store(array $data)
        {
                try
                {
                        $status = $this->product->save($data);

                        if($status)
                        {
                                return true;
                        }else
                        {
                                return false;
                        }

                }catch(Exception $e)
                {
                        echo $e->getMessage();
                }
        }

        public function remove($id)
        {
                /** This function would be need it when we have an Inventory, for 
                *   this task is not required because we have not inventory
                **/
        }
}