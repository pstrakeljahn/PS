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
        $missingParams = array_diff($obj::REQUIRED_VALUES, array_keys($requestData));
        if (count($missingParams)) {
            $obj = null;
            $error = ['code' => 400, 'message' => 'Missing parameters: ' . implode($missingParams)];
        } else {
            foreach ($requestData as $key => $data) {
                if ($key === 'ID') {
                    continue;
                }
                if (method_exists($obj, 'set' . ucfirst($key))) {
                    $obj = call_user_func_array([$obj, 'set' . ucfirst($key)], [$data]);
                }
            }
            $obj->save();
            $obj = $obj->getByPk($obj->getID());
            $this->generateResponse($obj, $error, 201);
            return;
        }
        $this->generateResponse($obj, $error);
    }

    protected function patch($obj, $get, $post, $input, $error = null, $id = null)
    {
    }

    protected function delete($obj, $get, $post, $input, $error = null, $id = null)
    {
    }
}
