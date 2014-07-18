<?php

namespace Dyn\TrafficManagement\Service;

interface ServiceInterface
{
    /**
     * Returns the service type (a string). This should match the REST
     * resource name used for the service in the API (e.g. 'HttpRedirect')
     *
     * @return string
     */
    public function getType();

    /**
     * Returns an array of service params
     *
     * @return array
     */
    public function getParams();
}
