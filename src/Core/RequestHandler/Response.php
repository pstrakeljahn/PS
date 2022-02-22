<?php

namespace PS\Source\Core\RequestHandler;

class Response
{
    const BODY = [
        'status' => null,
        'data' => null,
        'error' => null
    ];

    const FALLBACK_ERROR_MESSAGES = [
        304 => 'NOT MODIFIED',
        400 => 'BAD REQUEST',
        403 => 'FORBIDDEN',
        404 => 'NOT FOUND'
    ];

    const STATUS_CODE_OK = 200;
    const STATUS_CODE_NOT_MODIFIED = 304;
    const STATUS_CODE_BAD_REQUEST = 400;
    const STATUS_CODE_FORBIDDEN = 403;
    const STATUS_CODE_NOTFOUND = 404;

    public static function generateResponse($obj, $error, $statusCode = null)
    {
        $obj = self::checkApiReadable($obj);
        header_remove();
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');
        http_response_code($statusCode ?? (isset($error['code']) ? $error['code'] : self::STATUS_CODE_OK));
        header('Status: ' . ($statusCode ?? (isset($error['code']) ? $error['code'] : self::STATUS_CODE_OK)));
        $response = self::BODY;
        $response['status'] = $statusCode ?? (isset($error['code']) ? $error['code'] : self::STATUS_CODE_OK);
        $response['data'] = $obj;
        $response['error'] = !is_null($error['code']) ?
            (is_null($error['message']) ? self::FALLBACK_ERROR_MESSAGES[$error['code']] : $error['message'])
            : null;

        echo json_encode($response);
    }

    public static function checkApiReadable($obj)
    {
        $arrPath = explode("\\", get_class($obj));
        $entityPath = __DIR__.'/../../../entities/' . $arrPath[count($arrPath) - 1] . '.php';
        $entity = include($entityPath);
        foreach ($entity as $column) {
            if(isset($column['apiReadable']) && !$column['apiReadable']) {
                unset($obj->{$column['name']});
            }
        }
        return $obj;
    }
}
