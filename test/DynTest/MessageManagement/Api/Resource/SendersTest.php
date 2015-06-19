<?php

namespace DynTest\MessageManagement\Api\Resource;

use PHPUnit_Framework_TestCase;
use DynTest\TestBootstrap;
use Dyn\MessageManagement\Api\Resource\Senders;
use Dyn\MessageManagement\Sender;

class SendersTest extends PHPUnit_Framework_TestCase
{
    protected $senders;

    public function setUp()
    {
        $apiClient = TestBootstrap::getTestMMApiClient();
        $apiClient->setApiKey('xxxxxxxxxxxx');

        $this->senders = new Senders($apiClient);
    }

    public function testGetWithMultipleResults()
    {
        $apiKey = 'notarealapikey';

        $this->senders->getApiClient()->setApiKey($apiKey);

        // simulate the Dyn API response
        $this->senders->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"response":{"status":200,"message":"OK","data":{"senders":[{"emailaddress":"email1@example.org"},{"emailaddress":"email2@example.com"}]}}}'
        );

        $senders = $this->senders->get();

        $this->assertInternalType('array', $senders);

        foreach ($senders as $sender) {
            $this->assertInstanceOf('Dyn\MessageManagement\Sender', $sender);
            $this->assertTrue((in_array($sender->getEmailAddress(),array('email1@example.org','email2@example.com'))));
        }
    }
/*
    public function testCreate()
    {
        // simulate the Dyn API response
        $this->accounts->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"response":{"status":200,"message":"OK","data":{"apikey": "abcdefghijklmnopqrstuvwxyz"}}}'
        );

        $account = new Account();
        $account->setUsername('user@example.com')
                ->setPassword('notarealpassword')
                ->setCompanyName('Dyn')
                ->setPhone('603-123-1234');

        $result = $this->accounts->create($account);

        $this->assertInstanceOf('Dyn\MessageManagement\Account', $result);
        $this->assertEquals('abcdefghijklmnopqrstuvwxyz', $account->getApiKey());
    }

*/
}
