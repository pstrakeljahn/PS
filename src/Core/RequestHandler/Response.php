<?php

namespace PS\Source\Core\RequestHandler;

class Response
{
    const BODY = [
        'status' => null,
        'data' => null,
        'error' => null
    ];

    const STATUS_CODE_OK = 200;
    const STATUS_CODE_NOTFOUND = 404;

    public function __construct()
    {
    }

    protected static function generateResponse($obj, $statusCode, $error, $id = null)
    {
        header_remove();
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');
        http_response_code($error ?? $statusCode);
        header('Status: ' . $error ?? $statusCode);
        $response = self::BODY;
        $response['status'] = $error ?? $statusCode;
        $response['data'] = $obj;
        $response['error'] = !is_null($error) ? sprintf(self::ERROR_MESSAGES[$error], $id) : null;

        echo json_encode($response);
    }

    const ERROR_MESSAGES = [
        400 => 'BAD REQUEST',
        404 => 'Object with ID %d was not found',
    ];
}
