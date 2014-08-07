<?php

namespace DynTest\TrafficManagement\Api;

use PHPUnit_Framework_TestCase;
use Dyn\TrafficManagement\Api\Client;

class ClientTest extends PHPUnit_Framework_TestCase
{
    public function testApiCallWithNoTokenThrowsException()
    {
        $this->setExpectedException('Dyn\TrafficManagement\Api\Exception\NotAuthenticatedException');

        $client = new Client();
        $client->get('/foo');
    }
}
