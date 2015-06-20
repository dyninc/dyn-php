<?php

namespace DynTest\MessageManagement\Api\Resource\Senders;

use PHPUnit_Framework_TestCase;
use DynTest\TestBootstrap;
use Dyn\MessageManagement\Api\Resource\Senders\Details;
use Dyn\MessageManagement\Sender;

class DetailsTest extends PHPUnit_Framework_TestCase
{
    protected $sender;
    protected $details;

    public function setUp()
    {
        $apiClient = TestBootstrap::getTestMMApiClient();
        $apiClient->setApiKey('xxxxxxxxxxxx');

        $this->sender = new Sender();
        $this->sender->setEmailAddress('test1@example.org');
        $this->details = new Details($apiClient);
    }

    public function testSenderDetails()
    {
        $apiKey = 'notarealapikey';

        $this->details->getApiClient()->setApiKey($apiKey);

        // simulate the Dyn API response
        $this->details->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"response":{"status":200,"message":"OK","data":{"emailaddress":"example@domain.com","spf":1,"dkim":1,"dkimval":"private","private._domainkey.example.org":"fakekey","_domainkey.example.org":"fakedkim"}}}'
        );

        $details = $this->details->get($this->sender);

        $this->assertEquals('private', $this->sender->getDkimIdentifier());
        $this->assertInternalType('array', $this->sender->getDkimRecords());
        $this->assertEquals(2,count($this->sender->getDkimRecords()));
        $this->assertTrue($this->sender->dkimIsVerified());
        $this->assertTrue($this->sender->spfIsVerified());
    }

}
