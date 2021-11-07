<?php

namespace Src\System;

use \PDO;
use \PDOException;

class DatabaseConnect extends PDO implements IConnection
{
        
        /**
         * Database  connection
         * @var string 
        **/
        
        private $dbconn = null;

        /**
         * Database server connection
         * @var string 
        **/

        private $hostname;

        /**
         * Database name 
         * @var string 
        **/

        private $dbname;

        /**
         * Database port connection
         * @var string 
        **/

        private $dbport;

        /**
         * Database user connection
         * @var string 
        **/

        private $dbuser;

        /**
         * Database password connection
         * @var string 
        **/

        private $dbpass;

        public function __construct()
        {
                $this->hostname = getenv('HOSTNAME');
                
                $this->dbname = getenv('DBNAME');

                $this->dbport = getenv('DBPORT');
                
                $this->dbuser = getenv('DBUSER');
                
                $this->dbpass = getenv('DBPASS');
                
                parent::__construct('mysql' . ':host=' . $this->hostname . ';dbname=' . $this->dbname, $this->dbuser, $this->dbpass);
                
               /* try
                {
                        $this->dbconn = new PDO( "mysql:host=$this->hostname;port=$this->dbport;charset=utf8mb4;dbname=$this->dbname", $this->dbuser, $this->dbpass );
                        
                        $this->dbconn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

                }catch (PDOException $e) 
                {
                        echo $e->getMessage();
                }*/
        }

        public function connect()
        {
                try
                {
                        $this->dbconn = new PDO( "mysql:host=$this->hostname;port=$this->dbport;charset=utf8mb4;dbname=$this->dbname", $this->dbuser, $this->dbpass );
                        
                        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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