<?php

/**
 * The name of the class is ABalance being a reference that is the controller for
 * APIs related with product.
 */

namespace Src\Controller\Balance;

use Src\Model\Balance;

use Src\Controller\User\Auth;

use Exception;

class ABalance 
{
        private $balance;

        public function __construct()
        {
                $this->balance = new Balance();
        }

        public function getUserBalance()
        {
                if(!empty($_SESSION['user']))
                {
                        $balance = $this->balance->getById([$_SESSION['user']]);

                        return $balance;
                }
        }

        public function updateUserBalance($total)
        {
                $data = [
                        $total,
                        $_SESSION['user']
                ];

                
                if(!empty($_SESSION['user']))
                {
                        $balance = $this->balance->updateBalance($data);


                        return $balance;
                }

        }
}

