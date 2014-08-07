<?php
/**
 * This example creates a Dynamic DNS service on a zone
 */

require '../../vendor/autoload.php';

use Dyn\TrafficManagement;
use Dyn\TrafficManagement\Service\DynamicDNS;

$tm = new TrafficManagement('customerName', 'username', 'password');

// login
$tm->createSession();

// retrieve zone
$zone = $tm->getZone('example.com');

// configure the new service
$service = new DynamicDNS();
$service->setAddress('127.0.0.1'); // initial IP address
        ->setRecordType('A'); // 'A' or 'AAAA'
        ->setUsername('dyndns'); // update client user (will be created)

// create the new service on test.example.com
$zone->createService($service, 'dyndns.example.com');

// publish changes
$zone->publish();

// logout
$tm->deleteSession();
