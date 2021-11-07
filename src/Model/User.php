<?php

namespace Src\Model;

use Src\System\DatabaseConnect;

class User implements IModel
{
        private $db;

        private $tlb_name;

        public function __construct()
        {
                $this->tlb_name = 'user';

                $this->db = new DatabaseConnect();
                
                $this->db->connect();
        }

        public function save(array $param)
        {
                try
                {
                        $query = "insert into " . $this->tlb_name . " 
                        ( 
                                uemail,
                                uname, 
                                ulastname, 
                                upassword, 
                                uisactive, 
                                created 
                                )
                                values ( 
                                ?, 
                                ?, 
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
                $query = "select * from " . $this->tlb_name . " where uemail= ?";
                
                $stat = $this->db->prepare($query);

                $stat->execute($id);

                return $stat->fetchALL(\PDO::FETCH_ASSOC);
        }

        public function remove()
        {
           //     
        }
}