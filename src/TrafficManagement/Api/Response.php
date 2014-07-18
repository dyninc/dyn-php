<?php

namespace Dyn\TrafficManagement\Api;

class Response
{
    /**
     * @var integer
     */
    public $job_id;

    /**
     * Response status. One of 'success', 'incomplete', 'failure'
     *
     * @var string
     */
    public $status;

    /**
     * @var array
     */
    public $msgs;

    /**
     * @var stdClass
     */
    public $data;

    /**
     * Builds a Response instance from the supplied JSON data
     *
     * @param  stdClass $json
     * @return Response
     */
    public static function fromJson($json)
    {
        $response = new Response();
        $response->job_id = $json->job_id;
        $response->status = $json->status;
        $response->msgs = $json->msgs;
        $response->data = $json->data;

        return $response;
    }

    /**
     * Returns true if the API request was successfully completed
     *
     * @return boolean
     */
    public function isComplete()
    {
        return $this->status == 'success';
    }

    /**
     * Returns true if the API request was valid (including queued actions)
     *
     * @return boolean
     */
    public function isOk()
    {
        return $this->status == 'success' || $this->status == 'incomplete';
    }
}
