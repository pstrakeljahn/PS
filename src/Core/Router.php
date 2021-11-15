<?php

namespace PS\Source\Core;

class Router
{
    const CREATE = 'create';
    const READ = 'read';
    const UPDATE = 'update';
    const DELETE = 'delete';

    const CRUD_OPERATIONS_METHOD = [
        self::CREATE => 'POST',
        self::READ => 'GET',
        self::UPDATE => 'PATCH',
        self::DELETE => 'DELETE'
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
        preg_match('/^.*(api\/v1\/)(.*)$/', $this->path, $match);
        $arrUrl = explode('/', $match[count($match) - 1]);
        $className = '\PS\Source\Classes\\' . ucfirst($arrUrl[0]);
        if (!class_exists($className)) {
            echo self::doesNotExist($className, null);
            return;
        } else if (empty($arrUrl[1])) {
            /////////////// @todo success
        };
        if (isset($arrUrl[1]) && is_numeric($arrUrl[1])) {
            $objInstance = new $className();
            $obj = $objInstance->getByPK((int)$arrUrl[1]);
            if (is_null($obj)) {
                echo self::doesNotExist($className, $arrUrl[1]);
                return;
            }
            /////////////// @todo success
        } else if (isset($arrUrl[1]) && !is_numeric($arrUrl[1])) {
            echo 'ID has to be a number!';
            return;
        };
        if (empty($arrUrl[2])) {
            $arrUrl[2] = self::READ;
        }
        if (in_array($arrUrl[2], array_keys(self::CRUD_OPERATIONS_METHOD)) && $this->method === self::CRUD_OPERATIONS_METHOD[$arrUrl[2]]) {
            /////////////// @todo success
        } else if (!in_array($arrUrl[2], array_keys(self::CRUD_OPERATIONS_METHOD))) {
            echo 'Method ' . $arrUrl[2] . ' does not exist!';
            return;
        } else {
            echo 'Method ' . $arrUrl[2] . ' not allowed!';
            return;
        };
    }

    public static function doesNotExist($classname, $id)
    {
        return 'Object' . $classname . ($id ? ' with ID ' . $id . ' ' : ' ') . 'does not exist!';
    }
}
