<?php
/**
 * This example creates a single 'A' record and then publishes the changes
 */

require '../../vendor/autoload.php';

use Dyn\TrafficManagement;
use Dyn\TrafficManagement\Record\A;

$tm = new TrafficManagement('customerName', 'username', 'password');

// login
$tm->createSession();

// retrieve zone
$zone = $tm->getZone('example.com');

// configure the new record
$record = new A();
$record->setAddress('127.0.0.1');

// create the new record
$zone->createRecord($record, 'test.example.com');

// publish changes to the zone (makes the new record live)
$zone->publish();

// logout
$tm->deleteSession();
