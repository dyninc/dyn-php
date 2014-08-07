<?php
/**
 * This example creates a HTTP Redirect service on a zone
 */

require '../../vendor/autoload.php';

use Dyn\TrafficManagement;
use Dyn\TrafficManagement\Service\HTTPRedirect;

$tm = new TrafficManagement('customerName', 'username', 'password');

// login
$tm->createSession();

// retrieve zone
$zone = $tm->getZone('example.com');

// configure the new service
$service = new HTTPRedirect();
$service->setUri('http://example.com/someotherurl')
        ->setCode(301)
        ->setKeepUri(false);

// create the new service on test.example.com
$zone->createService($service, 'test.example.com');

// logout
$tm->deleteSession();
