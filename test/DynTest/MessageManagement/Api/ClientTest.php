<?php

namespace DynTest\MessageManagement\Api;

use PHPUnit_Framework_TestCase;
use Dyn\MessageManagement\Api\Client;
use DynTest\TestBootstrap;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = TestBootstrap::getTestMMApiClient();
    }

    public function testApiCallWithNoApiKeyThrowsException()
    {
        $this->setExpectedException('Dyn\MessageManagement\Api\Exception\MissingOrInvalidApiKeyException');

        $client = new Client();
        $client->get('/foo');
    }

    public function testApiCallWithInvalidApiKeyThrowsException()
    {
        $this->setExpectedException('Dyn\MessageManagement\Api\Exception\MissingOrInvalidApiKeyException');

        // simulate the Dyn API response
        $this->client->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 451 Missing or Invalid API Key" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"response":{"status":451,"message":"Missing or Invalid API Key","data":{}}}'
        );

        $this->client->setApiKey('notarealapikey');
        $this->client->get('/accounts');
    }
}
