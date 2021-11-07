<?php

namespace Src\System;

use \PDO;
use \PDOException;

class DatabaseConnect implements IConnection
{
        
        /**
         * Database  connection
         * @var string 
        **/
        
        private $dbconn = null;

        public function __construct()
        {
                $hostname = getenv('HOSTNAME');
                
                $dbname = getenv('DBNAME');

                $dbport = getenv('DBPORT');
                
                $dbuser = getenv('DBUSER');
                
                $dbpass = getenv('DBPASS');
                try
                {
                        $this->dbconn = new PDO( "mysql:host=$hostname;port=$dbport;charset=utf8mb4;dbname=$dbname", $dbuser, $dbpass );
                        
                        $this->dbconn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                }catch (PDOException $e) 
                {
                        echo $e->getMessage();
                }

        }

        public function getConnection()
        {
                return $this->dbconn;
        }
}