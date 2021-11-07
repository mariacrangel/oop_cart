<?php
namespace Src\Model;

use Src\System\DatabaseConnect;

class Balance implements IModel
{
        private $db;

        private $tlb_name;

        public function __construct()
        {
                $this->tlb_name = 'balance';

                $this->db = new DatabaseConnect();
                
                $this->db->connect();
        }

        public function save(array $param)
        {
                try
                {
                        $query = "insert into " . $this->tlb_name . " 
                        ( 
                                bcurrencycode,
                                bemail, 
                                btotal, 
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
                $query ="select * from " . $this->tlb_name;
                
                $stat = $this->db->prepare($query);
                
                $stat->execute();
                
                return $stat->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getById(array $id)
        {                
                $query = "select * from " . $this->tlb_name . " where bemail= ?";
                
                $stat = $this->db->prepare($query);

                $stat->execute($id);

                return $stat->fetchALL(\PDO::FETCH_ASSOC);
        }

        public function remove()
        {
           //     
        }
}