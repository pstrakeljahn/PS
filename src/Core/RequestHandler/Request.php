<?php

namespace PS\Source\Core\RequestHandler;

use PS\Source\Core\RequestHandler\Response;

class Request extends Response
{
    public function get($obj, $get, $post, $error = null, $id = null)
    {
        if ($error === Response::STATUS_CODE_NOTFOUND) {
            $this->generateResponse($obj, Response::STATUS_CODE_NOTFOUND, $error, $id);
            return;
        }
        $this->generateResponse($obj, Response::STATUS_CODE_OK, $error);
    }

    protected function post($obj, $get, $post, $error = null, $id = null)
    {
    }

    protected function patch($obj, $get, $post, $error = null, $id = null)
    {
    }

    protected function delete($obj, $get, $post, $error = null, $id = null)
    {
    }
}
