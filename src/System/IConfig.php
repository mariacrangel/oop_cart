<?php

namespace Src\System;

interface IConfig
{
        public function __construct(string $path);
        public function load():void;
}