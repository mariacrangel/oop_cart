<?php

class Gateway
{
        private $route;

        public function __construct($route)
        {
                $this->route = $route;
        }

        private function checkUrl()
        {
                if($this->route !== strtolower($this->route))
                {
                        http_response_code(301);

                        header('location: ' . strtolower($this->route));
                }
        }




}