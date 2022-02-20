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

    public function run($match)
    {
        // check obj endpoint
        $arrUrl = explode('/', $match[count($match) - 1]);
        $className = '\PS\Source\Classes\\' . ucfirst($arrUrl[0]);
        $error = ['code' => null, 'message' => null];
        $input = file_get_contents('php://input');
        if (!class_exists($className)) {
            $error = ['code' => Response::STATUS_CODE_NOTFOUND, 'message' => 'Object' . $className . ' does not exist!'];
            call_user_func_array([$this, $this->method], [[], $_GET, $_POST, $input, $error]);
            return;
        } else if (empty($arrUrl[1]) && $this->method === 'GET') {
            // GET all without ID
            $instance = new $className();
            $res = $instance->go();
            call_user_func_array([$this, $this->method], [$res, $_GET, $_POST, $input, $error]);
            return;
        } else if (empty($arrUrl[1]) && $this->method === 'POST') {
            if (!count($_POST) && empty($input)) {
                $error = ['code' => Response::STATUS_CODE_BAD_REQUEST, 'message' => 'Request body is empty'];
                $this->generateResponse(null, $error);
                return;
            }
            call_user_func_array([$this, $this->method], [new $className(), $_GET, $_POST, $input, $error]);
            return;
        };
        if (isset($arrUrl[1]) && is_numeric($arrUrl[1]) && in_array($this->method, ['GET', 'PATCH', 'DELETE'])) {
            $objInstance = new $className();
            $obj = $objInstance->getByPK((int)$arrUrl[1]);
            if (is_null($obj)) {
                $error = ['code' => Response::STATUS_CODE_NOTFOUND, 'message' => 'Object with ID ' . (int)$arrUrl[1] . ' was not found'];
            }
            // single object selected
            call_user_func_array([$this, $this->method], [$obj, $_GET, $_POST, $input, $error, (int)$arrUrl[1]]);
            return;
        } else if (isset($arrUrl[1]) && !is_numeric($arrUrl[1]) && in_array($this->method, self::CRUD_OPERATIONS_METHOD)) {
            if ($arrUrl[1] !== "") {
                $error = ['code' => Response::STATUS_CODE_BAD_REQUEST, 'message' => 'ID has to be an int!'];
            } else {
                $error = ['code' => Response::STATUS_CODE_BAD_REQUEST, 'message' => 'Wrong usage'];
            }
            call_user_func_array([$this, $this->method], [null, $_GET, $_POST, $input, $error, (int)$arrUrl[1]]);
            return;
        } else {
            $error = ['code' => Response::STATUS_CODE_BAD_REQUEST, 'message' => 'Wrong usage'];
            call_user_func_array([$this, $this->method], [null, $_GET, $_POST, $input, $error]);
            return;
        };
    }
}
