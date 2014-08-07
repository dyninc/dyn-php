<?php
/**
 * This example sends a single email via. the API
 */

require '../../vendor/autoload.php';

use Dyn\MessageManagement;
use Dyn\MessageManagement\Mail;

$mm = new MessageManagement('YOUR API KEY');

// setup the message
$mail = new Mail();
$mail->setFrom('user@example.com', 'Joe Bloggs')
     ->setTo('janedoe@example.com')
     ->setSubject('Email sent via. Dyn SDK')
     ->setBody('The text of the email');

// send it
$mm->send($mail);
