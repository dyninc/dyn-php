<?php
/**
 * This example sends a single email with X-Header values via. the API
 *
 * The example assumes two X-Headers have been configured in the user's
 * account - X-Campaign and X-Id
 */

require '../../vendor/autoload.php';

use Dyn\MessageManagement;
use Dyn\MessageManagement\Mail;

$mm = new MessageManagement('YOUR API KEY');

// setup the message
$mail = new Mail();
$mail->setFrom('user@example.com', 'Joe Bloggs')
     ->setTo('janedoe@example.com')
     ->setSubject('Email sent via. Dyn SDK with X-Headers')
     ->setBody('The text of the email')
     ->setXHeader('X-Campaign', 'Foo')
     ->setXHeader('X-Id', 123);

// send it
$mm->send($mail);
