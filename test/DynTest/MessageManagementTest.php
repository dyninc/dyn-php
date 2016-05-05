<?php

namespace DynTest;

use PHPUnit_Framework_TestCase;
use Dyn\MessageManagement;
use Dyn\MessageManagement\Mail;
use Zend\Http\Client as HttpClient;

class MessageManagementTest extends PHPUnit_Framework_TestCase
{
    protected $mm;

    public function setUp()
    {
        $apiClient = TestBootstrap::getTestMMApiClient();
        $apiClient->setApiKey('xxxxxxxxxxxx');

        $this->mm = new MessageManagement('xxxxxxxxxxxx');
        $this->mm->setApiClient($apiClient);
    }

    public function testSend()
    {
        // simulate the Dyn API response
        $this->mm->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"response":{"status":200,"message":"OK","data":"250 2.1.5 Ok"}}'
        );

        $mail = new Mail();
        $mail->setFrom('user@example.com', 'Joe Bloggs')
             ->setTo('janedoe@example.com')
             ->setSubject('Email sent via. Dyn SDK')
             ->setBody('The text of the email');

        $result = $this->mm->send($mail);

        $this->assertTrue($result);
    }

    public function testRecipientIsRequired()
    {
        $this->setExpectedException('RuntimeException');

        $mail = new Mail();
        $mail->setFrom('user@example.com', 'Joe Bloggs')
             ->setSubject('Email sent via. Dyn SDK')
             ->setBody('The text of the email');

        $result = $this->mm->send($mail);
    }

    public function testSenderIsRequired()
    {
        $this->setExpectedException('RuntimeException');

        $mail = new Mail();
        $mail->setTo('janedoe@example.com')
             ->setSubject('Email sent via. Dyn SDK')
             ->setBody('The text of the email');

        $result = $this->mm->send($mail);
    }

    public function testSubjectIsRequired()
    {
        $this->setExpectedException('RuntimeException');

        $mail = new Mail();
        $mail->setFrom('user@example.com', 'Joe Bloggs')
             ->setTo('janedoe@example.com')
             ->setBody('The text of the email');

        $result = $this->mm->send($mail);
    }

    public function testBodyIsRequired()
    {
        $this->setExpectedException('RuntimeException');

        $mail = new Mail();
        $mail->setFrom('user@example.com', 'Joe Bloggs')
             ->setTo('janedoe@example.com')
             ->setSubject('Email sent via. Dyn SDK');

        $result = $this->mm->send($mail);
    }

    public function testCustomHttpClientCanBeUsed()
    {
        $config = array(
            'adapter' => 'Zend\Http\Client\Adapter\Test',
            'useragent' => 'Dyn Custom Http Client',
        );
        $customHttpClient = new HttpClient(null, $config);

        $mm = new MessageManagement('xxxxxxxxxxxx', $customHttpClient);

        $this->assertEquals($customHttpClient, $mm->getApiClient()->getHttpClient());
    }

    public function testCustomHttpClientArrayConfigurationCanBeUsed()
    {
        $httpConfig = array(
            'adapter' => 'Zend\Http\Client\Adapter\Test',
            'useragent' => 'Dyn Custom array configured Http Client',
            'timeout' => 30
        );
        $mm = new MessageManagement('xxxxxxxxxxxx', $httpConfig);

        $customHttpClient = new HttpClient(null, $httpConfig);

        $this->assertEquals($customHttpClient, $mm->getApiClient()->getHttpClient());
    }
}
