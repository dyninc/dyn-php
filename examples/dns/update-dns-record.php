<?php
/**
 * This example retrieves an existing CNAME record and modifies it
 */

require '../../vendor/autoload.php';

use Dyn\TrafficManagement;

$tm = new TrafficManagement('customerName', 'username', 'password');

// login
$tm->createSession();

// retrieve zone
$zone = $tm->getZone('example.com');

// retrieve the record(s) we want to change
$records = $zone->getRecords('CNAME', 'test.example.com');

// ensure we only got one back
if (count($records) == 1) {
    $record = $records[0];
} else {
    throw new Exception('Multiple records found, aborting');
}

// make necessary changes
$record->setCName('somethingelse.example.com');

// update the zone
$zone->updateRecord($record);

// publish changes to the zone (makes the changes live)
$zone->publish();

// logout
$tm->deleteSession();
