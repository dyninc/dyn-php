<?php

namespace DynTest;

use PHPUnit_Framework_TestCase;
use Dyn\TrafficManagement;
use Zend\Http\Client as HttpClient;

class TrafficManagementTest extends PHPUnit_Framework_TestCase
{
    protected $tm;

    public function setUp()
    {
        $this->tm = new TrafficManagement('testcustomer', 'testusername', 'testpassword');
        $this->tm->setApiClient(TestBootstrap::getTestTMApiClient());
    }

    public function testSessionCreationPopulatesToken()
    {
        // create a random token to test against
        $exampleToken = md5('dyn'.time());

        // clear the existing token that was setup by the test bootstrap
        $this->tm->getApiClient()->setToken(null);

        // simulate the Dyn API response
        $this->tm->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "success", "data": {"token": "'.$exampleToken.'", "version": "3.5.8"}, "job_id": 12345678, "msgs": [{"INFO": "login: Login successful", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

        $this->assertTrue($this->tm->createSession());
        $this->assertEquals($exampleToken, $this->tm->getApiClient()->getToken());
    }

    public function testSessionCreationFailureReturnsFalse()
    {
        // clear the existing token that was setup by the test bootstrap
        $this->tm->getApiClient()->setToken(null);

        // simulate the Dyn API response
        $this->tm->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 400 Bad Request" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "failure", "data": {}, "job_id": 12345678, "msgs": [{"INFO": "login: Credentials you entered did not match those in our database. Please try again", "SOURCE": "BLL", "ERR_CD": "INVALID_DATA", "LVL": "ERROR"}, {"INFO": "login: Login failed", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

        $this->assertFalse($this->tm->createSession());
    }

    public function testLoadingNonExistentZoneReturnsFalse()
    {
        // simulate the Dyn API response
        $this->tm->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 404 Not Found" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "failure", "data": {}, "job_id": 12345678, "msgs": [{"INFO": "zone: No such zone", "SOURCE": "API-B", "ERR_CD": "NOT_FOUND", "LVL": "ERROR"}]});'
        );

        $this->assertFalse($this->tm->getZone('notarealzone.com'));
    }

    public function testCustomHttpClientCanBeUsed()
    {
        $config = array(
            'adapter' => 'Zend\Http\Client\Adapter\Test',
            'useragent' => 'Dyn Custom Http Client',
        );
        $customHttpClient = new HttpClient(null, $config);

        $tm = new TrafficManagement('testcustomer', 'testusername', 'testpassword', $customHttpClient);

        $this->assertEquals($customHttpClient, $tm->getApiClient()->getHttpClient());
    }

    public function testCustomHttpClientArrayConfigurationCanBeUsed()
    {
        $config = array(
            'adapter' => 'Zend\Http\Client\Adapter\Test',
            'useragent' => 'Dyn Custom array configured Http Client',
            'timeout' => 30
        );
        $tm = new TrafficManagement('testcustomer', 'testusername', 'testpassword', $config);

        $customHttpClient = new HttpClient(null, $config);

        $this->assertEquals($customHttpClient, $tm->getApiClient()->getHttpClient());
    }
}
