<?php

require 'vendor/autoload.php';

use Src\System\DotEnv;

use Src\System\DatabaseConnect;

$loader = new DotEnv(__DIR__ . '/.env');

$loader->load();

$dbConn = new DatabaseConnect();
$db = $dbConn->getConnection();

var_dump($db);


