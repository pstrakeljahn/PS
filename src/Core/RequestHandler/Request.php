<?php

namespace PS\Source\Core\RequestHandler;

use PS\Source\Core\RequestHandler\Response;

class Request extends Response
{
    public function get($obj, $get, $post, $error = null, $id = null)
    {
        $this->generateResponse($obj, $error, $id);
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
