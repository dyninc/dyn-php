<?php

namespace DynTest;

error_reporting(E_ALL | E_STRICT);
chdir('../');

use Dyn\TrafficManagement\Api\Client as ApiClient;
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
     * Returns an instance of the ApiClient with the test adapter already
     * setup.
     *
     * @return ApiClient
     */
    public static function getTestApiClient()
    {
        $adapter = new TestAdapter();
        $client = new HttpClient(
            'http://www.example.com',
            array(
                'adapter' => $adapter
            )
        );

        $apiClient = new ApiClient($client);

        // use a dummy token
        $apiClient->setToken('xxxxxx');

        return $apiClient;
    }
}

TestBootstrap::init();
