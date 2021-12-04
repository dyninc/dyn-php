<?php

namespace DynTest\TrafficManagement\Api;

use PHPUnit\Framework\TestCase;
use Dyn\TrafficManagement\Api\Client;

class ClientTest extends TestCase
{
    public function testApiCallWithNoTokenThrowsException()
    {
        $this->expectException('Dyn\TrafficManagement\Api\Exception\NotAuthenticatedException');

        $client = new Client();
        $client->get('/foo');
    }
}
