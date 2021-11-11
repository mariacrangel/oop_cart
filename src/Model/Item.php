<?php

namespace Src\Model;

use Src\System\DatabaseConnect;

class Item implements IModel
{
        private $db;

        private $tlb_name;

        public function __construct()
        {
                $this->tlb_name = 'item';

                $this->db = new DatabaseConnect();

                $this->db->connect();
                
        }

        public function save(array $param)
        {
                //
                
                try
                {
                        $query = "insert into " . $this->tlb_name . "(
                                orderid,
                                pid,
                                iquantity,
                                created 
                                )
                                values (
                                ?,
                                ?,
                                ?,
                                ?
                                )";

                        $stat = $this->db->prepare($query);

                        $stat->execute($param);

                }catch(\PDOException $e)
                {
                        echo $e->getMessage();
                }
        }

        public function getAll()
        {
                //
                $query = " select * from " . $this->tlb_name . " left join product 
                on " . $this->tlb_name . ".pid = product.pid" ;

                $stat = $this->db->prepare($query);
                
                $stat->execute();
                
                return $stat->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getById(array $id)
        {
                //
                $query = " select * from " . $this->tlb_name . " left join product 
                on " . $this->tlb_name . ".pid = product.pid where orderid = ?";
                
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
                
        }

        public function remove()
        {
                //
        }

        public function getLastIdInserted()
        {
                
        }
}