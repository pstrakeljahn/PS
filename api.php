<?php

use PS\Source\Core\RequestHandler\Router;

require_once __DIR__ . '/autoload.php';

preg_match('/^.*(api\/v1\/obj\/)(.*)$/', $_SERVER['REDIRECT_URL'], $match);
if (count($match)) {
    $router = new Router();
    $router->run();
} else {
    return include('./page/index.php');
}
