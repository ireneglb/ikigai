<?php

declare(strict_types=1);

require 'autoload.php';

session_start();

new Services\Database;

$router = new Services\Routing;  
$router->routing(); 
