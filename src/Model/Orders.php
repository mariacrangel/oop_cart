<?php

namespace Src\Model;

use Src\System\DatabaseConnect;

class Orders implements IModel
{
        private $db;

        private $tlb_name;

        public function __construct()
        {
                $this->tlb_name = 'orders';

                $this->db = new DatabaseConnect();

                $this->db->connect();
                
        }

        public function save(array $param)
        {
                try
                {
                        $query = "insert into " . $this->tlb_name . "(
                                oemail,
                                ototal,
                                odelivery,
                                shippingcost,
                                created 
                                )
                                values (
                                ?,
                                ?,
                                ?,
                                ?,
                                ?
                                )";

                        $stat = $this->db->prepare($query);

                        $saved = $stat->execute($param);

                        return $saved;
                        

                }catch(\PDOException $e)
                {
                        echo $e->getMessage();
                }
        }

        public function getAll()
        {
                //
                $query = " select * from " . $this->tlb_name ;

                $stat = $this->db->prepare($query);
                
                $stat->execute();
                
                return $stat->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getById(array $id)
        {
                //
                $query = "select * from " . $this->tlb_name . " where id= ?";
                
                $stat = $this->db->prepare($query);

                $stat->execute($id);

                return $stat->fetchALL(\PDO::FETCH_ASSOC);

        }
        public function getGroupByIndex(array $index)
        {
                /**
                 * query to retrieve data by another filed which is an Index,
                 *  but not is the id.
                 */

                $query = "select * from " . $this->tlb_name . "left join user on
                " . $this->tlb_name. ".oemail = user.uemail left join item on
                " . $this->tlb_name . ".id = item.orderid where " 
                . $this->tlb_name . ".oemail= ? and item.orederid = ? ";
                
                $stat = $this->db->prepare($query);

                $stat->execute($index);

                return $stat->fetchALL(\PDO::FETCH_ASSOC);
                
        }

        public function remove()
        {
        }

        public function getProductsInOrder()
        {

        }

        public function getLastIdInserted()
        {
                $query = " select id from " . $this->tlb_name . " where id = 
                (select MAX(id) from " . $this->tlb_name . ")";
                
                $stat = $this->db->prepare($query);

                $stat->execute();

                $obj = $stat->fetch(\PDO::FETCH_OBJ);

                return $obj->id;
                
        }

}