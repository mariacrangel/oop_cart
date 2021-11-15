<?php

namespace Src\System;

use InvalidArgumentException;
use RuntimeException;

class DotEnv implements IConfig
{
        /** 
         * The path where the .env file has been setled
         *  
         * @var string
        **/
        protected $path;

        public function __construct(string $path)
        {
                if(!file_exists($path))
                {
                        throw new InvalidArgumentException
                        (
                                sprintf('%s the file does not exist', $path)
                        );
                }
                $this->path = $path;
        }

        public function load():void
        {
                if(!is_readable($this->path))
                {
                        throw new RuntimeException
                        (
                                sprintf('%s Cannot open file check permissions', $this->path)
                        );
                }

                $trimmed = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 

                foreach($trimmed as $line)
                {
                        if(strpos(trim($line),'#') === 0)
                        {
                                continue;
                        }
                        
                        list($varname,$value) = explode('=',$line, 2);
                        $varname = trim($varname);
                        $value = trim($value);

                        if(!array_key_exists($varname, $_SERVER) && !array_key_exists($varname,$_ENV))
                        {
                                putenv(sprintf('%s=%s',$varname,$value));
                                $_ENV[$varname] = $value;
                                $_SERVER[$varname] = $value;
                        }

                }

        }


}