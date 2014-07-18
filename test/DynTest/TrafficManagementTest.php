<?php

namespace DynTest;

use PHPUnit_Framework_TestCase;
use Dyn\TrafficManagement;

class TrafficManagementTest extends PHPUnit_Framework_TestCase
{
    protected $tm;

    public function setUp()
    {
        $this->tm = new TrafficManagement('testcustomer', 'testusername', 'testpassword');
        $this->tm->setApiClient(TestBootstrap::getTestApiClient());
    }

    public function testLoadingNonExistentZoneReturnsFalse()
    {
        // simulate the Dyn API response
        $this->tm->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 404 Not Found"        . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "failure", "data": {}, "job_id": 12345678, "msgs": [{"INFO": "zone: No such zone", "SOURCE": "API-B", "ERR_CD": "NOT_FOUND", "LVL": "ERROR"}]});'
        );

        $this->assertFalse($this->tm->getZone('notarealzone.com'));
    }
}
