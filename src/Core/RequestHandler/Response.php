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
        http_response_code(isset($error['code']) ? $error['code'] : $statusCode);
        header('Status: ' . (isset($error['code']) ? $error['code'] : $statusCode));
        $response = self::BODY;
        $response['status'] = isset($error['code']) ? $error['code'] : $statusCode;
        $response['data'] = $obj;
        $response['error'] = (is_null($error['message']) ? sprintf(self::ERROR_MESSAGES[$error['code']], $id) : $error['message']);

        echo json_encode($response);
    }

    const ERROR_MESSAGES = [
        400 => 'BAD REQUEST',
        404 => 'Object with ID %d was not found',
    ];
}
