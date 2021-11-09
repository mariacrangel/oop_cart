<?php

namespace Src\Model;

interface IModel 
{
        public function save(array $parameters);
        public function getAll();
        public function getById(array $id);
        public function getGroupByIndex(array $index);
        public function remove();
}
