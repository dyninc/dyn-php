<?php
/**
 * This example retrieves all bounced messages for a given 24 hour period
 */

require '../../vendor/autoload.php';

use Dyn\MessageManagement;
use Dyn\MessageManagement\Mail;

$mm = new MessageManagement('YOUR API KEY');

// setup date ranges
$start = new DateTime('2014-08-01 00:00:00');
$end = new DateTime('2014-08-02 00:00:00');

// get report
$report = $mm->reports()->getBounces(0, $start, $end);
