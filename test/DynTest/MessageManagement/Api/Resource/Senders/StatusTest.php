<?php

namespace DynTest\MessageManagement\Api\Resource\Senders;

use PHPUnit_Framework_TestCase;
use DynTest\TestBootstrap;
use Dyn\MessageManagement\Api\Resource\Senders\Status;
use Dyn\MessageManagement\Sender;

class StatusTest extends PHPUnit_Framework_TestCase
{
    protected $sender;
    protected $status;

    public function setUp()
    {
        $apiClient = TestBootstrap::getTestMMApiClient();
        $apiClient->setApiKey('xxxxxxxxxxxx');

        $this->sender = new Sender();
        $this->sender->setEmailAddress('test1@example.org');
        $this->status = new Status($apiClient);
    }

    public function testSenderIsReady()
    {
        $apiKey = 'notarealapikey';

        $this->status->getApiClient()->setApiKey($apiKey);

        // simulate the Dyn API response
        $this->status->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"response":{"status":200,"message":"OK","data":{"ready":1}}}'
        );

        $status = $this->status->get($this->sender);

        $this->assertInternalType('bool', $status);
        $this->assertTrue($this->sender->isReady());
    }

    public function testSenderNotReady()
    {
        $apiKey = 'notarealapikey';

        $this->status->getApiClient()->setApiKey($apiKey);

        // simulate the Dyn API response
        $this->status->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"response":{"status":200,"message":"OK","data":{"ready":0}}}'
        );

        $status = $this->status->get($this->sender);

        $this->assertInternalType('bool', $status);
        $this->assertFalse($this->sender->isReady());
    }

}
