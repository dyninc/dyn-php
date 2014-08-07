<?php
/**
 * This example retrieves an existing CNAME record and then deletes it
 */

require '../../vendor/autoload.php';

use Dyn\TrafficManagement;

$tm = new TrafficManagement('customerName', 'username', 'password');

// login
$tm->createSession();

// retrieve zone
$zone = $tm->getZone('example.com');

// retrieve the record(s) we want removed
$records = $zone->getRecords('CNAME', 'test.example.com');

// ensure we only got one back
if (count($records) == 1) {
    $record = $records[0];
} else {
    throw new Exception('Multiple records found, aborting');
}

// delete the record
$zone->deleteRecord($record);

// publish changes to the zone (makes the changes live)
$zone->publish();

// logout
$tm->deleteSession();
