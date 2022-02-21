<?php

use PS\Source\Core\RequestHandler\Response;
use PS\Source\Core\RequestHandler\Router;
use PS\Source\Core\Session\SessionHandler;

require_once __DIR__ . '/autoload.php';

preg_match('/^.*(api\/v1\/obj\/)(.*)$/', $_SERVER['REQUEST_URI'], $match);
preg_match('/.*(build.php)/', $_SERVER['REQUEST_URI'], $build);
preg_match('/.*(cronjob.php)/', $_SERVER['REQUEST_URI'], $cronjob);
preg_match('/^.*(api\/v1\/login)(.*)$/', $_SERVER['REQUEST_URI'], $login);

if(count($login)) {
    $router = new Router();
    $router->login();
    return;
}
if (count($match)) {
    if(SessionHandler::loggedIn()) {
        $router = new Router();
        $router->run($match);
    } else {
        Response::generateResponse(array(), ['code' => Response::STATUS_CODE_FORBIDDEN, 'message' => 'Please lock in!']);
    }
} elseif (count($cronjob)) {
    return include('./cronjob.php');
} elseif (count($build)) {
    return include('./build.php');
} else {
    return include('./page/index.php');
}
