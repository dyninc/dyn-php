<?php

namespace DynTest\TrafficManagement;

use PHPUnit_Framework_TestCase;
use Dyn\TrafficManagement\Zone;
use Dyn\TrafficManagement\Service\HTTPRedirect;
use Dyn\TrafficManagement\Service\DynamicDNS;
use Dyn\TrafficManagement\Record\SOA as SOARecord;
use Dyn\TrafficManagement\Record\A as ARecord;
use Dyn\TrafficManagement\Record\NS as NSRecord;
use Dyn\TrafficManagement\Record\MX as MXRecord;

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

    public function testGetAllRecords()
    {
        // simulate the Dyn API response
        $this->apiClient->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "success", "data": {"cname_records": [], "cert_records": [], "dname_records": [], "aaaa_records": [], "ipseckey_records": [], "loc_records": [], "ptr_records": [], "soa_records": [{"zone": "example.com", "ttl": 3600, "fqdn": "example.com", "record_type": "SOA", "rdata": {"rname": "user@example.com.", "retry": 600, "mname": "ns1.xx.dynect.net.", "minimum": 1800, "refresh": 3600, "expire": 604800, "serial": 1}, "record_id": 123456780, "serial_style": "increment"}], "kx_records": [], "dnskey_records": [], "naptr_records": [], "rp_records": [], "mx_records": [{"zone": "example.com", "ttl": 3600, "fqdn": "example.com", "record_type": "MX", "rdata": {"preference": 10, "exchange": "mail.example.com."}, "record_id": 123456781}], "key_records": [], "px_records": [], "ds_records": [], "sshfp_records": [], "ns_records": [{"zone": "example.com", "service_class": "", "ttl": 86400, "fqdn": "example.com", "record_type": "NS", "rdata": {"nsdname": "ns1.xx.dynect.net."}, "record_id": 123456782}, {"zone": "example.com", "service_class": "", "ttl": 86400, "fqdn": "example.com", "record_type": "NS", "rdata": {"nsdname": "ns2.xx.dynect.net."}, "record_id": 123456783}, {"zone": "example.com", "service_class": "", "ttl": 86400, "fqdn": "example.com", "record_type": "NS", "rdata": {"nsdname": "ns3.xx.dynect.net."}, "record_id": 123456784}, {"zone": "example.com", "service_class": "", "ttl": 86400, "fqdn": "example.com", "record_type": "NS", "rdata": {"nsdname": "ns4.xx.dynect.net."}, "record_id": 123456785}], "dhcid_records": [], "srv_records": [], "nsap_records": [], "txt_records": [], "spf_records": [], "a_records": [{"zone": "example.com", "ttl": 3600, "fqdn": "www.example.com", "record_type": "A", "rdata": {"address": "127.0.0.1"}, "record_id": 123456786}]}, "job_id": 987654321, "msgs": [{"INFO": "get_tree: Here is your zone tree", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

        // setup the exact data structure we expect to get back (a bit combersome)
        $records = array(
            'CNAME' => array(),
            'CERT' => array(),
            'DNAME' => array(),
            'AAAA' => array(),
            'IPSECKEY' => array(),
            'LOC' => array(),
            'PTR' => array(),
            'SOA' => array(),
            'KX' => array(),
            'DNSKEY' => array(),
            'NAPTR' => array(),
            'RP' => array(),
            'MX' => array(),
            'KEY' => array(),
            'PX' => array(),
            'DS' => array(),
            'SSHFP' => array(),
            'NS' => array(),
            'DHCID' => array(),
            'SRV' => array(),
            'NSAP' => array(),
            'TXT' => array(),
            'SPF' => array(),
            'A' => array()
        );

        $aRecord = new ARecord();
        $aRecord->setFqdn('www.example.com')
                ->setAddress('127.0.0.1')
                ->setTtl(3600)
                ->setId(123456786);

        $records['A'][] = $aRecord;

        $mxRecord = new MXRecord();
        $mxRecord->setFqdn('example.com')
                 ->setExchange('mail.example.com.')
                 ->setPreference(10)
                 ->setTtl(3600)
                 ->setId(123456781);

        $records['MX'][] = $mxRecord;

        $ns1 = new NSRecord();
        $ns1->setFqdn('example.com')
            ->setNsDName('ns1.xx.dynect.net.')
            ->setTtl(86400)
            ->setId(123456782);

        $ns2 = clone $ns1;
        $ns2->setNsDName('ns2.xx.dynect.net.')
            ->setId(123456783);

        $ns3 = clone $ns1;
        $ns3->setNsDName('ns3.xx.dynect.net.')
            ->setId(123456784);

        $ns4 = clone $ns1;
        $ns4->setNsDName('ns4.xx.dynect.net.')
            ->setId(123456785);

        $records['NS'][] = $ns1;
        $records['NS'][] = $ns2;
        $records['NS'][] = $ns3;
        $records['NS'][] = $ns4;

        $soa = new SOARecord();
        $soa->setRname('user@example.com.')
            ->setSerialStyle('increment')
            ->setFqdn('example.com')
            ->setTtl(3600)
            ->setId(123456780);

        $records['SOA'][] = $soa;


        $this->assertEquals(
            $records,
            $this->zone->getAllRecords()
        );
    }

    public function testGetNodeList()
    {
        // simulate the Dyn API response
        $this->apiClient->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "success", "data": ["foo.example.com", "bar.example.com"], "job_id": 12345678, "msgs": [{"INFO": "get_node_list: Here is your node list", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

       $this->assertEquals(
            array('foo.example.com', 'bar.example.com'),
            $this->zone->getNodeList()
        );
    }

    public function testGetNodeListWithFQDN()
    {
        // simulate the Dyn API response
        $this->apiClient->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"status": "success", "data": ["foo.example.com"], "job_id": 12345678, "msgs": [{"INFO": "get_node_list: Here is your node list", "SOURCE": "BLL", "ERR_CD": null, "LVL": "INFO"}]}'
        );

       $this->assertEquals(
            array('foo.example.com'),
            $this->zone->getNodeList('foo.example.com')
        );
    }
}
