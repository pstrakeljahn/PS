<?php

use PS\Source\Core\RequestHandler\Response;
use PS\Source\Core\RequestHandler\Router;
use PS\Source\Core\Session\SessionHandler;

require_once __DIR__ . '/autoload.php';

$uri = $_SERVER['REQUEST_URI'];

preg_match('/^.*(api\/v1\/obj\/)(.*)$/', $uri, $match);
preg_match('/.*(build.php)/', $uri, $build);
preg_match('/.*(cronjob.php)/', $uri, $cronjob);
preg_match('/^.*(api\/v1\/login)(.*)$/', $uri, $login);

if (count($login)) {
    $router = new Router();
    $router->login();
    return;
}
if (count($match)) {
    if (SessionHandler::loggedIn()) {
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
    $arrFullUri = explode("/", $uri);
    $arrUri = array_splice($arrFullUri, 2);
    $requestedRoute = implode("/", $arrUri);

    $arrAvailabeRoutes = $entity = include('./page/routes/routes.php');
    if (isset($arrAvailabeRoutes[$requestedRoute])) {
        return include($arrAvailabeRoutes[$requestedRoute]);
    } else {
        return include('./page/index.php');
    }
}
