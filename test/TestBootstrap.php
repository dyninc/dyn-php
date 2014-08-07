<?php

namespace DynTest;

error_reporting(E_ALL | E_STRICT);
chdir('../');

use Dyn\TrafficManagement\Api\Client as DnsApiClient;
use Dyn\MessageManagement\Api\Client as EmailApiClient;
use Zend\Http\Client\Adapter\Test as TestAdapter;
use Zend\Http\Client as HttpClient;

class TestBootstrap
{
    public static function init()
    {
        $autoloader = require 'vendor/autoload.php';
        $autoloader->add('Dyn', 'src');
    }

    /**
     * Returns an instance of the ApiClient for use in the Traffic Management
     * tests.
     *
     * The test API client has the test adapter already setup, to ease testing
     * and prevent calls to the live API servers.
     *
     * @return DnsApiClient
     */
    public static function getTestTMApiClient()
    {
        $adapter = new TestAdapter();
        $client = new HttpClient(
            'http://www.example.com',
            array(
                'adapter' => $adapter
            )
        );

        $apiClient = new DnsApiClient($client);

        // use a dummy token
        $apiClient->setToken('xxxxxxxx');

        return $apiClient;
    }

    /**
     * Returns an instance of the ApiClient for use in the Message
     * Management tests.
     *
     * The test API client has the test adapter already setup, to ease testing
     * and prevent calls to the live API servers.
     *
     * @return EmailApiClient
     */
    public static function getTestMMApiClient()
    {
        $adapter = new TestAdapter();
        $client = new HttpClient(
            'http://www.example.com',
            array(
                'adapter' => $adapter
            )
        );

        return new EmailApiClient($client);
    }
}

TestBootstrap::init();
