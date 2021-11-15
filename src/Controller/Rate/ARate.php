<?php

/**
 * The name of the class is ARate being a reference that is the controller for
 * APIs related with product.
 */

namespace Src\Controller\Rate;

use Src\Model\Balance;

use Src\Controller\User\Auth;

use Exception;

use Src\Model\Rate;

class ARate
{
        private $rate;

        public function __construct()
        {
                $this->rate = new Rate();
        }

        public function getProductRate($id)
        {
                        $rate = $this->rate->getById([$id]);

                        echo json_encode($rate);
        }

        public function updateUserBalance($total)
        {
                $data = [
                        $total,
                        $_SESSION['user']
                ];

                
                if(empty($_SESSION['user']))
                {
                        $status = [
                                'code' => 401,
                                'message' => 'Login Required'
                        ];

                        echo json_encode($status);
                }else
                {
                        $balance = $this->balance->updateBalance($data);

                        echo json_encode($balance);
                }

        }
}

