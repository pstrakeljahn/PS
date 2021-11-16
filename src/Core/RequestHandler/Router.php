<?php

namespace PS\Source\Core\RequestHandler;

use  PS\Source\Core\RequestHandler\Request;

class Router extends Request
{
    const CREATE = 'create';
    const READ = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';

    const CRUD_OPERATIONS_METHOD = [
        'POST',
        'GET',
        'PATCH',
        'DELETE'
    ];

    public function __construct()
    {
        $this->path = $_SERVER['REDIRECT_URL'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        if (substr($this->path, -1) !== "/") {
            $this->path = $this->path . '/';
        }
    }

    public function run()
    {
        // check obj endpoint
        preg_match('/^.*(api\/v1\/obj\/)(.*)$/', $this->path, $match);
        $arrUrl = explode('/', $match[count($match) - 1]);
        $className = '\PS\Source\Classes\\' . ucfirst($arrUrl[0]);
        if (!class_exists($className)) {
            echo 'Object' . $className . 'does not exist!';
            return;
        } else if (empty($arrUrl[1]) && $this->method = 'GET') {
            $instance = new $className();
            $res = $instance->go();
            call_user_func_array([$this, $this->method], [$res, $_GET, $_POST]);
            return;
        };
        if (isset($arrUrl[1]) && is_numeric($arrUrl[1]) && in_array($this->method, self::CRUD_OPERATIONS_METHOD)) {
            $objInstance = new $className();
            $obj = $objInstance->getByPK((int)$arrUrl[1]);
            $error = null;
            if (is_null($obj)) {
                $error = 404;
            }
            // single object selected
            call_user_func_array([$this, $this->method], [[$obj], $_GET, $_POST, $error, (int)$arrUrl[1]]);
            return;
        } else if (isset($arrUrl[1]) && !is_numeric($arrUrl[1])) {
            echo 'ID has to be a number!';
            return;
        };
    }
}
