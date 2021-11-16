<?php

use PS\Source\Core\RequestHandler\Router;

require_once __DIR__ . '/autoload.php';

$router = new Router();
$router->run();
