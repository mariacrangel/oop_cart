<?php

namespace Src\Controller\User;

use Exception;

use Src\Model\User;

class Auth 
{
        private $user;

        private $email;

        private $password;


        public function __construct($email, $password)
        {
                $this->user = new User();

                $this->email = $email;

                $this->password = $password;

        }

        private function checkEmail()
        {
                $exits = 0;
                
                $arr_email = explode(' ',$this->email);
                
                try
                {
                        $result = $this->user->getById($arr_email);
                        if(!empty($result))
                        {
                                $exits = 1;
                        }
                }catch(Exception $e)
                {
                        echo $e->getMessage();
                }

                return $exits;
        }

        public function login()
        {
                $storePasswd = $this->user->getPasswd([$this->email]);

                if($this->checkEmail())
                {
                        if(password_verify($this->password, $storePasswd->upassword))
                        {
                                session_regenerate_id();
                                $_SESSION['user'] = $this->email;
                                $_SESSION['passwd'] = $storePasswd->upassword;
                                return true;
                        }else
                        {
                                return false;
                        }
                        

                }
        }

        public function isLoggedIn()
        {
                $storePasswd = $this->user->getPasswd([$this->email]);

                if(empty($_SESSION['user']))
                {
                        return false;
                
                }

                if($_SESSION['passwd'] === $storePasswd->upassword)
                {
                        return true;
                }else
                {
                        return false;
                }

        }
}

