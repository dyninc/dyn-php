<?php
/**
 * This example sends a HTML email via. the API
 */

require '../../vendor/autoload.php';

use Dyn\MessageManagement;
use Dyn\MessageManagement\Mail;

$mm = new MessageManagement('YOUR API KEY');

// setup the message
$mail = new Mail();
$mail->setFrom('user@example.com', 'Joe Bloggs')
     ->setTo('janedoe@example.com')
     ->setSubject('HTML Email sent via. Dyn SDK')
     ->setTextBody('The text of the email')
     ->setHTMLBody('<html><head><title>Email</title></head><body>The text of the HTML email</body></html>');

// send it
$mm->send($mail);
