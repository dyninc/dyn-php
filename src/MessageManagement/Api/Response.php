<?php

namespace Dyn\MessageManagement\Api;

class Response
{
    /**
     * Status code returned by the API
     *
     * @var integer
     */
    public $status;

    /**
     * @var string
     */
    public $message;

    /**
     * @var stdClass
     */
    public $data;


    /**
     * Build a response object from JSON
     *
     * @param  stdClass $json [description]
     * @return self
     */
    public static function fromJson($json)
    {
        $response = new static();

        $response->status = $json->response->status;
        $response->message = $json->response->message;
        $response->data = $json->response->data;

        return $response;
    }

    /**
     * Returns true if the API request was valid
     *
     * @return boolean
     */
    public function isOk()
    {
        return $this->status == 200;
    }
}
