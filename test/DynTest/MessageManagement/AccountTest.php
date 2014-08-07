<?php

namespace DynTest\MessageManagement;

use PHPUnit_Framework_TestCase;
use Dyn\MessageManagement\Account;

class AccountTest extends PHPUnit_Framework_TestCase
{
    public function testJsonParsing()
    {
        $json = json_decode('{"username":"username@example.com","accountname":"Dyn Test","companyname":"Dyn, Inc.","address":"Test address","city":"Test city","state":"NH","country":"US","zipcode":"","phone":"000-000-0000","usertype":"Master","created":"2013-06-15T12:15:05+00:00","apikey":"xxxxxxxxxxxx","timezone":"-0400","tracklinks":"1","trackopens":"1","testmode":"0","trackunsubscribes":"1","max_sample_count":null,"contactname":"Joe Bloggs","emailssent":0}');

        $account = Account::fromJson($json);

        $this->assertInstanceOf('Dyn\MessageManagement\Account', $account);
        $this->assertEquals('username@example.com', $account->getUsername());
        $this->assertEquals('Dyn, Inc.', $account->getCompanyName());
        $this->assertEquals('Test address', $account->getAddress());
        $this->assertEquals('Test city', $account->getCity());
        $this->assertEquals('NH', $account->getState());
        $this->assertEquals('US', $account->getCountry());
        $this->assertEquals('000-000-0000', $account->getPhone());
        $this->assertEquals('Master', $account->getUserType());
        $this->assertInstanceOf('DateTime', $account->getCreated());
        $this->assertEquals('xxxxxxxxxxxx', $account->getApiKey());
        $this->assertTrue($account->getTrackLinks());
        $this->assertTrue($account->getTrackOpens());
        $this->assertTrue($account->getTrackUnsubscribes());
        $this->assertEquals('Joe Bloggs', $account->getContactName());
    }

    public function testInvalidUsernameThrowsException()
    {
        $this->setExpectedException('InvalidArgumentException');

        $account = new Account();
        $account->setUsername('invalidusername');
    }

    public function testValidUsername()
    {
        $account = new Account();
        $account->setUsername('user@example.com');

        $this->assertEquals('user@example.com', $account->getUsername());
    }

}
