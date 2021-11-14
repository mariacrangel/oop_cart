<?php

namespace Src\Controller\Orders;

use Exception;

use Src\Model\Orders;

use Src\Model\Item;

class AOrders
{
        private $order;

        private $item;

        public function __construct()
        {
                $this->order = new Orders();

                $this->item = new Item();
                
        }

        public function getOrderById($id)
        {
                $arr_id = explode(' ', $id);

                try
                {
                        $order = $this->order->getById($id);

                        return $order;

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
                        $status = $this->order->save($data);
                        //var_dump($status);

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

        public function getLastId()
        {

                $max_id = $this->order->getLastIdInserted();

                return $max_id;

        }

        public function storeItem(array $parameters)
        {
                $status = $this->item->save($parameters);

                return $status;

        }

        public function getLastOrder()
        {
                $order_id = $this->getLastId();

                $email = $_SESSION['user'];

                $lastOrder = $this->order->getGroupByIndex([$email, $order_id]);

                return $lastOrder;
        }

}