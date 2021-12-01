<?php

namespace PS\Source\Core\RequestHandler;

use PS\Source\Core\RequestHandler\Response;

class Request extends Response
{
    public function get($obj, $get, $post, $input, $error = null, $id = null)
    {
        $this->generateResponse($obj, $error);
    }

    protected function post($obj, $get, $post, $input, $error = null, $id = null)
    {
        $requestData = $post;
        if (!empty($input)) {
            $requestData = json_decode($input, true);
        }
        if (!is_null($obj)) {
            try {
                $obj = RequestHelper::insertDataIntoObject($obj, $requestData, true);
            } catch (\Exception $e) {
                $error = json_decode($e->getMessage(), true);
            }
        }
        $this->generateResponse($obj, $error);
    }

    protected function patch($obj, $get, $post, $input, $error = null, $id = null)
    {
        $requestData = $post;
        if (!empty($input)) {
            $requestData = json_decode($input, true);
        }
        if (!is_null($obj)) {
            try {
                $obj = RequestHelper::insertDataIntoObject($obj, $requestData);
            } catch (\Exception $e) {
                $error = json_decode($e->getMessage(), true);
            }
        }
        $this->generateResponse($obj, $error);
    }

    protected function delete($obj, $get, $post, $input, $error = null, $id = null)
    {
        $obj->delete();
        $this->generateResponse(null, $error);
    }
}
