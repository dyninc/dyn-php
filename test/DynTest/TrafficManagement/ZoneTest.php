<?php

namespace DynTest\TrafficManagement;

use PHPUnit_Framework_TestCase;
use Dyn\TrafficManagement\Zone;
use Dyn\TrafficManagement\Service\HTTPRedirect;
use Dyn\TrafficManagement\Service\DynamicDNS;

class ZoneTest extends PHPUnit_Framework_TestCase
{
    protected $apiClient;

    protected $zone;

    public function setUp()
    {
        $this->apiClient = \DynTest\TestBootstrap::getTestTMApiClient();

        $this->zone = new Zone($this->apiClient);
        $this->zone->setName('example.com');
    }

    public function testHttpRedirectServiceCreation()
    {
        $httpRedirect = new HTTPRedirect();
        $httpRedirect->setUrl('http://example.com/other')
                     ->setCode(302)
                     ->setKeepUri(false);

        // simulate the Dyn API response
        $this->apiClient->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "success", "data": {"url": "http://example.com/other", "code": "302", "keep_uri": "False", "fqdn": "test.example.com", "zone": "example.com"}, "job_id": 12345678, "msgs": [{"INFO": "add_node: New node added to zone", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}, {"INFO": "add: Service added", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

        $this->assertInstanceOf(
            'Dyn\TrafficManagement\Service\HTTPRedirect',
            $this->zone->createService($httpRedirect, 'test.example.com')
        );
    }

    public function testHttpRedirectServiceUpdate()
    {
        $httpRedirect = new HTTPRedirect();
        $httpRedirect->setFqdn('test.example.com')
                     ->setUrl('http://example.com/somethingelse')
                     ->setCode(302)
                     ->setKeepUri(false);

        // simulate the Dyn API response
        $this->apiClient->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "success", "data": {"url": "http://example.com/somethingelse", "code": "302", "keep_uri": "", "fqdn": "test.example.com", "zone": "example.com"}, "job_id": 12345678, "msgs": [{"INFO": "update: Update successful", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

    }

    public function testHttpRedirectServiceDeletion()
    {
        $httpRedirect = new HTTPRedirect();
        $httpRedirect->setFqdn('test.example.com')
                     ->setUrl('http://example.com/somethingelse')
                     ->setCode(302)
                     ->setKeepUri(false);

        // simulate the Dyn API response
        $this->apiClient->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "success", "data": {"url": "http://example.com/somethingelse", "code": "302", "keep_uri": "", "fqdn": "test.example.com", "zone": "example.com"}, "job_id": 12345678, "msgs": [{"INFO": "update: Update successful", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

        $this->assertTrue($this->zone->deleteService($httpRedirect, 'test.example.com'));
    }

    public function testDDNSServiceCreation()
    {
        $ddns = new DynamicDNS();
        $ddns->setAddress('127.0.0.1')
             ->setRecordType('A');

        // simulate the Dyn API response
        $this->apiClient->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "success", "data": {"abuse_count": "0", "last_updated": "0", "zone": "example.com", "fqdn": "dyndns.example.com", "record_type": "A", "address": "127.0.0.1", "active": "Y"}, "job_id": 12345678, "msgs": [{"INFO": "add_node: New node added to zone", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}, {"INFO": "add: Service added", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}, {"INFO": "service: You do not have any updater users to dynamically update this host.", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

        $this->assertInstanceOf(
            'Dyn\TrafficManagement\Service\DynamicDNS',
            $this->zone->createService($ddns, 'dyndns.example.com')
        );
    }

    public function testDDNSServiceCreationWithUser()
    {
        $ddns = new DynamicDNS();
        $ddns->setAddress('127.0.0.1')
             ->setRecordType('A')
             ->setUsername('dyndnsuser');

        // simulate the Dyn API response
        $this->apiClient->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "success", "data": {"new_user": {"status": "active", "password": "xyzxyz", "user_name": "868X1o-dyndnsuser", "group_name": ["UPDATE"]}, "ddns": {"abuse_count": "0", "last_updated": "0", "zone": "example.com", "fqdn": "dyndns.example.com", "record_type": "A", "address": "127.0.0.1", "active": "Y"}}, "job_id": 12345678, "msgs": [{"INFO": "add_node: New node added to zone", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}, {"INFO": "add: New updater 868X1o-dyndnsuser created.", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}, {"INFO": "update: User updated", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}, {"INFO": "add: Service added", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

        $this->assertInstanceOf(
            'Dyn\TrafficManagement\Service\DynamicDNS',
            $this->zone->createService($ddns, 'dyndns.example.com')
        );
    }
}
