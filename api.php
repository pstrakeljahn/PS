<?php

use PS\Source\Core\RequestHandler\Router;

require_once __DIR__ . '/autoload.php';

preg_match('/^.*(api\/v1\/obj\/)(.*)$/', $_SERVER['REDIRECT_URL'], $match);
preg_match('/.*(cronjob.php)/', $_SERVER['REQUEST_URI'], $cronjob);
if (count($match)) {
    $router = new Router();
    $router->run();
} elseif (count($cronjob)) {
    return include('./cronjob.php');
} else {
    return include('./page/index.php');
}
