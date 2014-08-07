<?php
/**
 * This example creates a new zone, adds some records to it, and then publishes.
 */

require '../../vendor/autoload.php';

use Dyn\TrafficManagement;
use Dyn\TrafficManagement\Record\A;
use Dyn\TrafficManagement\Record\MX;

$tm = new TrafficManagement('customerName', 'username', 'password');

// login
$tm->createSession();

// create new zone
$zone = $tm->createZone('example.com', 'user@example.com', 3600);

// add an A record to it
$record = new A();
$record->setFqdn('www.example.com')
       ->setAddress('127.0.0.1');

$zone->createRecord($record);

// add an MX record to it
$record = new MX();
$record->setFqdn('example.com')
       ->setPreference(10)
       ->setExchange('mail.example.com');

$zone->createRecord($record);

// publish (makes the zone live)
$zone->publish();

// logout
$tm->deleteSession();
