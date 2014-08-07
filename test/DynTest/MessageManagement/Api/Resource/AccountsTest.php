<?php

namespace DynTest\MessageManagement\Api\Resource;

use PHPUnit_Framework_TestCase;
use DynTest\TestBootstrap;
use Dyn\MessageManagement\Api\Resource\Accounts;
use Dyn\MessageManagement\Account;

class AccountsTest extends PHPUnit_Framework_TestCase
{
    protected $accounts;

    public function setUp()
    {
        $apiClient = TestBootstrap::getTestMMApiClient();
        $apiClient->setApiKey('xxxxxxxxxxxx');

        $this->accounts = new Accounts($apiClient);
    }

    public function testGetAllResultParsing()
    {
        // simulate the Dyn API response
        $this->accounts->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"response":{"status":200,"message":"OK","data":{"accounts":[{"username":"username@example.com","accountname":"Dyn Test","companyname":"Dyn, Inc.","address":"","city":"","state":"","country":"","zipcode":"","phone":"000-000-0000","usertype":"Master","created":"2013-06-15T12:15:05+00:00","apikey":"xxxxxxxxxxxx","timezone":"-0400","tracklinks":"1","trackopens":"1","testmode":"0","trackunsubscribes":"1","max_sample_count":null,"contactname":"Joe Bloggs","emailssent":0},{"username":"user2@example.com","accountname":"Dyn Test Account 2","companyname":"Dyn Inc.","address":"","city":"","state":"","country":"","zipcode":"","phone":"000-000-0000","usertype":"Sub","created":"2013-09-21T10:16:14+00:00","apikey":"","timezone":"-0400","tracklinks":"0","trackopens":"0","testmode":"0","trackunsubscribes":"0","max_sample_count":null,"contactname":"Jane Doe","emailssent":820}],"emailcap":"100000"}}}'
        );

        $accounts = $this->accounts->getAll();

        $this->assertInternalType('array', $accounts);
        $this->assertArrayHasKey(1, $accounts);
        $this->assertInstanceOf('Dyn\MessageManagement\Account', $accounts[1]);
    }

    public function testGetWithSingleResult()
    {
        $apiKey = 'notarealapikey';

        $this->accounts->getApiClient()->setApiKey($apiKey);

        // simulate the Dyn API response
        $this->accounts->getApiClient()->getHttpClient()->getAdapter()->setResponse(
"HTTP/1.1 200 OK" . "\r\n" .
"Content-type: application/json" . "\r\n\r\n" .
'{"response":{"status":200,"message":"OK","data":{"accounts":[{"username":"user1@example.com","accountname":"Dyn Test","companyname":"Dyn, Inc.","address":"","city":"","state":"","country":"","zipcode":"","phone":"000-000-0000","usertype":"Master","created":"2013-06-15T12:15:05+00:00","apikey":"'.$apiKey.'","timezone":"-0400","tracklinks":"1","trackopens":"1","testmode":"0","trackunsubscribes":"1","max_sample_count":null,"contactname":"Joe Bloggs","emailssent":0},{"username":"user2@example.com","accountname":"Dyn Test Account 2","companyname":"Dyn Inc.","address":"","city":"","state":"","country":"","zipcode":"","phone":"000-000-0000","usertype":"Sub","created":"2013-09-21T10:16:14+00:00","apikey":"","timezone":"-0400","tracklinks":"0","trackopens":"0","testmode":"0","trackunsubscribes":"0","max_sample_count":null,"contactname":"Jane Doe","emailssent":820}],"emailcap":"100000"}}}'
        );

        $account = $this->accounts->get();

        $this->assertInstanceOf('Dyn\MessageManagement\Account', $account);
        $this->assertEquals('user1@example.com', $account->getUsername());
        $this->assertEquals($apiKey, $account->getApiKey());
    }

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

    public function testCreateRequiresUsername()
    {
        $this->setExpectedException('RuntimeException');

        $account = new Account();
        $account->setPassword('notarealpassword')
                ->setCompanyName('Dyn')
                ->setPhone('603-123-1234');

        $result = $this->accounts->create($account);
    }
}
