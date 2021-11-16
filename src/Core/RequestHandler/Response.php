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
        400 => 'BAD REQUEST',
        404 => 'NOT FOUND',
    ];

    const STATUS_CODE_OK = 200;
    const STATUS_CODE_NOTFOUND = 404;

    protected static function generateResponse($obj, $error, $id = null)
    {
        header_remove();
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');
        http_response_code(isset($error['code']) ? $error['code'] : self::STATUS_CODE_OK);
        header('Status: ' . (isset($error['code']) ? $error['code'] : self::STATUS_CODE_OK));
        $response = self::BODY;
        $response['status'] = isset($error['code']) ? $error['code'] : self::STATUS_CODE_OK;
        $response['data'] = $obj;
        $response['error'] = !is_null($error['code']) ?
            (is_null($error['message']) ? self::FALLBACK_ERROR_MESSAGES[$error['code']] : $error['message'])
            : null;

        echo json_encode($response);
    }
}
